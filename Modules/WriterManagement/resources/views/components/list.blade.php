@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Writer Name',
        ],

        [
            'label' => 'Email',
        ],
        [
            'label' => 'Writer Code',
        ],

        [
            'label' => 'Phone',
        ],

        // [
        //     'label' => 'Landline',
        // ],

        [
            'label' => 'Address',
        ],

        [
            'label' => 'Languages',
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
    <div class="content">
        <div class="content" style="padding-top: 20px;margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Writer </li>
                </ol>
            </nav>
            @include('components.notification')
            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All Writers</h3>
                </div>
                @if(!Auth::user()->hasRole('Accounts'))
                    <div style="background-color: #eaecef;">
                        <a href="{{ route('writermanagement.create') }}" style="background-color: #eaecef;"><button class="btn btn-md btn-success" style="float:right;margin:10px">Add Writer</button></a>
                    </div>
                @endif
                <div class="card-body" style="background-color: #eaecef;padding-top:0">
                    <div class="card">
                        <div class="card-body">
                            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                                <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped
                                    :config="$config" with-buttons>
                                    @foreach ($writers as $index => $row)
                                        <tr>
        
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->writer_name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->code }}</td>
        
                                            <td>{{ $row->phone_no }}</td>
                                            {{-- <td>{{ $row->landline }}</td> --}}
                                            <td>{{ $row->address }}</td>
                                            
                                            <td>{{ $row->writer_language_map->pluck('language_id')->implode(', ') }}</td>
                                            <td>{{ $row->created_by }}</td>
                                            <td width="250px">
                                                <a
                                                @if(!Auth::user()->hasRole('Accounts'))
                                                    @if ($row->status == 1) href="{{ route('writermanagement.edit', $row->id) }}" @else href="javascript:function() { return false; }" @endif class="btn btn-info btn-sm mb-2">Edit</a>
                                                @endif
                                                {{-- <a href="{{route('writermanagement.show', $row->id)}}"><button class="btn btn-xs btn-default text-primary mx-1 shadow" title="View Language">
                                            View 
                                        </button> --}}
                                                <a href="{{ route('writermanagement.viewLanguageMaps', $row->id) }}" class="btn btn-info btn-sm mb-2">View Language</a>
                                                <a href="{{ route('writermanagement.viewPayments', $row->id) }}" class="btn btn-info btn-sm mb-2">View Payment</a>
                                                @if(!Auth::user()->hasRole('Accounts'))
                                                    @if ($row->status == 1)
                                                        <a
                                                            href="{{ route('writermanagement.disableEnableWriter', $row->id) }}" class="btn btn-danger btn-sm mb-2">Disable</a>
                                                    @else
                                                        <a
                                                            href="{{ route('writermanagement.disableEnableWriter', $row->id) }}" class="btn btn-success btn-sm mb-2">Enable</a>
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
