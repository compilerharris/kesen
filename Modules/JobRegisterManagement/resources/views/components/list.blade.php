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
                <div class="card">
                    <div class="card-body">
                        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                                with-buttons>
                                @foreach ($job_registers as $index => $row)
                                    <tr>
        
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->sr_no }}</td>
                                        <td>{{ $row->estimate->estimate_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $row->handle_by->name }}</td>
                                        <td>{{ $row->client->name }}</td>
                                        <td width="500px">
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('jobregistermanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit
                                                </a>
                                            @endif
                                            <a href="{{ route('jobregistermanagement.pdf', $row->id) }}" class="btn btn-info btn-sm mb-2"
                                                target="_blank">Preview
                                            </a>
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('jobregistermanagement.complete', $row->id) }}" class="btn btn-info btn-sm mb-2">Job Confirmation Letter
                                                </a>
                                            @endif
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                @if ($row->status == 1 || $row->status == "1")
                                                    <a href="{{ route('jobregistermanagement.sendFeedBackForm', $row->id) }}" class="btn btn-info btn-sm mb-2">Email Feedback Letter</a>
                                                @endif
                                            @endif
        
                                            {{--                             
                                    <a href="{{route('jobregistermanagement.show', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                        View
                                    </button></a> --}}
        
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
