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
        $job_registers_near_deadline_for_accounts = JobRegister::where('status',1)->whereNull('bill_no')->get();
        View::share('job_registers_near_deadline_for_accounts', $job_registers_near_deadline_for_accounts);
        return $next($request);
    }
}
