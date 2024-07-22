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
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
                <li class="breadcrumb-item ">Job {{$bill_data->sr_no}}</li>
                <li class="breadcrumb-item ">Edit Bill</li>
            </ol>
        </nav>
        <x-adminlte-card title="Bill Details" theme="success"  icon="fas fa-lg fa-language"
    >
    

        <form action="{{ route('jobcardmanagement.bill.update',$bill_data->id) }}" method="POST" >
            @csrf
            @method('PUT')
            <div class="row pt-2">
                <x-adminlte-input name="client_name"  placeholder="Client Name"
                    fgroup-class="col-md-2" required value="{{$bill_data->estimate->client->name ?? '' }}" type='text' label="Client Name" disabled/>
                <x-adminlte-input name="bill_date"  placeholder="Bill Date"
                    fgroup-class="col-md-2" required value="{{$bill_data->bill_date}}" type='date' label="Bill Date" />
                    <x-adminlte-input name="bill_no"  placeholder="Bill No"
                    fgroup-class="col-md-2" required value="{{$bill_data->bill_no}}" type='text' label="Bill No" />
                    <x-adminlte-input name="bill_amount"  placeholder="Bill Amount" 
                    fgroup-class="col-md-2" value="{{$bill_data->bill_amount}}" type='number' label="Bill Amount" min="0"/>
                    
                    <x-adminlte-input name="po_number"  placeholder="PO Number"
                    fgroup-class="col-md-2"   type='text' label="PO Number" value="{{$bill_data->po_number}}"/>
                    <x-adminlte-input name="sent_date"  placeholder="Sent Date"
                    fgroup-class="col-md-2" required value="{{ $bill_data->sent_date}}" type='date' label="Sent Date" />
                    
                    
                    <x-adminlte-select name="payment_status" fgroup-class="col-md-2" required
                    value="{{ old('payment_status') }}" label="Payment Status" id="payment_status">
                        <option value="">Select Payment Status</option>
                        <option value="Paid" @if ($bill_data->payment_status == 'Paid') selected @endif>Paid</option>
                        <option value="Partial" @if ($bill_data->payment_status == 'Partial') selected @endif>Partial</option>
                        <option value="Unpaid" @if ($bill_data->payment_status == 'Unpaid') selected @endif>Unpaid</option>
                    </x-adminlte-select>
                    <span id="status" class="col-md-2">
                        @if ($bill_data->payment_status == 'Paid'||$bill_data->payment_status == 'Partial')
                        <div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="paymentdate">Payment Date</label><br><div class="input-group"><input name="payment_date" class="form-control" required type="date" value="{{ $bill_data->payment_date }}" ></div></div> 
                        @endif
                    </span>
                    <span id="amount_paid" class="col-md-2">
                        @if ($bill_data->payment_status == 'Paid'||$bill_data->payment_status == 'Partial')
                        <div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="payment">Payment Amount</label><br><div class="input-group"><input name="paid_amount" class="form-control" required type="number" min="0" value="{{ $bill_data->paid_amount }}" placeholder="Payment Amount"></div></div> 
                        @endif
                    </span>
                    
            </div>
            
            <x-adminlte-button label="Update" type="submit" class="mt-3" value="Update"/>

        </form>
    </x-adminlte-card>
    </div>

</div>
<script>
    $(document).on('change', '#payment_status', function() {
       if(this.value == 'Paid' || this.value == 'Partial') {
           $('#status').css("display", "block");
           $('#amount_paid').css("display", "block");
           document.getElementById('status').innerHTML =
               '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="payment_date">Payment Date</label><br><div class="input-group"><input name="payment_date" class="form-control" required type="date" ></div></div>';
           document.getElementById('amount_paid').innerHTML ='<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="payment">Payment Amount</label><br><div class="input-group"><input name="paid_amount" class="form-control" required type="number" min="0" placeholder="Payment Amount"></div></div>';
       } else {
           $('#status').css("display", "none");
           $('#amount_paid').css("display", "none");
           
       }

   });
</script>
                    