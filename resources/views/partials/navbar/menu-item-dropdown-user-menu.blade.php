@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

@use('\Carbon\Carbon','Carbon')
@use('Modules\JobRegisterManagement\App\Models\JobRegister','JobRegister')
@php($lastMonth = Carbon::now('Asia/Kolkata')->subMonthNoOverflow()->startOfMonth()->format('Y-m-d'))
@php($dayAfterTomorrow = Carbon::now()->addDays(2)->startOfDay()->format('Y-m-d'))
@php($jobRegister = JobRegister::with(['estimate.client','no_estimate.client'])->whereBetween('date', [$lastMonth, $dayAfterTomorrow])->orderBy('date')->get())
@php($job_registers_near_deadline = $jobRegister->where('status', 0)->whereIn('type', ['new','amendment']))
@php($job_registers_near_deadline_for_accounts = $jobRegister->where('status',1)->whereNull('bill_no'))

<li class="nav-item dropdown user-menu">
    @php ($tDate = Carbon::now()->format('Y-m-d'))
    {{-- CEO --}}
    @if((count($job_registers_near_deadline)>0 || count($job_registers_near_deadline_for_accounts)) && (Auth::user()->hasRole('CEO')))
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline)+count($job_registers_near_deadline_for_accounts)}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" id="notificationDropdown" style="overflow-y: auto;padding: 10px;width: 50rem;">
                <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline)+count($job_registers_near_deadline_for_accounts) }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach($job_registers_near_deadline as $notification)
                    @php($tDate = Carbon::parse($tDate)->format('Y-m-d'))
                    @php($notification->date = Carbon::parse($notification->date)->format('Y-m-d'))
                    @if($tDate > $notification->date)
                        <div class="callout callout-danger" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='red';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-ban mr-2" style="color: red;"></i> Job no <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> has crossed the delivery date <b  style="font-size: 20px">{{ $tDate != $notification->date ? Carbon::parse($notification->date)->diffForHumans() : "today" }}.</b></a>
                        </div>
                    @else
                        @php($dValue = '')
                        @php($tDate = Carbon::parse($tDate))
                        @php($notificationDate = Carbon::parse($notification->date))
                        @if ($tDate != $notificationDate) 
                            @php($daysDiff = $tDate->diffInDays($notificationDate))
                            @php($dValue = $daysDiff == 2 ? 'day after tomorrow.' : 'tomorrow.')
                        @else
                            @php($dValue = 'today.')
                        @endif
                        <div class="callout callout-warning" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='#d39e00';" onmouseout="this.style.color='#4a5058';">
                                <i class="fas fa-exclamation-triangle mr-2" style="color: #d39e00;"></i> Deadline for Job no
                                <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> is
                                <b  style="font-size: 20px">
                                    {{$dValue}}
                                    {{-- {{ $tDate != $notification->date ? ($tDate->diffInDays(Carbon::parse($notification->date)->format('Y-m-d'))==2?'day after tomorrow':'tomorrow') : "today" }}. --}}
                                </b>
                            </a>
                        </div>
                    @endif
                @endforeach
                @foreach($job_registers_near_deadline_for_accounts as $notification)
                    <div class="callout callout-success" style="padding: 0.5rem;margin-bottom: 5px;">
                        <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='green';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-check mr-2" style="color: green;"></i> Job no: <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate?$notification->estimate->client->name:$notification->no_estimate->client->name }}</b> is ready for billing since <b>{{ $notification->updated_at->diffForHumans() }}</b></a>
                    </div>
                @endforeach
            </div>
        </li>
    {{-- Admin --}}
    @elseif(count($job_registers_near_deadline)>0 && Auth::user()->hasRole('Admin'))
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline)}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" id="notificationDropdown" style="overflow-y: auto;padding: 10px;width: 50rem;">
                <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline) }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach($job_registers_near_deadline as $notification)
                    @php($tDate = Carbon::parse($tDate)->format('Y-m-d'))
                    @php($notification->date = Carbon::parse($notification->date)->format('Y-m-d'))
                    @if($tDate > $notification->date)
                        <div class="callout callout-danger" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='red';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-ban mr-2" style="color: red;"></i> Job no <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> has crossed the delivery date <b  style="font-size: 20px">{{ $tDate != $notification->date ? Carbon::parse($notification->date)->diffForHumans() : "today" }}.</b></a>
                        </div>
                    @else
                        @php($dValue = '')
                        @php($tDate = Carbon::parse($tDate))
                        @php($notificationDate = Carbon::parse($notification->date))
                        @if ($tDate != $notificationDate) 
                            @php($daysDiff = $tDate->diffInDays($notificationDate))
                            @php($dValue = $daysDiff == 2 ? 'day after tomorrow.' : 'tomorrow.')
                        @else
                            @php($dValue = 'today.')
                        @endif
                        <div class="callout callout-warning" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='#d39e00';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-exclamation-triangle mr-2" style="color: #d39e00;"></i> Deadline for Job no <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> is 
                                <b  style="font-size: 20px">{{$dValue}}
                                {{-- {{ $tDate != $notification->date ? Carbon::parse($notification->date)->diffForHumans() : "today" }}. --}}
                                </b>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </li>
    {{-- PM --}}
    @elseif(count($job_registers_near_deadline)>0 && Auth::user()->hasRole('Project Manager'))
        @php ($job_registers_near_deadline = $job_registers_near_deadline->filter(function($pm){ return Auth::user()->id ==  $pm->handled_by_id; }))
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if(count($job_registers_near_deadline)>0)
                    <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline)}}</span>
                @endif 
            </a>
            <div class="dropdown-menu dropdown-menu-right" id="notificationDropdown" style="overflow-y: auto;padding: 10px;width: 50rem;">
                <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline) }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach($job_registers_near_deadline as $notification)
                    @php($tDate = Carbon::parse($tDate)->format('Y-m-d'))
                    @php($notification->date = Carbon::parse($notification->date)->format('Y-m-d'))
                    @if($tDate > $notification->date)
                        <div class="callout callout-danger" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='red';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-ban mr-2" style="color: red;"></i> Job no <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> has crossed the delivery date <b  style="font-size: 20px">{{ $tDate != $notification->date ? Carbon::parse($notification->date)->diffForHumans() : "today" }}.</b></a>
                        </div>
                    @else
                        @php($dValue = '')
                        @php($tDate = Carbon::parse($tDate))
                        @php($notificationDate = Carbon::parse($notification->date))
                        @if ($tDate != $notificationDate) 
                            @php($daysDiff = $tDate->diffInDays($notificationDate))
                            @php($dValue = $daysDiff == 2 ? 'day after tomorrow.' : 'tomorrow.')
                        @else
                            @php($dValue = 'today.')
                        @endif
                        <div class="callout callout-warning" style="padding: 0.5rem;margin-bottom: 5px;">
                            <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='#d39e00';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-exclamation-triangle mr-2" style="color: #d39e00;"></i> Deadline for Job no <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate? $notification->estimate->client->name:$notification->no_estimate->client->name }}</b> is 
                                <b style="font-size: 20px">{{$dValue}}
                                    {{-- {{ $tDate != $notification->date ? Carbon::parse($notification->date)->diffForHumans() : "today" }}. --}}
                                </b>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </li>
    {{-- Accounts --}}
    @elseif(count($job_registers_near_deadline_for_accounts)>0&&(Auth::user()->hasRole('Accounts')))
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline_for_accounts)}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" id="notificationDropdown" style="overflow-y: auto;padding: 10px;width: 50rem;">
                <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline_for_accounts) }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach($job_registers_near_deadline_for_accounts as $notification)
                    <div class="callout callout-success" style="padding: 0.5rem;margin-bottom: 5px;">
                        <a href="/job-card-management?jobNo={{$notification->sr_no}}" style="text-decoration: none;" onmouseover="this.style.color='green';" onmouseout="this.style.color='#4a5058';"><i class="fas fa-check mr-2" style="color: green;"></i> Job no: <b style="font-size: 20px">{{ $notification->sr_no }}</b> of <b style="font-size: 20px">{{ $notification->estimate?$notification->estimate->client->name:$notification->no_estimate->client->name }}</b> is ready for billing since <b>{{ $notification->updated_at->diffForHumans() }}</b></a>
                    </div>
                @endforeach
            </div>
        </li>
    @endif
</li>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('notificationDropdown');
        const notificationsCount = {{ count($job_registers_near_deadline) + count($job_registers_near_deadline_for_accounts) }};
        const notificationHeight = 50; // Approximate height of each notification item
        
        if (notificationsCount <= 10) {
            dropdown.style.maxHeight = `${notificationsCount * notificationHeight}px`;
        } else {
            dropdown.style.maxHeight = '500px'; // or any maximum height you prefer for scrolling
        }
    });
</script>


<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}"
                 class="user-image img-circle elevation-2"
                 alt="{{ Auth::user()->name }}">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
                @if(config('adminlte.usermenu_image'))
                    <img src="{{ Auth::user()->adminlte_image() }}"
                         class="img-circle elevation-2"
                         alt="{{ Auth::user()->name }}">
                @endif
                <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ Auth::user()->name }}
                    @if(config('adminlte.usermenu_desc'))
                        <small>{{ Auth::user()->adminlte_desc() }}</small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        {{-- @each('partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item') --}}

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if($profile_url)
                <a href="{{ $profile_url }}" class="nav-link btn btn-default btn-flat d-inline-block">
                    <i class="fa fa-fw fa-user text-lightblue"></i>
                    {{ __('menu.profile') }}
                </a>
            @endif
            <a class="btn btn-default btn-flat float-right @if(!$profile_url) btn-block @endif"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                {{ __('adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>

