@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
<style>
    tr td{
        font-weight: 600 !important;
    }
    td a{
        font-weight: 600 !important;
    }
    td button{
        font-weight: 600 !important;
    }
</style>
@php
    $heads = [
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
        ['label' => 'Total Amount'],
        ['label' => 'Action'],
    ];

    $config = [
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
    <style>
        .page-item.active .page-link {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
    </style>
    <div class="content">
        <div class="content" style="padding-top: 20px;margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item " aria-current="page"><a href="/writer-management">Writer </a></li>
                    <li class="breadcrumb-item active" ><a href="/writer-management/{{$id}}/edit">{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payments</li>
                </ol>
            </nav>
            @include('components.notification')
            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All payments of "{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}"</h3>
                </div>
                <div style="background-color: #eaecef;">
                    <a href="{{ route('writermanagement.addPaymentView', $id) }}"><button class="btn btn-md btn-success" style="float:right;margin:10px">Add Payment</button></a>
                </div>
                <div class="card-body" style="background-color: #eaecef;padding-top:0">
                    <div class="card">
                        <div class="card-body">
                            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                                <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped
                                    :config="$config" with-buttons>
                                    @foreach ($payments as $index => $payment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ $payment->metrix ? App\Models\Metrix::where('id',$payment->metrix)->first()->name : '---' }}</td>
                                            <td>{{ $payment->apply_gst ? 'Yes' : 'No' }}</td>
                                            <td>{{ $payment->apply_tds ? 'Yes' : 'No' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->period_from)->format('j M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->period_to)->format('j M Y') }}</td>
                                            <td>{{ $payment->online_ref_no ?? $payment->cheque_no }}</td>
                                            <td>{{ $payment->performance_charge }}</td>
                                            <td>{{ $payment->deductible }}</td>
                                            <td>{{ $payment->total_amount }}</td>
                                            <td style="width: 200px;">
                                                @if(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))
                                                    <a href="{{ route('writermanagement.editPaymentView', [$id, $payment->id]) }}" class="btn btn-info btn-sm mb-2">Edit
                                                    </a>
                                                @endif
                                                <a href="{{ route('report.payments.preview', [$id,$payment->id,'preview']) }}" target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                                                <a href="{{ route('report.payments.preview', [$id,$payment->id,'email']) }}" class="btn btn-info btn-sm mb-2"><i class="fas fa-envelope"> Email Payment</i></a>
                                                <a class="btn btn-danger btn-sm mb-2" title="Delete"
                                                    onclick="deletePayment('{{ route('writermanagement.paymentDelete', [$id,$payment->id]) }}')">
                                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
