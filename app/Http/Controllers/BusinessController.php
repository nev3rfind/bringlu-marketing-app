<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\Models\Advert;
use App\Models\AdvertViews;
use App\Models\AdvertStatus;
use App\Mail\AdvertRequestEmail;
use App\Mail\MailNotify;
use App\Models\DashboardCard;
use App\Models\DashboardCardValue;
use App\Models\ReferralForm;
use Illuminate\Support\Facades\Mail;
use PDF;

class BusinessController extends Controller
{
    /**
     * Display an index page for Business customer showing all referral forms
     *
     * @return ReferralForm model
     * @return $referralStats array
     */
    public function index()
    {
        $dashboardData = $this->getDashboardData();
        return view('business.index', $dashboardData);
    }
    
    private function getDashboardData()
    {
        // Get referral form statistics
        $referralStats = [
            'pending' => ReferralForm::where('status', 'pending')->count(),
            'accepted' => ReferralForm::where('status', 'accepted')->count(),
            'rejected' => ReferralForm::where('status', 'rejected')->count(),
            'viewed' => ReferralForm::where('viewed', true)->count(),
            'unviewed' => ReferralForm::where('viewed', false)->count(),
            'total' => ReferralForm::count()
        ];
        
        // Get all referral forms ordered by created date descending
        $referralForms = ReferralForm::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get dashboard cards for this user
        $dashboardCards = DashboardCard::where('is_active', true)
            ->orderBy('position')
            ->get()
            ->map(function ($card) {
                $activeValue = $card->getActiveValueForUser(Auth::user()->id);
                $card->current_value = $activeValue ? $activeValue->value : 'N/A';
                return $card;
            });

        return [
            'referralStats' => $referralStats,
            'referralForms' => $referralForms,
            'dashboardCards' => $dashboardCards
        ];
    }

    /**
     * Accepts request from the advertiser to advertise advert with the customer message
     *
     * @return Advertiser index page with status message
     */
    public function request(Request $request, Advert $advert)
    {
        // Validate if message field is not empty
        $request->validate([
            'extra_details' => 'required',
        ]);
        
        $advert_status['advertiser_id'] = Auth::user()->id;
        $advert_status['advert_id'] = $advert->id;
        $advert_status['user_id'] = $advert->user_id;
        // Advert status = pending (before advert owner confirms or rejects)
        $advert_status['advert_status'] = 'pending';
        $advert_status['extra_details'] = $request->extra_details;
        $advert_status['last_actioned_at'] = date('Y-m-d H:i:s');

        // Prevent inserting duplicates
        if(AdvertStatus::where('advertiser_id','=', $advert_status['advertiser_id'])
            ->where('advert_id','=', $advert_status['advert_id'])->exists()) {
                return redirect('/advertiser')->with('failed-requested', 'Advert already exist');
            } else {
                // Insert record to advertisers_ads_status table
                AdvertStatus::create($advert_status);
                // Send email to business customer (only can send to verified recipients within MailGun maling provider)
                try {
                    Mail::to('ddonatas70@gmail.com')->send(new AdvertRequestEmail);
                } catch (\Swift_TransportException $transportExp){
                    // ERROR sending email (do not break application)
                }
                 return redirect('/advertiser')->with('success-requested', 'Advert requested successfully');
            }
    }

    /**
     * Show adverts activity tracking page
     *
     * @return Advers activity page with all the advert requests that belongs to the authenticated user
     */
    public function activity()
    {
        // Get all adverts requests
        $advert_status = AdvertStatus::where('advertiser_id', Auth::user()->id)->get();
        return view('advertiser.activity')
        ->with([
            'advert_status' => $advert_status
        ]);
    }

    /**
     * Show advert details page for the requested advert
     *
     * @param  Request $request, Advert $advert
     * @return Advert details page and instructions how page need to be displayed ($requestForm)
     */
    public function show(Request $request, Advert $advert)
    {
        // Validate if user came from index or activity page
        $previousUrl = url()->previous();
        // Do not show request form and button in 'show' page
        if (strpos($previousUrl, 'advertiser/activity') !== false) {
            $requestForm = false;
        }
        // Show request form and button in the 'show' page
        else{
            $requestForm = true;
            $advert_view['advertiser_id'] =  Auth::user()->id;
            $advert_view['advert_id'] = $advert->id;
            $advert_view['user_id'] = $advert->user_id;
            $advert_view['viewed_at'] = date('Y-m-d H:i:s');
            // Create advertiser viewed ad record
            AdvertViews::create($advert_view);
        }
        
        return view('advertiser.show', [
            'advert' => $advert,
            'requestForm' =>$requestForm
        ]);
    }

    /**
     * Convert advert to PDF
     *
     * @param  Request $request, Advert $advert
     * @return Advert details HTML view converted to pdf and downloaded
     */
    public function convertToPdf(Request $request, Advert $advert)
    {
        // Load PDF view by passing model converted to array
       $pdf = PDF::loadView('advertiser.pdf', $advert->toArray());
        // Download returned view
       return $pdf->download('advert_details.pdf');
    }

    /**
     * Store a new referral form
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeReferralForm(Request $request)
    {
        $request->validate([
            'referral_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'address' => 'required|string',
            'template' => 'required|in:foxecom_commercial,foxecom_baked,foxecom_super_shopify',
            'expected_revenue' => 'required|numeric|min:0'
        ]);

        ReferralForm::create([
            'user_id' => Auth::user()->id,
            'referral_name' => $request->referral_name,
            'company' => $request->company,
            'address' => $request->address,
            'template' => $request->template,
            'expected_revenue' => $request->expected_revenue,
            'status' => 'pending',
            'viewed' => false
        ]);

        return redirect('/advertiser')->with('success-referral', 'Referral form submitted successfully');
    }

    /**
     * Update referral form status
     *
     * @param Request $request
     * @param ReferralForm $form
     * @param string $action
     * @return \Illuminate\Http\Response
     */
    public function updateReferralStatus(Request $request, ReferralForm $form, $action)
    {
        if (!in_array($action, ['accept', 'reject'])) {
            abort(404);
        }

        $status = $action === 'accept' ? 'accepted' : 'rejected';
        $form->update(['status' => $status]);

        $message = $action === 'accept' ? 'Referral form accepted successfully' : 'Referral form rejected successfully';
        return redirect()->back()->with('success', $message);
    }

    /**
     * View referral form and mark as viewed
     *
     * @param ReferralForm $form
     * @return \Illuminate\Http\Response
     */
    public function viewReferralForm(ReferralForm $form)
    {
        // Mark as viewed
        $form->update(['viewed' => true]);
        
        return response()->json([
            'success' => true,
            'form' => $form->load('user')
        ]);
    }
}