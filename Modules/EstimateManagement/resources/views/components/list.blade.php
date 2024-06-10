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
        'order' => [[1, 'asc']],
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
    <div class="content">
        @include('components.notification')
        <a href="{{ route('estimatemanagement.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Estimate</button></a>
        <br><br>
        <div class="card" style="margin:10px">
            <div class="card-body">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    <br>
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tbody>
                            <tr>
                                <td>From Date:</td>
                                <form action="estimate-management">
                                    <td><input type="date" id="min" name="min"></td>
                                    <td>To Date:</td>
                                    <td><input type="date" id="max" name="max"></td>
                                    <td><input type="submit" value="Filter"></td>
                                    <td><input type="submit" value="Reset" name="reset"></td>
                                </form>

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
                            href="{{ route('estimatemanagement.exporteestimate') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}"><button
                                class="btn btn-sm btn-default text-dark" title="Edit"
                                style="width:132px;margin-left:5px;height:33px">
                                Export
                            </button></a>
                    @else
                        <a href="{{ route('estimatemanagement.exporteestimate') }}"><button
                                class="btn btn-sm btn-default text-dark " title="Edit"
                                style="width:132px;margin-left:5px;height:33px">
                                Export
                            </button></a>
                    @endif
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
                                <td>


                                    <a href="{{ route('estimatemanagement.edit', $row->id) }}"><button
                                            class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                            Edit
                                        </button></a>

                                    {{-- <a href="{{route('estimatemanagement.show', $row->id)}}" target="_blank"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="View">
                                    View
                                </button></a> --}}
                                    <a href="{{ route('estimatemanagement.viewPdf', $row->id) }}"
                                        target="_blank"><button class="btn btn-xs btn-default text-dark mx-1 shadow"
                                            title="View">
                                            Preview
                                        </button></a>
                                    @if ($row->status == 0)
                                        <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Approve
                                            </button></a>

                                        <a href="{{ route('estimatemanagement.status', [$row->id, 2]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Reject
                                            </button></a>
                                    @elseif($row->status == 1)
                                        <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Pending
                                            </button></a>

                                        <a href="{{ route('estimatemanagement.status', [$row->id, 2]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Reject
                                            </button></a>
                                    @else
                                        <a href="{{ route('estimatemanagement.status', [$row->id, 0]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Pending
                                            </button></a>

                                        <a href="{{ route('estimatemanagement.status', [$row->id, 1]) }}"><button
                                                class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                                Approve
                                            </button></a>
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
