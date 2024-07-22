@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@php
    $language_heads = [
        ['label' => 'Sr. No.'],
        ['label' => 'Language Name'],
        ['label' => 'Translation Charges'],
        ['label' => 'Verification'],
        ['label' => 'Bt Charges'],
        ['label' => 'BT Verification Charges'],
        ['label' => 'Verification 2'],
        ['label' => 'Advertising Charges'],
        ['label' => 'Action'],
    ];

    $language_config = [
        'order' => [[1, 'desc']],
        'paging' => true,
        'lengthMenu' => [10, 50, 100, 500],
    ];

    $payment_heads = [
        ['label' => 'Sr. No.'],
        ['label' => 'Payment Method'],
        ['label' => 'Metrix'],
        ['label' => 'Apply GST'],
        ['label' => 'Apply TDS'],
        ['label' => 'Period (From)'],
        ['label' => 'Period (To)'],
        ['label' => 'Online-REF no / Cheque no'],
        ['label' => 'Performance Charge'],
        ['label' => 'Deductible'],
        ['label' => 'Action'],
    ];

    $payment_config = [
        'order' => [[1, 'desc']],
        'paging' => true,
        'lengthMenu' => [10, 50, 100, 500],
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
                <li class="breadcrumb-item "><a href="/writer-management">Writer </a></li>
                <li class="breadcrumb-item active" >{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Writer" theme="info" icon="fas fa-lg fa-language">
            <form action="{{ route('writermanagement.update', $writer->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="writer_name" placeholder="Writer Name" fgroup-class="col-md-3" required
                        value="{{ $writer->writer_name }}" label="Writer Name" />
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" required
                        value="{{ $writer->email }}" label="Email" />
                    <x-adminlte-input name="phone_no" placeholder="Phone Number" fgroup-class="col-md-3" required
                        value="{{ $writer->phone_no }}" label="Phone Number" />
                    {{-- <x-adminlte-input name="landline" placeholder="Landline" fgroup-class="col-md-3" required value="{{ $writer->landline }}" label="Landline" /> --}}
                    <x-adminlte-input name="code" placeholder="Writer Code" fgroup-class="col-md-3"
                        value="{{ $writer->code }}" label="Writer Code" />
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        label="Address">{{ $writer->address }}</x-adminlte-textarea>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
            <br>
           <div class="card">
               <div class="card-header">
                   <h3 class="card-title" style="margin-top: 10px">Language Map</h3>
                   <a href="{{ route('writermanagement.addLanguageMapView', $writer->id) }}"><button class="btn btn-md btn-success "
                    style="float:right;">Add Language Map</button></a>
               </div>
               <div class="card-body">
                <x-adminlte-datatable id="table8" class="mt-3" :heads="$language_heads" head-theme="dark" striped
                :config="$language_config" with-buttons>
                @foreach ($language_map as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->language_id }}</td>
                        <td>{{ $row->per_unit_charges }}</td>
                        <td>{{ $row->checking_charges }}</td>
                        <td>{{ $row->bt_charges }}</td>
                        <td>{{ $row->bt_checking_charges }}</td>
                        <td>{{ $row->verification_2 }}</td>
                        <td>{{ $row->advertising_charges }}</td>
                        <td>
                            <a href="{{ route('writermanagement.editLanguageMap', [$writer->id, $row->id]) }}" class="btn btn-info btn-sm mb-2">Edit
                            </a>
                            <a class="btn btn-danger btn-sm mb-2" title="Delete"
                                onclick="deleteLanguageMap('{{ route('writermanagement.deleteLanguageMap', [$writer->id, $row->id]) }}')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
               </div>
           </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="margin-top:10px">Payment Details</h3>
                    <a href="{{ route('writermanagement.addPaymentView', $writer->id) }}"><button class="btn btn-md btn-success"
                        style="float:right">Add Payment</button></a>
                </div>
                <div class="card-body">
                    <x-adminlte-datatable id="table9" class="mt-3" :heads="$payment_heads" head-theme="dark" striped
                :config="$payment_config" with-buttons>
                @foreach ($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ App\Models\Metrix::where('id',$payment->metrix)->first()->name }}</td>
                        <td>{{ $payment->apply_gst ? 'Yes' : 'No' }}</td>
                        <td>{{ $payment->apply_tds ? 'Yes' : 'No' }}</td>
                        <td>{{ $payment->period_from }}</td>
                        <td>{{ $payment->period_to }}</td>
                        <td>{{ $payment->online_ref_no ?? $payment->cheque_no }}</td>
                        <td>{{ $payment->performance_charge }}</td>
                        <td>{{ $payment->deductible }}</td>
                        <td>
                            @if(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))
                                <a href="{{ route('writermanagement.editPaymentView', [$writer->id, $payment->id]) }}" class="btn btn-info btn-sm mb-2">Edit
                                </a>
                            @endif
                            {{-- <a href="{{ route('writermanagement.showPayment', [$writer->id, $payment->id]) }}">
                                <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="View">View</button>
                            </a> --}}
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>

<script>
    function deleteLanguageMap(url) {
        Swal.fire({
            title: "Are you sure?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                window.location.href = url;
            }
        });
    }
</script>
<script>
    function deletePayment(url) {
        Swal.fire({
            title: "Are you sure?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                window.location.href = url;
            }
        });
    }
</script>
