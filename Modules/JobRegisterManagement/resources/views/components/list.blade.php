@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => '#',
        ],
        [
            'label' => 'Job No',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Date',
        ],
        [
            'label' => 'Manager',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Created By',
        ],
        [
            'label' => 'Status',
        ],
        [
            'label' => 'Action',
        ],
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
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Job Register </li>
            </ol>
        </nav>
        @include('components.notification')
        <div class="card card-info" style="margin:10px">
            <div class="card-header">
                <h3 style="margin:0">All Registered Jobs</h3>
            </div>
            @if(!Auth::user()->hasRole('Accounts'))
                <div style="background-color: #eaecef;">
                    <a href="{{ route('jobregistermanagement.create') }}"><button class="btn btn-md btn-success" style="float:right;margin:10px;">Add Job Register</button></a>
                </div>
            @endif
            <div class="card-body" style="background-color: #eaecef;padding-top:0">
                <form action="job-register-management">
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
                                    <option value="0">In Progress</option>
                                    <option value="1">Completed</option>
                                    <option value="2">Cancelled</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fas fa-search"> Search</i></button>
                    <a href="job-register-management" class="btn btn-danger">Reset</a>
                </form>
                <span class="right badge badge-primary p-2 fs-6 mt-2 mb-2">Total Job Card:
                    {{ $job_registers->total() }}</span>
                <span class="right badge badge-success p-2 fs-6">Total Completed:
                    {{ $job_registers->complete_count }}</span>
                <span class="right badge badge-danger p-2 fs-6">Total Canceled:
                    {{ $job_registers->cancel_count }}</span>
                <div class="card" id="job-register-data">
                    @include('jobregistermanagement::_job_registers')
                </div>
                {{-- <div class="card">
                    <div class="card-body">
                        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                                with-buttons>
                                @foreach ($job_registers as $index => $row)
                                    <tr>
        
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->sr_no }}</td>
                                        <td>{{ $row->estimate?$row->estimate->estimate_no:"No Estimate" }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $row->handle_by->name }}</td>
                                        <td>{{ $row->client->name }}</td>
                                        <td>{{ $row->created_by_id?app\Models\User::where('id',$row->created_by_id)->first()->name:'' }}</td>
                                        <td class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                                {{ $row->status == 0 ? 'In Progress' : ($row->status == 1 ? 'Completed' :  'Canceled - '.$row->cancel_reason) }}
                                        </td>
                                        <td width="500px">
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('jobregistermanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit
                                                </a>
                                            @endif
                                            <a href="{{ route('jobcardmanagement.pdf', ['job_id' => $row->id]) }}"  target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('jobregistermanagement.complete', $row->id) }}" class="btn btn-info btn-sm mb-2">Job Confirmation Letter
                                                </a>
                                            @endif
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                @if ($row->status == 1 || $row->status == "1")
                                                    <a href="{{ route('jobregistermanagement.sendFeedBackForm', $row->id) }}" class="btn btn-info btn-sm mb-2">Email Feedback Letter</a>
                                                @endif
                                            @endif
                                            @if($row->status == 0)
                                                <button data-id="{{ $row->id }}" id="cancelJob" data-toggle="modal" data-target="#cancelModal" class="btn btn-danger btn-sm mb-2">Cancel</button>
                                            @elseif($row->status == 1 || $row->status == 2)
                                                <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>