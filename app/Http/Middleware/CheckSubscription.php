<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('candidate')->user(); // assuming candidate guard

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Check if user has an active subscription
        $activeSubscription = UserSubscription::where('candidate_id', $user->id)
            ->where('status', 'confirmed')
            ->where('payment_status', 'success')
            ->first();

        if (!$activeSubscription) {
            return response()->json([
            'message' => 'You do not have an active subscription.',
            'subscription' => false,
            'success' => false,
            ], 403);
        }

        // return response()->json([
        //     'message' => 'You have an active subscription.',
        //     'subscription' => true,
        //     'success' => true,
        // ], 200);

        return $next($request);
    }
}
