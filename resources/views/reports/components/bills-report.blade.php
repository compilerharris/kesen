@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php 
    $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get();
    $config = [
        'title' => 'Select Client',
        'liveSearch' => true,
        'placeholder' => 'Search Client...',
        'showTick' => true,
        'actionsBox' => true,
        'closeOnSelect' => false,
    ];
    $statusConfig = [
        'title' => 'Select Billing Status',
        'liveSearch' => true,
        'placeholder' => 'Search Billing Status...',
        'showTick' => true,
        'actionsBox' => true,
    ];
@endphp
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
                <li class="breadcrumb-item active" aria-current="page">Client Bill Report</li>
                
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Client Bill Export" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('report.bills') }}" method="POST" target="_blank">
                @csrf
                <div class="row pt-2">
                    
                    <x-adminlte-select2 :config="$config" name="clients[]" id="clients" fgroup-class="col-md-3" value="{{ old('clients') }}" label="Client" multiple>
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 :config="$statusConfig" name="billingStatus" id="billingStatus" fgroup-class="col-md-3" value="{{ old('billingStatus') }}" label="Billing Status">
                        <option value="">Select Billing Status</option>
                        <option value="1">Paid</option>
                        <option value="2">Partially Paid</option>
                        <option value="3">Unpaid</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="from_date" placeholder="Date" fgroup-class="col-md-3" type='date'
                        value="{{ old('from_date', date('Y-m-d')) }}" required label="From Date" />
                    <x-adminlte-input name="to_date" placeholder="Date" fgroup-class="col-md-3" type='date'
                        value="{{ old('to_date', date('Y-m-d')) }}" required label="To Date" />
                </div>
                
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>