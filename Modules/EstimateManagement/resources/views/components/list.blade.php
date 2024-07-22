@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Metrix',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Contact Person Name',
        ],

        [
            'label' => 'Headline',
        ],
        // [
        //     'label' => 'Amount',
        // ],

        [
            'label' => 'Currency',
        ],
        [
            'label' => 'Status',
        ],
        [
            'label' => 'Created By',
        ],
        [
            'label' => 'Action',
        ],
    ];

    $config = [
        'order' => [[1, 'desc']],
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
                                        <input type="date" id="min" name="min">
                                        To Date:
                                        <input type="date" id="max" name="max">
                                        <input class="btn btn-info" type="submit" value="Filter">
                                        <input class="btn btn-info" type="submit" value="Reset" name="reset">
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
                        <a href="{{ route('estimatemanagement.exporteestimate') }}" target="_blank"><button
                                class="btn btn-sm btn-info " title="Edit"
                                style="width:132px;margin-left:5px;height:33px" >
                                Export
                            </button></a>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config">
                                @foreach ($estimates as $index => $row)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->estimate_no }}</td>
                                        <td>{{ App\Models\Metrix::where('id', $row->client->metrix)->first()->code }}</td>

                                        <td>{{ Modules\ClientManagement\App\Models\Client::where('id', $row->client_id)->first()->name ?? '' }}
                                        </td>
                                        <td>{{ Modules\ClientManagement\App\Models\ContactPerson::where('id', $row->client_contact_person_id)->first()->name ?? '' }}
                                        </td>
                                        <td>{{ $row->headline }}</td>
                                        {{-- <td>{{ $row->amount }}</td> --}}
                                        <td>{{ $row->currency }}</td>
                                        <td
                                            class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                            {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected') }}
                                        </td>
                                        <td>{{ App\Models\User::where('id', $row->created_by)->first()->name }}</td>
                                        <td width="300px">

                                            @if(!Auth::user()->hasRole('Accounts'))
                                                <a href="{{ route('estimatemanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">
                                                    Edit</a>
                                                @endif

                                            {{-- <a href="{{route('estimatemanagement.show', $row->id)}}" target="_blank"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="View">
                                            View
                                        </button></a> --}}
                                        
                                            <a href="{{ route('estimatemanagement.viewPdf', $row->id) }}"
                                                target="_blank" class="btn btn-info btn-sm mb-2">
                                                    Preview
                                                </a>
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                @if ($row->status == 0)
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}" class="btn btn-info btn-sm mb-2">
                                                            Approve
                                                    </a>

                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 2]) }}" class="btn btn-info btn-sm mb-2">Reject
                                                        </a>
                                                @elseif($row->status == 1)
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}" class="btn btn-info btn-sm mb-2">Pending
                                                        </a>

                                                @else
                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}" class="btn btn-info btn-sm mb-2">Pending
                                                        </a>

                                                    <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}" class="btn btn-info btn-sm mb-2">Approve
                                                        </a>
                                                @endif
                                            @endif



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
