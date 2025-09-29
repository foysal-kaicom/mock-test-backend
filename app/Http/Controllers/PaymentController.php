<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificateClaimRequest;
use App\Models\CertificateClaim;
use App\Models\Payment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function list(Request $request)
    {
        $query = Payment::with('booking');
    
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking.candidate', function ($q) use ($search) {
                $q->where('booking_id', 'like', "%$search%");
            });
        }
    
        $payments = $query->latest()->get();
    
        return view('payment.list', compact('payments'));
    }

    
}
