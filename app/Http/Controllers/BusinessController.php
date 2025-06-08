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
            return response()->json(['success' => false, 'error' => 'Invalid action'], 400);
        }

        try {
            $status = $action === 'accept' ? 'accepted' : 'rejected';
            $form->update(['status' => $status]);

            $message = $action === 'accept' ? 'Referral form accepted successfully' : 'Referral form rejected successfully';
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to update status'], 500);
        }
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