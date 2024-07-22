@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@if ($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid')
@endif

{{-- Default Content Wrapper --}}
<div class="{{ $layoutHelper->makeContentWrapperClasses() }}">

    {{-- Preloader Animation (cwrapper mode) --}}
    @if ($preloaderHelper->isPreloaderEnabled('cwrapper'))
        @include('partials.common.preloader')
    @endif

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="content" style="padding-top: 20px; margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Bill Report</li>
                
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Bill Export" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('report.bills') }}" method="POST" target="_blank">
                @csrf
                <div class="row pt-2">
                    
                    <x-adminlte-input name="from_date" placeholder="Date" fgroup-class="col-md-6" type='date'
                        value="{{ old('from_date', date('Y-m-d')) }}" required label="From Date" />

                    <x-adminlte-input name="to_date" placeholder="Date" fgroup-class="col-md-6" type='date'
                        value="{{ old('to_date', date('Y-m-d')) }}" required label="To Date" />
                   


                </div>
                
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>