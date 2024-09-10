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
        
        // $current = Carbon::now('Asia/Kolkata')->format('Y-m-d');
        // $lastMonth = Carbon::now('Asia/Kolkata')->subMonthNoOverflow()->startOfMonth()->format('Y-m-d');

        // $dayAfterTomorrow = Carbon::now()->addDays(2)->startOfDay()->format('Y-m-d');
        // $deadline_date_end = Carbon::now()->format('Y-m-d');

        // $jobRegister = JobRegister::
        //     whereBetween('date', [$lastMonth, $dayAfterTomorrow])
        //     ->orderBy('date')
        //     ->get();
        // $job_registers_near_deadline = $jobRegister->where('status', 0)->whereIn('type', ['new','amendment']);

        // $job_registers_near_deadline_for_accounts = $jobRegister->where('status',1)->whereNull('bill_no');

        // View::share('job_registers_near_deadline', $job_registers_near_deadline);
        // View::share('job_registers_near_deadline_for_accounts', $job_registers_near_deadline_for_accounts);

        return $next($request);
    }
}
