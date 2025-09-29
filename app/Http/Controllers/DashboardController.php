<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard()
    {

       $dashboardData = DB::table('bookings')
        ->selectRaw('
            COUNT(*) AS total_bookings_this_month,
            COALESCE(SUM(CASE WHEN payment_status = "success" THEN total_payable ELSE 0 END), 0) AS total_amount,
            SUM(CASE 
                WHEN is_certificate_claimed = 1 AND certificate_file IS NOT NULL 
                THEN 1 ELSE 0 
            END) AS total_certificates_claimed
        ')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->first();

        $candidates=Candidate::where('currently_living_country','japan')->count();

        return view('dashboard.dashboard',compact('dashboardData','candidates'));
    }
}
