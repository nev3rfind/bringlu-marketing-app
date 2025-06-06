<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\ClientDashboard;
use App\Models\DashboardHistory;
use App\Models\ClientForm;
use Carbon\Carbon;

class ClientsController extends Controller
{
    /**
     * Show all clients (advertisers) for business customers
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        // Get all users with account_type = 1 (advertisers)
        $clients = User::where('account_type', 1)->get();
        
        return view('business.clients.index', compact('clients'));
    }

    /**
     * Show client dashboard management page
     *
     * @param int $clientId
     * @return \Illuminate\Http\Response
     */
    public function manageDashboard($clientId)
    {
        $client = User::findOrFail($clientId);
        
        // Get or create dashboard for this client
        $dashboard = ClientDashboard::firstOrCreate(
            ['user_id' => $clientId],
            [
                'earnings' => '0.00',
                'profit' => '0.00',
                'revenue' => '0.00',
                'pay_date' => 'Not set',
                'total' => '0.00',
                'status' => 'Active'
            ]
        );

        // Get dashboard history
        $history = DashboardHistory::where('user_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('business.clients.dashboard', compact('client', 'dashboard', 'history'));
    }

    /**
     * Update dashboard card value
     *
     * @param Request $request
     * @param int $clientId
     * @return \Illuminate\Http\Response
     */
    public function updateDashboard(Request $request, $clientId)
    {
        $request->validate([
            'field' => 'required|in:earnings,profit,revenue,pay_date,total,status',
            'value' => 'required|string|max:255'
        ]);

        $dashboard = ClientDashboard::where('user_id', $clientId)->first();
        $oldValue = $dashboard->{$request->field};

        // Save to history before updating
        DashboardHistory::create([
            'user_id' => $clientId,
            'field_name' => $request->field,
            'old_value' => $oldValue,
            'new_value' => $request->value,
            'updated_by' => Auth::id()
        ]);

        // Update dashboard
        $dashboard->update([
            $request->field => $request->value
        ]);

        return redirect()->back()->with('success', 'Dashboard updated successfully');
    }

    /**
     * Show client forms management page
     *
     * @param int $clientId
     * @return \Illuminate\Http\Response
     */
    public function manageForms($clientId)
    {
        $client = User::findOrFail($clientId);
        $forms = ClientForm::where('user_id', $clientId)->orderBy('created_at', 'desc')->get();

        return view('business.clients.forms', compact('client', 'forms'));
    }

    /**
     * Show create form page
     *
     * @param int $clientId
     * @return \Illuminate\Http\Response
     */
    public function createForm($clientId)
    {
        $client = User::findOrFail($clientId);
        return view('business.clients.create-form', compact('client'));
    }

    /**
     * Store new form
     *
     * @param Request $request
     * @param int $clientId
     * @return \Illuminate\Http\Response
     */
    public function storeForm(Request $request, $clientId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'fields' => 'required|array',
            'fields.*' => 'required|string'
        ]);

        ClientForm::create([
            'user_id' => $clientId,
            'title' => $request->title,
            'description' => $request->description,
            'fields' => json_encode($request->fields),
            'status' => 'pending',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('clients.forms', $clientId)->with('success', 'Form created successfully');
    }

    /**
     * Show edit form page
     *
     * @param int $clientId
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function editForm($clientId, $formId)
    {
        $client = User::findOrFail($clientId);
        $form = ClientForm::where('user_id', $clientId)->findOrFail($formId);

        return view('business.clients.edit-form', compact('client', 'form'));
    }

    /**
     * Update form
     *
     * @param Request $request
     * @param int $clientId
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $clientId, $formId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'fields' => 'required|array',
            'fields.*' => 'required|string',
            'status' => 'required|in:pending,submitted,accepted,rejected'
        ]);

        $form = ClientForm::where('user_id', $clientId)->findOrFail($formId);
        
        $form->update([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => json_encode($request->fields),
            'status' => $request->status
        ]);

        return redirect()->route('clients.forms', $clientId)->with('success', 'Form updated successfully');
    }

    /**
     * Show client dashboard (for logged in advertisers)
     *
     * @return \Illuminate\Http\Response
     */
    public function clientDashboard()
    {
        $userId = Auth::id();
        
        // Get dashboard data
        $dashboard = ClientDashboard::where('user_id', $userId)->first();
        
        // Get forms for this client
        $forms = ClientForm::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('advertiser.client-dashboard', compact('dashboard', 'forms'));
    }

    /**
     * Show form for client to fill
     *
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function showClientForm($formId)
    {
        $form = ClientForm::where('user_id', Auth::id())->findOrFail($formId);
        
        if ($form->status !== 'pending') {
            return redirect()->back()->with('error', 'This form is no longer available for editing');
        }

        return view('advertiser.fill-form', compact('form'));
    }

    /**
     * Submit form response
     *
     * @param Request $request
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function submitForm(Request $request, $formId)
    {
        $form = ClientForm::where('user_id', Auth::id())->findOrFail($formId);
        
        $request->validate([
            'responses' => 'required|array'
        ]);

        $form->update([
            'responses' => json_encode($request->responses),
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return redirect()->route('advertiser.dashboard')->with('success', 'Form submitted successfully');
    }
}