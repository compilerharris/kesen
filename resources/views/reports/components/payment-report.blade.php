@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php 
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->get(); 
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
        
        @include('components.notification')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Payment Report</li>
                
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Payment Report" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('report.payments') }}" method="POST" target="_blank">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select name="writer" fgroup-class="col-md-4" required value="{{ old('writer') }}"
                        label="Writer">
                        <option value="">Select Writer</option>
                        @foreach ($writers as $writer)
                            <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="year" fgroup-class="col-md-4" label="Year" required>
                        <option value="" >Select Year</option>
                        @for ($i=0;$i<100;$i++)
                            @if($i<10)
                                <option value="200{{$i}}" >200{{$i}}</option>
                            @else
                                <option value="20{{$i}}" >20{{$i}}</option>
                            @endif
                        @endfor
                    </x-adminlte-select>
                    <x-adminlte-select name="month" fgroup-class="col-md-4" label="Month" required>
                        <option value="">Select Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>    
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </x-adminlte-select>
                    
                   


                </div>
                
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>