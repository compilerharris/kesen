@extends('master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <style>
        .custom-main{
            display: flex;
            height: 100%;
            width: 100%;
            align-items: center;
            background-color:white;
        }
        .custom-body-left{
            width: 50%;
            /* background-image: url('{{ asset('img/login-bg.svg') }}'); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #28a745;
        }
        .custom-body-right{
            width: 50%;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        @media only screen and (max-width: 1080px) {
            .custom-body-left {
                display: none;
            }
            .custom-body-right {
                width: 100%; /* Make the right section take full width */
            }
        }
    </style>
    <div class="custom-main">
        <div class="custom-body-left">
            <img src="{{asset('img/login-left-bg.png')}}" style="width: 100%" alt="">
            <!-- <img src="{{asset('img/login-bg.png')}}" alt=""> -->
        </div>
        <div class="custom-body-right">
            <div class="{{ $auth_type ?? 'login' }}-box" style="margin: 0 auto;width: 50%;">
    
                {{-- Logo --}}
                <div class="{{ $auth_type ?? 'login' }}-logo mb-4">
                    <a href="{{ $dashboard_url }}">
        
                        {{-- Logo Image --}}
                        @if (config('adminlte.auth_logo.enabled', false))
                            <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                                alt="{{ config('adminlte.auth_logo.img.alt') }}"
                                @if (config('adminlte.auth_logo.img.class', null))
                                    class="{{ config('adminlte.auth_logo.img.class') }}"
                                @endif
                                @if (config('adminlte.auth_logo.img.width', null))
                                    width="{{ config('adminlte.auth_logo.img.width') }}"
                                @endif
                                @if (config('adminlte.auth_logo.img.height', null))
                                    height="{{ config('adminlte.auth_logo.img.height') }}"
                                @endif>
                        @else
                            <img src="{{ asset(config('adminlte.logo_img')) }}"
                                alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                        @endif
        
                        {{-- Logo Label --}}
                        {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
        
                    </a>
                </div>
                {{-- Card Box --}}
                <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
        
                    {{-- Card Header --}}
                    @hasSection('auth_header')
                        <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                            <h3 class="card-title float-none text-center">
                                @yield('auth_header')
                            </h3>
                        </div>
                    @endif
        
                    {{-- Card Body --}}
                    <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                        @yield('auth_body')
                    </div>
        
                    {{-- Card Footer --}}
                    @hasSection('auth_footer')
                        <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                            @yield('auth_footer')
                        </div>
                    @endif
        
                </div>
            </div>    
        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
