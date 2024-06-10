@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
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
        ['label' => 'Action'],
    ];

    $config = [
        'order' => [[1, 'asc']],
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
            @include('components.notification')
            <a href="{{ route('writermanagement.addPaymentView', $id) }}"><button class="btn btn-md btn-success"
                    style="float:right;margin:10px">Add Payment</button></a>
            <br><br>
            <div class="card" style="margin:10px">
                <div class="card-body">

                    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                        <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped
                            :config="$config" with-buttons>
                            @foreach ($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ $payment->metrix }}</td>
                                    <td>{{ $payment->apply_gst ? 'Yes' : 'No' }}</td>
                                    <td>{{ $payment->apply_tds ? 'Yes' : 'No' }}</td>
                                    <td>{{ $payment->period_from }}</td>
                                    <td>{{ $payment->period_to }}</td>
                                    <td>{{ $payment->online_ref_no ?? $payment->cheque_no }}</td>
                                    <td>{{ $payment->performance_charge }}</td>
                                    <td>{{ $payment->deductible }}</td>
                                    <td>
                                        <a href="{{ route('writermanagement.editPaymentView', [$id, $payment->id]) }}">
                                            <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Edit
                                            </button>
                                        </a>
                                        {{-- <a href="{{ route('writermanagement.showPayment', [$id,$payment->id]) }}">
                                    <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                       View
                                    </button>
                                </a> --}}

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
