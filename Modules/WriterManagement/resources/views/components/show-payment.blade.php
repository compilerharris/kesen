@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

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
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <x-adminlte-card title="Payment Details" theme="success">
            <form>
                <div class="row pt-2">
                    
                    <x-adminlte-input name="payment_method" label="Payment Method" fgroup-class="col-md-3" disabled value="{{ $payment->payment_method }}" label="Payment Method"/>
                    <x-adminlte-input name="metrix" label="Metrix" fgroup-class="col-md-3" disabled value="{{ $payment->metrix }}" label="Metrix"/>
                    <x-adminlte-select name="apply_gst" label="Apply GST" fgroup-class="col-md-3" disabled label="Apply GST">
                        <option value="0" {{ $payment->apply_gst == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $payment->apply_gst == 1 ? 'selected' : '' }}>Yes</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="apply_tds" label="Apply TDS" fgroup-class="col-md-3" disabled label="Apply TDS">
                        <option value="0" {{ $payment->apply_tds == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $payment->apply_tds == 1 ? 'selected' : '' }}>Yes</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="period_from" label="Period From" fgroup-class="col-md-3" type="date" disabled value="{{ $payment->period_from }}" label="Period From"/>
                    <x-adminlte-input name="period_to" label="Period To" fgroup-class="col-md-3" type="date" disabled value="{{ $payment->period_to }}" label="Period To"/>
                    <x-adminlte-input name="online_ref_no" label="Online REF no" fgroup-class="col-md-3" disabled value="{{ $payment->online_ref_no }}" label="Online REF no"/>
                    <x-adminlte-input name="cheque_no" label="Cheque no" fgroup-class="col-md-3" disabled value="{{ $payment->cheque_no }}" label="Cheque no"/>
                    <x-adminlte-input name="performance_charge" label="Performance Charge" fgroup-class="col-md-3" type="number" step="0.01" disabled value="{{ $payment->performance_charge }}" label="Performance Charge"/>
                    <x-adminlte-input name="deductible" label="Deductible" fgroup-class="col-md-3" type="number" step="0.01" disabled value="{{ $payment->deductible }}" label="Deductible"/>
                </div>
                <a href="{{ route('writermanagement.viewPayments',[$payment->writer_id,$payment->id]) }}" class="btn btn-default mt-3">Back</a>
            </form>
        </x-adminlte-card>
    </div>
</div>
