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
                <!-- <li class="breadcrumb-item ">Job {{$job_no}}</li> -->
                <li class="breadcrumb-item ">Add Bill for Job {{$job_no}}</li>
            </ol>
        </nav>
        <x-adminlte-card title="Bill Details" theme="success"  icon="fas fa-lg fa-language">
    

        <form action="{{ route('jobcardmanagement.bill.store',$job_id) }}" method="POST" >
            @csrf
            <div class="row pt-2">
                <x-adminlte-input name="client_name"  placeholder="Client Name"
                    fgroup-class="col-md-2" required value="{{$job->estimate->client->name ?? '' }}" type='text' label="Client Name" disabled/>
                <x-adminlte-input name="bill_date"  placeholder="Bill Date"
                    fgroup-class="col-md-2" required value="{{ old('bill_date') }}" type='date' label="Bill Date" />
                    <x-adminlte-input name="bill_no"  placeholder="Bill No" 
                    fgroup-class="col-md-2" required value="{{ old('bill_no') }}" type='text' label="Bill No" />
                    <x-adminlte-input name="bill_amount"  placeholder="Bill Amount" 
                    fgroup-class="col-md-2" value="{{ old('bill_no') }}" type='number' label="Bill Amount" min="0"/>
                    
                    <x-adminlte-input name="po_number"  placeholder="PO Number"
                    fgroup-class="col-md-2"   type='text' label="PO Number" />
                    
                    <x-adminlte-input name="sent_date"  placeholder="Sent Date"
                    fgroup-class="col-md-2" required value="{{ old('sent_date') }}" type='date' label="Sent Date" />
                    
                    
                    <x-adminlte-select name="payment_status" fgroup-class="col-md-2" required
                    value="{{ old('payment_status') }}" label="Payment Status" id="payment_status">
                        <option value="">Select Payment Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Partial">Partial</option>
                        <option value="Unpaid" selected>Unpaid</option>
                    </x-adminlte-select>
                    <span id="status" class="col-md-2">

                    </span>
                    <span id="amount_paid" class="col-md-2">

                    </span>
                    
            </div>
            
            <x-adminlte-button label="Submit" type="submit" class="mt-3"/>

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
            document.getElementById('amount_paid').innerHTML ='<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="payment">Payment Amount</label><br><div class="input-group"><input name="paid_amount" placeholder="Payment Amount" class="form-control" required type="number" min="0"></div></div>';
        } else {
            $('#status').css("display", "none");
            $('#amount_paid').css("display", "none");
            
        }

    });
</script>
                    