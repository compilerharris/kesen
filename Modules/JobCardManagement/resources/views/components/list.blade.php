@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => '#',
        ],
        [
            'label' => 'Estimated No',
        ],
        [
            'label' => 'Date',
        ],
        [
            'label' => 'Protocol no',
        ],

        [
            'label' => 'Client name',
        ],
        [
            'label' => 'Description',
        ],

        [
            'label' => 'Handled By',
        ],
        [
            'label' => 'Bill no',
        ],
        [
            'label' => 'Bill date',
        ],

        [
            'label' => 'Informed to',
        ],
        [
            'label' => 'Invoicedate',
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
                    background-color: #28a745!important; /* Change active page background color as needed */
                    border-color: #28a745!important; /* Change active page border color as needed */
                }
        </style>
    <div class="content" style="padding-top: 20px; margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
            </ol>
        </nav>
        @include('components.notification')
        <a href="{{ route('jobcardmanagement.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Job Card</button></a>
        <br>
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                with-buttons>
                @foreach ($job_registers as $index=>$row)
                
                    <tr>

                        <td>{{ $index+1 }}</td>
                        <td>{{ Modules\EstimateManagement\App\Models\Estimates::where('id',$row->estimate_id)->first()->estimate_no??''}}</td>
                        <td>{{ $row->date}}</td>
                        <td>{{  $row->protocol_no}}</td>
                        <td>{{ Modules\ClientManagement\App\Models\Client::where('id',$row->client_id)->first()->name??'';}}</td>
                        <td>{{ $row->description }}</td>
                        <td>{{ $row->handle_by->name }}</td>
                        <td>{{ $row->bill_no }}</td>
                        <td>{{ $row->bill_date }}</td>
                        <td>{{  App\Models\User::where('id',$row->informed_to)->first()->name??'';}}</td>
                        <td>{{ $row->invoice_date }}</td>
                        <td width="250px">
                            <a href="{{route('jobcardmanagement.manage', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                               Manage
                            </button></a>
                            
                            <a href="{{route('jobregistermanagement.edit', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                Edit
                             </button></a>
                             <a href="{{route('jobcardmanagement.pdf', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="PDF">
                                PDF
                             </button></a>

                        </td>

                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

</div>
