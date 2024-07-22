<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Carbon\Carbon;

class ShareJobRegistersAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current = Carbon::now('Asia/Kolkata');

        // Define the time ranges in IST

        $start_time = Carbon::now('Asia/Kolkata')->subHours(1);
        $end_time = Carbon::now('Asia/Kolkata');

        // Check if the current time is within the specified ranges
        if ($current->between($start_time, $end_time)) {


            $job_registers_near_deadline_for_accounts = JobRegister::where('status',1)->whereBetween('updated_at', [$start_time, $end_time])
                ->get();


            View::share('job_registers_near_deadline_for_accounts', $job_registers_near_deadline_for_accounts);

            return $next($request);
        } else {
            View::share('job_registers_near_deadline_for_accounts', []);
            return $next($request);
        }
    }
}
