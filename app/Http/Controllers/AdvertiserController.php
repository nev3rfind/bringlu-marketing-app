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

class AdvertiserController extends Controller
{
    /**
     * Display an index page for Advertiser customer showing all Adverts campaigns
     *
     * @return Advert model
     * @return $requestsCount array
     */
    public function index()
    {
        $dashboardData = $this->getDashboardData();
        return view('advertiser.index', $dashboardData);
    }
    
    private function getDashboardData()
    { 
        // Get dashboard cards for this user
        $dashboardCards = DashboardCard::where('is_active', true)
            ->orderBy('position')
            ->get()
            ->map(function ($card) {
                $activeValue = $card->getActiveValueForUser(Auth::user()->id);
                $card->current_value = $activeValue ? $activeValue->value : 'N/A';
                return $card;
            });
        
        // Get referral forms for this user
        $referralForms = ReferralForm::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get referral form statistics for this user
        $referralStats = [
            'pending' => ReferralForm::where('user_id', Auth::user()->id)->where('status', 'pending')->count(),
            'accepted' => ReferralForm::where('user_id', Auth::user()->id)->where('status', 'accepted')->count(),
            'rejected' => ReferralForm::where('user_id', Auth::user()->id)->where('status', 'rejected')->count(),
            'total' => ReferralForm::where('user_id', Auth::user()->id)->count()
        ];

        return [
            'dashboardCards' => $dashboardCards,
            'referralForms' => $referralForms,
            'referralStats' => $referralStats
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
        try {
            $validatedData = $request->validate([
                'referral_details' => 'required|string',
                'theme_type' => 'required|in:minimog,megamog,other',
                'other_theme' => 'required_if:theme_type,other|string|max:255',
                'purchase_email' => 'required|email|max:255',
                'license_code' => 'required|string|max:255',
                'shopify_store_url' => 'nullable|url|max:255'
            ]);

            $referralForm = ReferralForm::create([
                'user_id' => Auth::user()->id,
                'referral_details' => $validatedData['referral_details'],
                'theme_type' => $validatedData['theme_type'],
                'other_theme' => $validatedData['theme_type'] === 'other' ? $validatedData['other_theme'] : null,
                'purchase_email' => $validatedData['purchase_email'],
                'license_code' => $validatedData['license_code'],
                'shopify_store_url' => $validatedData['shopify_store_url'] ?? null,
                'status' => 'pending',
                'viewed' => false
            ]);

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Referral form submitted successfully!',
                    'form_id' => $referralForm->id
                ]);
            }

            // Fallback for non-AJAX requests
            return redirect('/advertiser')->with('success-referral', 'Referral form submitted successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors as JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Referral form submission error: ' . $e->getMessage());

            // Return error response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting the form. Please try again.'
                ], 500);
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->with('error', 'An error occurred while submitting the form. Please try again.');
        }
    }

    /**
     * View referral form details (for advertiser - read only)
     *
     * @param ReferralForm $form
     * @return \Illuminate\Http\Response
     */
    public function viewReferralForm(ReferralForm $form)
    {
        // Check if the form belongs to the authenticated user
        if ($form->user_id !== Auth::user()->id) {
            abort(403);
        }
        
        return response()->json([
            'success' => true,
            'form' => $form->load('user')
        ]);
    }
}