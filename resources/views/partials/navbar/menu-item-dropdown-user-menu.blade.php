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

<li class="nav-item dropdown user-menu">


    {{-- User menu dropdown --}}
    @if(isset($job_registers_near_deadline)&&(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('Developer')))
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            @if(count($job_registers_near_deadline)>0)
                <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline)}}</span>
            @endif 
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline) }} Notifications</span>
            <div class="dropdown-divider"></div>
            @foreach($job_registers_near_deadline as $notification)
                <p class="dropdown-item" style="display: flex; align-items: center;">
                    <i class="fas fa-envelope mr-2" style="margin: 0; padding: 0;"></i>
                    <span class="notification-text" style="margin: 0; padding: 0; margin-left: 8px; display: flex; flex-wrap: wrap;">
                    @if(Auth::user()->hasRole('Accounts'))
                        Job no: {{ $notification->sr_no }} of {{ $notification->estimate->client->name }} is ready for billing
                    @endif    
                    @if(Auth::user()->hasRole('Admin'))
                        Deadline for Job no {{ $notification->sr_no }} of {{ $notification->estimate->client->name }} is at {{ $notification->date }}
                    @endif
                    </span>
                    
                    
                </p>
              
            @endforeach
            <div class="dropdown-divider"></div>
            
        </div>
    </li>
    @endif
    @if(isset($job_registers_near_deadline_for_accounts)&&(Auth::user()->hasRole('Accounts')))
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            
            @if(count($job_registers_near_deadline_for_accounts)>0)
                <span class="badge badge-danger navbar-badge">{{count($job_registers_near_deadline_for_accounts)}}</span>
            @endif 
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{count($job_registers_near_deadline_for_accounts) }} Notifications</span>
            <div class="dropdown-divider"></div>
            @foreach($job_registers_near_deadline_for_accounts as $notification)
                <p class="dropdown-item" style="display: flex; align-items: center;">
                    <i class="fas fa-envelope mr-2" style="margin: 0; padding: 0;"></i>
                    <span class="notification-text" style="margin: 0; padding: 0; margin-left: 8px; display: flex; flex-wrap: wrap;">
                        Job no: {{ $notification->sr_no }} of {{ $notification->estimate->client->name }} is ready for billing
                   
                    </span>
                    
                    <p style="float: right;margin-right: 10px">
                    {{ $notification->updated_at->diffForHumans() }}
                    </p>
                </p>
              
            @endforeach
            <div class="dropdown-divider"></div>
            
        </div>
    </li>
    @endif
    

</li>


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

