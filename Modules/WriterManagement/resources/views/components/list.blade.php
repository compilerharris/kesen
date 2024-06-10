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
        <div class="content" style="padding-top: 20px;margin-left: 10px">
            @include('components.notification')
            <a href="{{ route('writermanagement.create') }}"><button class="btn btn-md btn-success "
                    style="float:right;margin:10px">Add Writer</button></a>
            <br><br>
            <div class="card" style="margin:10px">
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
                                    <td>{{ $row->created_by }}</td>
                                    <td>
                                        <a
                                            @if ($row->status == 1) href="{{ route('writermanagement.edit', $row->id) }}" @else href="javascript:function() { return false; }" @endif><button
                                                @if ($row->status == 1) class="btn btn-xs btn-default text-dark mx-1 shadow" @else class="btn btn-xs btn-default text-dart mx-1 shadow" disabled @endif
                                                title="Edit">
                                                Edit
                                            </button></a>
                                        {{-- <a href="{{route('writermanagement.show', $row->id)}}"><button class="btn btn-xs btn-default text-primary mx-1 shadow" title="View Language">
                                    View 
                                </button> --}}
                                        <a href="{{ route('writermanagement.viewLanguageMaps', $row->id) }}"><button
                                                class="btn btn-xs btn-default text-primary mx-1 shadow"
                                                title="View Language">
                                                View Language
                                            </button>
                                            <a href="{{ route('writermanagement.viewPayments', $row->id) }}"><button
                                                    class="btn btn-xs btn-default text-primary mx-1 shadow"
                                                    title="View Payment">
                                                    View Payment
                                                </button>
                                                @if ($row->status == 1)
                                                    <a
                                                        href="{{ route('writermanagement.disableEnableWriter', $row->id) }}"><button
                                                            class="btn btn-xs btn-danger mx-1 shadow" title="Disable">
                                                            Disable</button></a>
                                                @else
                                                    <a
                                                        href="{{ route('writermanagement.disableEnableWriter', $row->id) }}"><button
                                                            class="btn btn-xs btn-success  mx-1 shadow"
                                                            title="Enable">Enable</button>
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
