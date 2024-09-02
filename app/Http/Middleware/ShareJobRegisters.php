<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Carbon\Carbon;

class ShareJobRegisters
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
        
        // $current = Carbon::now('Asia/Kolkata');

        // // Define the time ranges in IST

        // $startMorning = Carbon::parse('06:00', 'Asia/Kolkata')->format('Y-m-d');
        // $endAfternoon = Carbon::parse('19:00', 'Asia/Kolkata')->format('Y-m-d');

        // // Check if the current time is within the specified ranges
        // if ($current->between($startMorning, $endAfternoon)) {

            $deadline_3_days_date_start = Carbon::now()->addDays(3)->startOfDay()->format('Y-m-d');
            $deadline_3_days_date_end = Carbon::now()->addDays(3)->endOfDay()->format('Y-m-d');
            $deadline_2_days_date_start = Carbon::now()->addDays(2)->startOfDay()->format('Y-m-d');
            $deadline_2_days_date_end = Carbon::now()->addDays(2)->endOfDay()->format('Y-m-d');
            $deadline_1_days_date_start = Carbon::now()->addDays(1)->startOfDay()->format('Y-m-d');
            $deadline_1_days_date_end = Carbon::now()->addDays(1)->endOfDay()->format('Y-m-d');
            $deadline_date_start = Carbon::now()->startOfDay()->format('Y-m-d');
            $deadline_date_end = Carbon::now()->endOfDay()->format('Y-m-d');

            $job_registers_near_deadline = JobRegister::
                whereBetween('date', [$deadline_3_days_date_start, $deadline_3_days_date_end])
                ->orWhereBetween('date', [$deadline_2_days_date_start, $deadline_2_days_date_end])
                ->orWhereBetween('date', [$deadline_1_days_date_start, $deadline_1_days_date_end])
                ->orWhereBetween('date', [$deadline_date_start, $deadline_date_end])
                ->orderBy('sr_no','desc')
                ->get();

            View::share('job_registers_near_deadline', $job_registers_near_deadline);

            return $next($request);
        // } else {
        //     View::share('job_registers_near_deadline', []);
        //     return $next($request);
        // }
    }
}
