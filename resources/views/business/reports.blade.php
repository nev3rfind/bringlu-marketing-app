@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-foxecom-dark">Reports</h1>
    <p class="text-foxecom-gray">Quarterly referral and commission reports</p>
</div>

<x-alert />

<div class="container mx-auto px-4 py-8">
    <!-- Quarter Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-foxecom-dark mb-2">Q1 2025 Report</h2>
        <p class="text-foxecom-gray">01/01 - 31/03</p>
    </div>

    <!-- Reports Table -->
    <div class="foxecom-card p-6">
        <div class="foxecom-table-container">
            <table class="foxecom-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                    <tr>
                        <th scope="col" class="py-4 px-6 text-left font-bold text-foxecom-dark">Theme</th>
                        <th scope="col" class="py-4 px-6 text-center font-bold text-foxecom-dark">Total Referrals</th>
                        <th scope="col" class="py-4 px-6 text-center font-bold text-foxecom-dark">Total Commission</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-lg font-semibold text-foxecom-dark">Minimog</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-foxecom-orange">150</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-green-600">$4,500</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-lg font-semibold text-foxecom-dark">Megamog</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-foxecom-orange">120</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-green-600">$3,600</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                <span class="text-lg font-semibold text-foxecom-dark">Zest</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-foxecom-orange">85</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-green-600">$2,550</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-lg font-semibold text-foxecom-dark">Sleek</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-foxecom-orange">95</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-green-600">$2,850</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200 border-b-2 border-foxecom-orange">
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-lg font-semibold text-foxecom-dark">Hyper</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-foxecom-orange">110</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-2xl font-bold text-green-600">$3,300</span>
                        </td>
                    </tr>
                    <!-- Total Row -->
                    <tr class="bg-foxecom-light border-t-2 border-foxecom-orange">
                        <td class="py-6 px-6">
                            <span class="text-xl font-bold text-foxecom-dark">TOTAL</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-3xl font-bold text-foxecom-orange">560</span>
                        </td>
                        <td class="py-6 px-6 text-center">
                            <span class="text-3xl font-bold text-green-600">$16,800</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="foxecom-card p-6 text-center">
            <div class="text-3xl font-bold text-foxecom-orange mb-2">560</div>
            <div class="text-foxecom-gray">Total Referrals</div>
            <div class="text-sm text-green-600 mt-2">↗ +12% from Q4 2024</div>
        </div>
        <div class="foxecom-card p-6 text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">$16,800</div>
            <div class="text-foxecom-gray">Total Commission</div>
            <div class="text-sm text-green-600 mt-2">↗ +18% from Q4 2024</div>
        </div>
        <div class="foxecom-card p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">$30</div>
            <div class="text-foxecom-gray">Avg. Commission</div>
            <div class="text-sm text-green-600 mt-2">↗ +5% from Q4 2024</div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('business.index') }}" class="foxecom-btn-secondary">
            Back to Dashboard
        </a>
    </div>
</div>

<style>
/* FoxEcom inspired styling */
.foxecom-table tbody tr:hover {
    background-color: #FFF7ED;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.1);
}

.foxecom-table th {
    background: linear-gradient(135deg, #FF6B35 0%, #FF8A65 100%);
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
}

.foxecom-table td {
    border-bottom: 1px solid #F3F4F6;
}

/* Animated number counters */
@keyframes countUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.foxecom-table td span {
    animation: countUp 0.6s ease-out;
}

/* Gradient text for totals */
.text-gradient {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection