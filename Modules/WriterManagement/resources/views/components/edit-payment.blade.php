@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><a href="/writer-management">Writer </a></li>
                <li class="breadcrumb-item active" ><a href="/writer-management/{{$id}}/edit">{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}</a></li>
                <li class="breadcrumb-item " ><a href="/writer-management/{{$id}}/view-payments">View Payment</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$payment->created_at}}</li>
            </ol>
        </nav>
        @include('components.notification')
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Payment" theme="info">
            <form action="{{ route('writermanagement.editPayment', [$id, $payment->id]) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="row pt-2">
                        <x-adminlte-select name="payment_method" placeholder="Payment Method" fgroup-class="col-md-3" required
                        label="Payment Method">
                        <option value="NEFT" {{ old('payment_method', $payment->payment_method) == 'NEFT' ? 'selected' : '' }}>NEFT
                        </option>
                        <option value="Cheque" {{ old('payment_method', $payment->payment_method) == 'Cheque' ? 'selected' : '' }}>Cheque
                        </option>
                        <option value="Cash" {{ old('payment_method', $payment->payment_method) == 'Cash' ? 'selected' : '' }}>Cash
                        </option>
                        
                        
                    </x-adminlte-select>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-3" required label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}" @if ($payment->metrix == $metric->id) selected @endif>
                                {{ $metric->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select  id="apply_gst" name="apply_gst" placeholder="Apply GST" fgroup-class="col-md-3" required
                        label="Apply GST" onchange="onDateChange()">
                        <option value="0" {{ old('apply_gst', $payment->apply_gst) == 0 ? 'selected' : '' }}>No
                        </option>
                        <option value="1" {{ old('apply_gst', $payment->apply_gst) == 1 ? 'selected' : '' }}>Yes
                        </option>
                    </x-adminlte-select>
                    <x-adminlte-select id="apply_tds" name="apply_tds" placeholder="Apply TDS" fgroup-class="col-md-3" required
                        label="Apply TDS" onchange="onDateChange()">
                        <option value="0" {{ old('apply_tds', $payment->apply_tds) == 0 ? 'selected' : '' }}>No
                        </option>
                        <option value="1" {{ old('apply_tds', $payment->apply_tds) == 1 ? 'selected' : '' }}>Yes
                        </option>
                    </x-adminlte-select>
                    <x-adminlte-input id="period_from" name="period_from" label="Period From" fgroup-class="col-md-3" type="date"
                        required value="{{ old('period_from', $payment->period_from) }}" 
                        onchange="onDateChange()" />
                    <x-adminlte-input id="period_to" name="period_to" label="Period To" fgroup-class="col-md-3" type="date" required
                        value="{{ old('period_to', $payment->period_to) }}" 
                         onchange="onDateChange()"/>
                    <x-adminlte-input name="online_ref_no" placeholder="Online REF no" fgroup-class="col-md-3"
                        value="{{ old('online_ref_no', $payment->online_ref_no) }}" label="Online REF no" />
                    <x-adminlte-input name="cheque_no" placeholder="Cheque no" fgroup-class="col-md-3"
                        value="{{ old('cheque_no', $payment->cheque_no) }}" label="Cheque no" />
                    <x-adminlte-input id="performance_charge" name="performance_charge" placeholder="Performance Charge" fgroup-class="col-md-3"
                        type="number" step="1" 
                        value="{{ old('performance_charge', $payment->performance_charge) }}"
                        label="Performance Charge" onkeyup="onDateChange()"/>
                    <x-adminlte-input id="deductible" name="deductible" placeholder="Deductible" fgroup-class="col-md-3" type="number"
                        step="0.01"  value="{{ old('deductible', $payment->deductible) }}"
                        label="Deductible" onkeyup="onDateChange()"/>
                    <x-adminlte-input id="amount" name="total_amount" placeholder="Amount" fgroup-class="col-md-3" type="number"
                        value="{{ old('total_amount', $payment->total_amount) }}" label="Amount" min=0 required readonly/>
                </div>
                <x-adminlte-button label="Update" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>



<script type="text/javascript">
    function onDateChange() {
        let from = $('#period_from').val();
            let to = $('#period_to').val();
            
            $.ajax({
                url: "/writer-management/calculatePayment",
                method: 'POST',
                data: {
                    period_from: from,
                    period_to: to,
                    _token: "{{ csrf_token() }}",
                    id: "{{ $id }}",
                    apply_gst: $('#apply_gst').val(),
                    apply_tds: $('#apply_tds').val(),
                    performance_charge: $('#performance_charge').val(),
                    deductible: $('#deductible').val(),
                },
                success: function(data) {
                    $('#amount').val(data);
                }
            });
    }
    
</script>