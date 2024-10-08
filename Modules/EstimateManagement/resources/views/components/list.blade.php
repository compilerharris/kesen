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
            /* Change active page background color as needed */
            border-color: #28a745 !important;
            /* Change active page border color as needed */
        }
    </style>
    <div class="content" style="padding-top: 20px; margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Estimate </li>     
            </ol>
        </nav>
        @include('components.notification')
        <!-- @if(!Auth::user()->hasRole('Accounts'))
        <a href="{{ route('estimatemanagement.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Estimate</button></a>
        @endif
        <br><br> -->

        <div class="card card-info">
            <div class="card-header">
                <h3 style="margin:0">All Estimates</h3>
            </div>
            <div class="card-body" style="background-color: #eaecef;">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tbody>
                            <tr>
                                <td width="90%">
                                    <form action="estimate-management">
                                        From Date:
                                        <input type="date" id="min" name="min" value="{{$min??''}}">
                                        To Date:
                                        <input type="date" id="max" name="max" value="{{$max??''}}">
                                        <input class="btn btn-info" type="submit" value="Filter">
                                        <a href="/estimate-management?reset=reset" class="btn btn-info">Reset</a>
                                    </form>
                                </td>
                                @if(!Auth::user()->hasRole('Accounts'))
                                    <td>
                                        <a href="{{ route('estimatemanagement.create') }}"><button class="btn btn-md btn-success "
                                            style="margin:10px;width:120px;">Add Estimate</button></a>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    @if(Auth::user()->hasRole('CEO'))
                        <span style="font-size: 1.5rem;" class="right badge badge-primary p-2 mt-2 mb-2">Total Estimate:
                            {{ $estimates->count() }}</span>
                        <span style="font-size: 1.5rem;" class="right badge badge-success p-2">Total Approved:
                            {{ $estimates_approved_count }}</span>
                        <span style="font-size: 1.5rem;" class="right badge badge-danger p-2">Total Rejected:
                            {{ $estimates_rejected_count }}</span>
                        @if (request()->input('min') || request()->input('max'))
                            {{-- <a href="{{ route('estimatemanagement.exporteestimate') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}" target="_blank"><button class="btn btn-sm btn-info" title="Edit" style="width:132px;margin-left:5px;height:33px" >Export</button></a> --}}

                            <a href="{{ route('estimatemanagement.exporteestimate') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}" target="_blank" style="font-size: 1.5rem;margin-top: -10px;margin-bottom: 0;padding: 1px 10px;" class="btn btn-info">Export</a>
                        @else
                            {{-- <a href="{{ route('estimatemanagement.exporteestimate') }}?max={{ \Carbon\Carbon::now()->format('Y-m-d') }}" target="_blank"><button class="btn btn-sm btn-info " title="Edit" style="width:132px; margin-left:5px;height:33px" >Export</button></a> --}}

                            <a href="{{ route('estimatemanagement.exporteestimate') }}?max={{ \Carbon\Carbon::now()->format('Y-m-d') }}" target="_blank" style="font-size: 1.5rem;margin-top: -10px;margin-bottom: 0;padding: 1px 10px;" class="btn btn-info">Export</a>
                        @endif
                    @else
                        <span class="right badge badge-primary p-2 fs-6 mt-2 mb-2">Total Estimate:
                            {{ $estimates->count() }}</span>
                        <span class="right badge badge-success p-2 fs-6">Total Approved:
                            {{ $estimates_approved_count }}</span>
                        <span class="right badge badge-danger p-2 fs-6">Total Rejected:
                            {{ $estimates_rejected_count }}</span>
                        @if (request()->input('min') || request()->input('max'))
                            <a
                                href="{{ route('estimatemanagement.exporteestimate') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}" target="_blank"><button
                                    class="btn btn-sm btn-info" title="Edit"
                                    style="width:132px;margin-left:5px;height:33px" > 
                                    Export
                                </button></a>
                        @else
                            <a href="{{ route('estimatemanagement.exporteestimate') }}?max={{ \Carbon\Carbon::now()->format('Y-m-d') }}" target="_blank"><button
                                    class="btn btn-sm btn-info " title="Edit"
                                    style="width:132px;margin-left:5px;height:33px" >
                                    Export
                                </button></a>
                        @endif
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <x-adminlte-datatable id="table8" :heads="Auth::user()->hasRole('CEO') ? $ceoHeads : $heads" head-theme="dark" striped :config="$config">
                                @if(Auth::user()->hasRole('CEO'))
                                    @foreach ($estimates as $index => $row)
                                        <tr>
                                            <td style="font-size: 2rem;">{{ $index + 1 }}</td>
                                            <td style="font-size: 2rem;">{{ $row->estimate_no }}</td>
                                            <td style="font-size: 2rem;">{{ $row->client->name ?? '---' }}
                                            </td>
                                            <td style="font-size: 2rem;">{{ $row->client_person->name ?? '---' }}
                                            </td>
                                            <td style="font-size: 2rem;">{{ $row->headline }}</td>
                                            <td style="font-size: 2rem;"
                                                class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                                {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected - '.$row->reject_reason) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($estimates as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->estimate_no }}</td>
                                            <td>{{ $row->client->client_metric->code }}</td>
                                            <td>{{ $row->client->name ?? '---' }}
                                            </td>
                                            <td>{{ $row->client_person->name ?? '---' }}
                                            </td>
                                            <td>{{ $row->headline }}</td>
                                            <td>{{ $row->currency }}</td>
                                            <td
                                                class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                                {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected - '.$row->reject_reason) }}
                                            </td>
                                            <td>{{ $row->employee->name??'' }}</td>
                                            <td width="300px">
                                                @if(!Auth::user()->hasRole('Accounts'))
                                                    <a href="{{ route('estimatemanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                                @endif
                                                <a href="{{ route('estimatemanagement.viewPdf', $row->id) }}" target="_blank"  class="btn btn-info btn-sm mb-2">Preview</a>
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
</div>

<!-- Modal -->
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
