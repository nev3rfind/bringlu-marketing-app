<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// For IP Request
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Auth;
use Carbon\Carbon;
use App\Models\AdvertCategory;
use App\Models\AdvertMedia;
use App\Models\Advert;
use App\Models\AdvertStatus;
use App\Models\AdvertViews;
use App\Models\User;
use App\Models\ReferralForm;

class BusinessController extends Controller
{
    /**
     * Show all adverts which belongs to that authenticated user
     *
     * // Displays: create advert view with data for the dropdowns
     * // Returns: advert create view with advert categories, media types and user`s IP address
     * @return Auth::user adverts and their count, requestsCount and campaign views
     */
    public function index(Request $request)
    {
        // Pending requests count
        $requestsCount['pending'] = AdvertStatus::where('user_id', Auth::user()->id)
        ->where('advert_status', 'pending')->count();
        // Confirmed requests count
        $requestsCount['confirmed'] = AdvertStatus::where('user_id', Auth::user()->id)
        ->where('advert_status', 'confirmed')->count();
        // Rejected requests count
        $requestsCount['rejected'] = AdvertStatus::where('user_id', Auth::user()->id)
        ->where('advert_status', 'rejected')->count();
        // All requests count
        $requestsCount['all'] = AdvertStatus::where('user_id', Auth::user()->id)->count();
        // Total campaigns views by advetisers
        $campaignsViews = AdvertViews::where('user_id', Auth::user()->id)->count();

        return view('business.index')
            ->with([
                'adverts' => Auth::user()->adverts()->get(), 
                'advertsCount' => Auth::user()->adverts()->count(),
                'requestsCount' => $requestsCount,
                'campaignsViews' => $campaignsViews
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * // Displays create advert view with data for the dropdowns
     * // Returns: advert create view with advert categories, media types and user`s IP address
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('business.create')
            ->with([
                'advertCategories' => AdvertCategory::get(),
                'mediaTypes' => AdvertMedia::get(),
                'userIp' => $request->ip()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Store created advert details in the adverts table
    // Returns: home page view with success message
    public function store(Request $request)
    {
        // check if checkbox was ticked or no
      if (!$request->has('current_status'))
     {
         $current_status = 0;
     }
     else {
         $current_status = 1;
     }
     $start_date = $request->start_date;
     $end_date = $request->end_date;

     $start_date = date('Y-m-d H:i:s',strtotime($start_date));
     $end_date = date('Y-m-d H:i:s',strtotime($end_date));

     $request->validate([
        'advert_media_id' => 'required|not_in:0',
        'advert_category_id' => 'required|not_in:0',
        'advert_name' => 'required|max:255',
        'industry' => 'required|max:255',
        'start_date' => 'required',
        'end_date' => 'required',
        'description' => 'required',
        'priority_level' => 'required|not_in:0',
        'comments' => 'required',
        'web_url' => 'required',
        'max_advertisers_count' => 'required|numeric',
     ]);

     $data = $request->all();
     $data['user_id'] = Auth::user()->id;
     $data['start_date'] = $start_date;
     $data['end_date'] = $end_date;
     $data['current_status'] = $current_status;
     $advert = Advert::create($data);

     return redirect('/business')->with('success-created', 'Advert created successfully');
    }

    /**
     * Display the advert details page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Show the selected advert details according the advert_id
    // Returns: advert show page with that advert details returned from the database
    public function show(Request $request, Advert $advert)
    {
        return view('business.show', [
            'advert' => $advert
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Show the edit view for the selected advert
    // Returns: advert edit view with data for dropdowns and form prepopulation
    public function edit(Request $request, Advert $advert)
    {
        return view('business.edit')
            ->with([
                'advertCategories' => AdvertCategory::get(),
                'mediaTypes' => AdvertMedia::get(),
                'advert' => $advert
            ]);
    }

    /**
     * Updates the advert details 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Updates the selected advert record in the database
    // Returns: home page with success message popup
    public function update(Request $request, $id)
    {
        
        if (!$request->has('current_status'))
     {
         $current_status = 0;
     }
     else {
         $current_status = 1;
     }

     // Get data excluding method and token property
     $data = $request->except('_method', '_token');
     $data['current_status'] = $current_status;
   
     Advert::where('id', $id)->update($data);
        return redirect('/business')->with('success-updated', 'Advert updated successfully');
    }

    /**
     * Remove the given advert from the database
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Deletes selected advert
    // Returns: home page with success message
    public function destroy($id)
    {
        Advert::where('id', $id)->delete();
        return redirect('/business')->with('success-deleted', 'Advert deleted successfully');
    }

    /**
     * Show pending adverts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Shows pending ads
    // Returns: pending ads view
    public function showPending()
    {
        // Get pending adverts that belongs to authenticated business customer
        $pendingAdverts = AdvertStatus::where('user_id', Auth::user()->id)
            ->where('advert_status', 'pending')->get();

        return view('business.pending-ads')
            ->with([
                'pendingAdverts' => $pendingAdverts
            ]);
    }

    /**
     * Confirm pending advert
     *
     * @param  int $userId, int $advertId
     * @return Pendign advert views with status message
     */
    // Shows pending ads
    // Returns: pending ads view
    public function confirmPending($userId, $advertId)
    {
        try {
            // Try to find and update record
            AdvertStatus::where('advert_id', $advertId)
            ->where('user_id', $userId)
                ->update(array(
                    'advert_status' => 'confirmed',
                    'last_actioned_at' => date('Y-m-d H:i:s')
                ));

                // Succesfully updated the record
                return redirect('/business/ads/pending')->with('advert-confirm', 'Advert confirmed successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // Inform user if query failed to execute
            return redirect('/business/ads/pending')->with('advert-update-failed', 'Advert query failed');
        }
    }

    /**
     * Reject pending advert
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Rejects requested advert
    // Returns: pending ads view with the status message
    public function rejectPending($userId, $advertId)
    {
        try {
            // Try to find and update record
            AdvertStatus::where('advert_id', $advertId)
            ->where('user_id', $userId)
                ->update(array(
                    'advert_status' => 'rejected',
                    'last_actioned_at' => date('Y-m-d H:i:s')
                ));

                return redirect('/business/ads/pending')->with('advert-reject', 'Advert rejected successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // Inform user if query failed to execute
            return redirect('/business/ads/pending')->with('advert-update-failed', 'Advert query failed');
        }
        
    }

    /**
     * Show active adverts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Shows active ads
    // Returns: active ads view
    public function showActive()
    {
        // Get active adverts that belongs to authenticated business customer
        $activeAdverts = AdvertStatus::where('user_id', Auth::user()->id)
            ->where('advert_status', 'confirmed')->get();

        return view('business.active-ads')
            ->with([
                'activeAdverts' => $activeAdverts
            ]);
    }

    /**
     * Show all adverts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Shows all ads
    // Returns: all ads view
    public function showAll()
    {
        // Get all adverts that belongs to authenticated business customer with all requests
        $allAdverts = AdvertStatus::where('user_id', Auth::user()->id)->get();

        return view('business.all-ads')
            ->with([
                'allAdverts' => $allAdverts
            ]);
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
}