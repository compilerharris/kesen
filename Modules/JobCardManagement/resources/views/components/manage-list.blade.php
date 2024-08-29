@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@php
    $aHeads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Protocol No'],
        ['label' => 'Handled By'],
        ['label' => 'Contact Person'],
        ['label' => 'Delivery Date'],
        ['label' => 'Billing Status'],
        ['label' => 'Bill Date'],
        ['label' => 'Bill Sent Date'],
        ['label' => 'Status'],
        ['label' => 'Action'],
    ];
    $oHeads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Protocol No'],
        ['label' => 'Handled By'],
        ['label' => 'Contact Person'],
        ['label' => 'Delivery Date'],
        ['label' => 'Status'],
        ['label' => 'Action'],
    ];

    $config['paging'] = false;
    $config['lengthMenu'] = [10, 50, 100, 500];

    $heads_manage = [
        ['label' => '#'],
        ['label' => 'Document Name'],
        ['label' => 'Language'],
        ['label' => 'Part Copy'],
        ['label' => 'Sent Date'],
        ['label' => 'Action'],
    ];
    $config_manage['paging'] = true;
    $config_manage['order'] = [1, 'asc'];
@endphp

@if (!isset($list_estimate_language))
    
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
        <div class="content" style="padding-top: 20px; margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">Job Card </li>
                </ol>
            </nav>
            @include('components.notification')

            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All Job Cards</h3>
                </div>
                <div class="card-body" style="background-color: #eaecef;">
                    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                        <form action="job-card-management">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">
                                        {{-- job no --}}
                                        <x-adminlte-input name="jobNo" placeholder="Job No" fgroup-class="col-md-1" type="number" value="{{$jobNo??''}}" label="Job No:" />
                                        {{-- cp --}}
                                        <x-adminlte-input name="cp" placeholder="Client/Protocol" fgroup-class="col-md-2" type="text" value="{{$cp??''}}" label="Client/Protocol:" />
                                        {{-- document --}}
                                        <x-adminlte-input name="document" placeholder="Document" fgroup-class="col-md-1" type="text" value="{{$document??''}}" label="Document:" />
                                        {{-- pm --}}
                                        <x-adminlte-input name="pm" placeholder="PM" fgroup-class="col-md-1" type="text" value="{{$pm??''}}" label="PM:" />
                                        {{-- contact person --}}
                                        <x-adminlte-input name="contactPerson" placeholder="Contact Person"  fgroup-class="col-md-2" type="text" value="{{$contactPerson??''}}" label="Contact Person:" />
                                        {{-- from --}}
                                        <x-adminlte-input type="date" name="from" fgroup-class="col-md-2" value="{{$from??''}}" label="From Date:" />
                                        {{-- to --}}
                                        <x-adminlte-input type="date" name="to" fgroup-class="col-md-2" value="{{$to??''}}" label="To Date:" />
                                        <x-adminlte-select2 name="status" fgroup-class="col-md-1" value="{{ old('status') }}" label="Status:">
                                            <option value="">Select Status</option>
                                            <option value="0" {{$status=='0'?'selected':''}}>In Progress</option>
                                            <option value="1" {{$status=='1'?'selected':''}}>Completed</option>
                                            <option value="2" {{$status=='2'?'selected':''}}>Cancelled</option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fas fa-search"> Search</i></button>
                            <a href="job-card-management" class="btn btn-danger">Reset</a>
                        </form>
                        <span class="right badge badge-primary p-2 fs-6 mt-2 mb-2">Total Job Card:
                            {{ $job_register->total() }}</span>
                        <span class="right badge badge-success p-2 fs-6">Total Completed:
                            {{ $job_register->complete_count }}</span>
                        <span class="right badge badge-danger p-2 fs-6">Total Canceled:
                            {{ $job_register->cancel_count }}</span>
                        @if ( !$jobNo && !$cp && !$document && !$pm && !$contactPerson && !$from && !$to && !$status)
                            <a target="_blank">
                                <button class="btn btn-sm btn-info " title="Edit" style="width:132px;margin-left:5px;height:33px" >Export </button>
                            </a>
                        @else
                            <a href="{{ route('jobcardmanagement.exportJobCard') }}?jobNo={{$jobNo??''}}&cp={{$cp??''}}&document={{$document??''}}&pm={{$pm??''}}&contactPerson={{$contactPerson??''}}&from={{$from??''}}&to={{$to??''}}&status={{$status??''}}" target="_blank">
                                <button class="btn btn-sm btn-info" title="Edit" style="width:132px;margin-left:5px;height:33px" > Export</button>
                            </a>
                        @endif
                        <div class="card" id="job-card-data">
                            @include('jobcardmanagement::_job_cards')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

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
        <div class="content" style="padding-top: 20px; margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
                    <li class="breadcrumb-item ">Job No {{$job_register->sr_no}}</li>
                </ol>
            </nav>
            @include('components.notification')
            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All languages of job no "{{$job_register->sr_no}}"</h3>
                </div>
                <div class="card-body" style="background-color: #eaecef;">
                    <div class="card">
                        <div class="card-body">
                            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                                <x-adminlte-datatable id="table8" :heads="$heads_manage" head-theme="dark" striped :config="$config_manage" with-buttons>
                                    @foreach ($estimate_detail as $index => $detail)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $detail->document_name }}</td>
                                            <td>{{ $detail->language->name }}</td>
                                            <td class="{{ $detail->partCopyCreate=='Yes'?'fw-bold':'' }}">{{ $detail->partCopyCreate == 'Yes'?$detail->partCopyCreateCount.' Copy':"---" }}</td>
                                            <td>{{ $detail->sentDate?\Carbon\Carbon::parse($detail->sentDate)->format('j M Y'):'---' }}</td>
                                            <td width="250px">
                                                <a href="{{route('jobcardmanagement.manage.add', ['job_id' => $job_register->id, 'estimate_detail_id' => $detail->id])}}" class="btn btn-info btn-sm mb-2">{{ $detail->partCopyCreate=='Yes'?'Edit':'Add' }}</a>
                                                @if($detail->partCopyCreate=='Yes')
                                                    <button data-id="{{ $detail->id }}" onclick="openModal(this)" data-toggle="modal" data-target="#sentDate" class="btn btn-success btn-sm mb-2">Sent Date</button>
                                                @endif
                                            </td>
                                            {{-- data-id="{{ $job_register->sr_no }}" --}}
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
    <!-- sentDate Modal -->
    <div class="modal fade" id="sentDate" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Sent Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="sentDateForm" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Select Sent Date</label>
                            <input class="form-control" type="date" id="date" name="date" required></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closesentDateModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openModal(btn) {
            var estimateDetailId = $(btn).data('id');
            var actionUrl = '/job-card-management/sentDate/' + @json($job_register->id) + '/' + @json($job_register->sr_no) + '/' + estimateDetailId + '/' + @json($job_register->estimate_document_id);
            $('#sentDateForm').attr('action', actionUrl);
        }
        $(document).ready(function() {
            // $('#sentDateBtn').click(function() {
            //     var estimateDetailId = $(this).data('id');
            //     var actionUrl = '/job-card-management/sentDate/' + @json($job_register->id) + '/' + @json($job_register->sr_no) + '/' + estimateDetailId + '/' + @json($job_register->estimate_document_id);
            //     $('#sentDateForm').attr('action', actionUrl);
            // });
            $('#closesentDateModal').click(function() {
                $('#sentDateForm').removeAttr('action');
            });
        });
    </script>
@endif
