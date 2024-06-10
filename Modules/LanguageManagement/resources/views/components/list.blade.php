@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Language Name',
        ],
        [
            'label' => 'Language Code',
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
        <a href="{{ route('language-management.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Language</button></a>
        <br><br>
        <div class="card" style="margin:10px">
            <div class="card-body">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                        with-buttons>
                        @foreach ($languages as $index => $row)
                            <tr>

                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->created_by }}</td>
                                <td>
                                    <a href="{{ route('language-management.edit', $row->id) }}"><button
                                            class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                            Edit
                                        </button></a>
                                    {{-- <a href="{{route('language-management.show', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                View
                             </button></a> --}}
                                    @if ($row->status == 1)
                                        <a href="{{ route('language-management.disableEnableClient', $row->id) }}"><button
                                                class="btn btn-xs btn-danger mx-1 shadow" title="Disable">
                                                Disable</button></a>
                                    @else
                                        <a href="{{ route('language-management.disableEnableClient', $row->id) }}"><button
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
