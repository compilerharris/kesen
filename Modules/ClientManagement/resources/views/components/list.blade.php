@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Client Type',
        ],
        [
            'label' => 'Client Email',
        ],
        [
            'label' => 'Contact No',
        ],
        [
            'label' => 'Accountant Name',
        ],

        [
            'label' => 'Address',
        ],
        [
            'label' => 'Action',
        ],
    ];

    $config = [
        'order' => [[0, 'asc']],
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
                <li class="breadcrumb-item ">Client </li>          
            </ol>
        </nav>
        @include('components.notification')
        <div class="card card-info" style="margin:10px">
            <div class="card-header">
                <h3 style="margin:0">All Clients</h3>
            </div>
            @if(!Auth::user()->hasRole('Accounts'))
                <div style="background-color: #eaecef;">
                    <a href="{{ route('clientmanagement.create') }}"><button class="btn btn-md btn-success "
                        style="float:right;margin:10px">Add Client</button></a>
                </div>
            @endif
            <div class="card-body" style="background-color: #eaecef;padding-top:0">
                <div class="card">
                    <div class="card-body">
                        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                                with-buttons>
                                @foreach ($client as $index => $row)
                                    <tr>
        
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->type == '1' ? 'Protocol' : 'Non Protocol (' . $row->protocol_data . ' )' }}
                                        </td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->phone_no }}</td>
                                        {{-- <td>{{ $row->landline }}</td> --}}
                                        <td>{{ App\Models\User::where('id', $row->client_accountant_person_id)->first()->name ?? '' }}
                                        </td>
                                        <td>{{ $row->address }}</td>
                                        <td width="250px">
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('clientmanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                            @endif
                                            {{-- <a href="{{route('clientmanagement.show', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                        View
                                    </button></a> --}}
                                            <a href="{{ route('clientmanagement.viewContacts', $row->id) }}" class="btn btn-info btn-sm mb-2">View Contacts</a>
                                            @if(!Auth::user()->hasRole('Accounts'))
                                                @if ($row->status == 1)
                                                    <a href="{{ route('clientmanagement.disableEnableClient', $row->id) }}" class="btn btn-danger btn-sm mb-2">Disable</a>
                                                @else
                                                    <a href="{{ route('clientmanagement.disableEnableClient', $row->id) }}" class="btn btn-success btn-sm mb-2">Enable</a>
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
