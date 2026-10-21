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
        $userId = $request->route('userID');
        $courseId = $request->route('id'); // Assuming this is the course ID

        // Check if the user has purchased the course
        $hasPurchased = DB::table('courses_order')
        ->whereNotNull('transaction_id')
        ->where('pid', $courseId)
        ->exists();


        if (!$hasPurchased) {
            return back()->with('notAllow', 'You have not purchased this course.');
        }

        return $next($request);
    }
}
