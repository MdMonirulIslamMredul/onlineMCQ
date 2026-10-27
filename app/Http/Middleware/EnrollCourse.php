<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Resolve student ID from Cookie, Auth, or numeric route parameter
        $cookieUserId = \Illuminate\Support\Facades\Cookie::get('user_id') ?: $request->cookie('user_id');
        $authUserId = Auth::id();
        $routeUserId = $request->route('userID');

        $userId = $cookieUserId ?: $authUserId;
        if (!$userId && is_numeric($routeUserId)) {
            $userId = (int) $routeUserId;
        }

        $courseId = $request->route('id');

        // Fetch user object to also match by phone or email if user_id wasn't directly linked in older order records
        $user = $userId ? DB::table('users')->where('id', $userId)->first() : null;

        // Check if the user has purchased and been verified for this course
        $hasPurchased = DB::table('courses_order')
            ->where(function($q) use ($courseId) {
                $q->where('pid', $courseId)->orWhere('course_id', $courseId);
            })
            ->where(function($q) use ($userId, $user) {
                if ($userId) {
                    $q->where('user_id', $userId);
                }
                if (!empty($user->phone)) {
                    $q->orWhere('phone', $user->phone);
                }
                if (!empty($user->email)) {
                    $q->orWhere('email', $user->email);
                }
            })
            ->where(function($q) {
                $q->where('status', 'enrolled')
                  ->orWhere('payment_status', 'paid');
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('notAllow', 'You have not enrolled in this course or your payment is currently pending manual verification.');
        }

        return $next($request);
    }
}
