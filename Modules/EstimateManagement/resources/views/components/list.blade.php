@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
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
        ['label' => '#'],
        ['label' => 'Date'],
        ['label' => 'Estimate No'],
        ['label' => 'Metrix'],
        ['label' => 'Client Name'],
        ['label' => 'Contact Person Name'],
        ['label' => 'Headline'],
        ['label' => 'Currency'],
        ['label' => 'Status'],
        ['label' => 'Created By'],
        ['label' => 'Action']
    ];
    $ceoHeads = [
        ['label' => '#'],
        ['label' => 'Date'],
        ['label' => 'Estimate No'],
        ['label' => 'Client Name'],
        ['label' => 'Contact Person Name'],
        ['label' => 'Headline'],
        ['label' => 'Status']
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];
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
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Estimate</li>
            </ol>
        </nav>
        @include('components.notification')
        <div class="card card-info" style="margin:10px">
            <div class="card-header">
                <h3 style="margin:0">All Estimates</h3>
            </div>
            @if(!Auth::user()->hasRole('Accounts'))
                <div style="background-color: #eaecef;">
                    <a href="{{ route('estimatemanagement.create') }}"><button class="btn btn-md btn-success" style="float:right;margin:10px;">Add Estimate</button></a>
                </div>
            @endif
            <div class="card-body" style="background-color: #eaecef;padding-top:0">
                <form action="estimate-management">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pt-2 align-items-end">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>From Date:</label>
                                        <input type="date" class="form-control" name="min" value="{{ $min ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To Date:</label>
                                        <input type="date" class="form-control" name="max" value="{{ $max ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-info mr-2" type="submit">Filter</button>
                                        <a href="/estimate-management?reset=reset" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <span class="right badge badge-primary p-2 fs-6 mt-2 mb-2">Total Estimate:
                    {{ $estimates->count() }}</span>
                <span class="right badge badge-success p-2 fs-6">Total Approved:
                    {{ $estimates_approved_count }}</span>
                <span class="right badge badge-danger p-2 fs-6">Total Rejected:
                    {{ $estimates_rejected_count }}</span>
                @if (request()->input('min') || request()->input('max'))
                    <a href="{{ route('estimatemanagement.exporteestimate') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}" target="_blank" class="btn btn-info btn-sm" style="margin-left:5px;height:33px;line-height:1.8">Export</a>
                @else
                    <a href="{{ route('estimatemanagement.exporteestimate') }}?max={{ \Carbon\Carbon::now()->format('Y-m-d') }}" target="_blank" class="btn btn-info btn-sm" style="margin-left:5px;height:33px;line-height:1.8">Export</a>
                @endif
                <div class="card mt-2">
                    <div class="card-body">
                        <x-adminlte-datatable id="table8" :heads="Auth::user()->hasRole('CEO') ? $ceoHeads : $heads" head-theme="dark" striped :config="$config">
                            @if(Auth::user()->hasRole('CEO'))
                                @foreach ($estimates as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $row->estimate_no }}</td>
                                        <td>{{ $row->client->name ?? '---' }}</td>
                                        <td>{{ $row->client_person->name ?? '---' }}</td>
                                        <td>{{ $row->headline }}</td>
                                        <td class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                            {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected - '.$row->reject_reason) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($estimates as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $row->estimate_no }}</td>
                                        <td>{{ $row->client->client_metric->code }}</td>
                                        <td>{{ $row->client->name ?? '---' }}</td>
                                        <td>{{ $row->client_person->name ?? '---' }}</td>
                                        <td>{{ $row->headline }}</td>
                                        <td>{{ $row->currency }}</td>
                                        <td class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                            {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected - '.$row->reject_reason) }}
                                        </td>
                                        <td>{{ $row->employee->name ?? '' }}</td>
                                        <td width="300px">
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                <a href="{{ route('estimatemanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                            @endif
                                            <a href="{{ route('estimatemanagement.viewPdf', $row->id) }}" target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                                            <a href="{{ route('estimatemanagement.downloadPdf', $row->id) }}" class="btn btn-secondary btn-sm mb-2"><i class="fas fa-download"> Download</i></a>
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                @if ($row->status == 0)
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}" class="btn btn-info btn-sm mb-2">Approve</a>
                                                    <button data-id="{{ $row->id }}" onclick="openModal(this)" data-toggle="modal" data-target="#cancelModal" class="btn btn-danger btn-sm mb-2">Reject</button>
                                                @elseif($row->status == 1)
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}" class="btn btn-info btn-sm mb-2">Pending</a>
                                                @else
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}" class="btn btn-info btn-sm mb-2">Pending</a>
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}" class="btn btn-info btn-sm mb-2">Approve</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Estimate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cancelForm" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Reason for Cancellation</label>
                        <textarea class="form-control" id="reason" name="reason" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    function openModal(btn) {
        var estimateId = $(btn).data('id');
        var actionUrl = 'estimate-management/status/' + estimateId + '/2';
        $('#cancelForm').attr('action', actionUrl);
    }
    $(document).ready(function() {
        $('#closeModal').click(function() {
            $('#cancelForm').removeAttr('action');
        });
    });
</script>
@endsection
