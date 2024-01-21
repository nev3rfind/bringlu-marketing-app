<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Advert;
use App\Models\AdvertViews;
use App\Models\AdvertStatus;
use App\Mail\AdvertRequestEmail;
use App\Mail\MailNotify;
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
        // Pending requests count
        $requestsCount['pending'] = AdvertStatus::where('advertiser_id', Auth::user()->id)
        ->where('advert_status', 'pending')->count();
        // Confirmed requests count
        $requestsCount['confirmed'] = AdvertStatus::where('advertiser_id', Auth::user()->id)
        ->where('advert_status', 'confirmed')->count();
        // Rejected requests count
        $requestsCount['rejected'] = AdvertStatus::where('advertiser_id', Auth::user()->id)
        ->where('advert_status', 'rejected')->count();
        // Total requests count
        $requestsCount['all'] = AdvertStatus::where('advertiser_id', Auth::user()->id)->count();
        return view('advertiser.index')
        ->with([
            'adverts' => Advert::get(), 
            'requestsCount' => $requestsCount
        ]);
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
}
