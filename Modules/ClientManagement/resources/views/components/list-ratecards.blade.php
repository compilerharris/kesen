@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true);
@php
    $heads = [
        [
            'label' => 'Sr. No.',
        ],
        [
            'label' => 'Language',
        ],
        [
            'label' => 'Type',
        ],
        [
            'label' => 'T Rate',
        ],
        [
            'label' => 'V1 Rate',
        ],
        [
            'label' => 'V2 Rate',
        ],
        [
            'label' => 'BT Rate',
        ],
        [
            'label' => 'BTV Rate',
        ],
        [
            'label' => 'T Minimum Rate',
        ],
        [
            'label' => 'V1 Minimum Rate',
        ],
        [
            'label' => 'V2 Minimum Rate',
        ],
        [
            'label' => 'BT Minimum Rate',
        ],
        [
            'label' => 'BTV Minimum Rate',
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
                <li class="breadcrumb-item "><a href="/client-management">Client </a></li>     
                <li class="breadcrumb-item "><a href="/client-management/{{$id}}/edit">{{Modules\ClientManagement\App\Models\Client::where('id',$id)->first()->name}}</a></li>
                <li class="breadcrumb-item ">Rate Cards</li> 
            </ol>
        </nav>
        @include('components.notification')
        <div class="card card-info" style="margin:10px">
            <div class="card-header">
                <h3 style="margin:0">All Rate Cards of "{{Modules\ClientManagement\App\Models\Client::where('id',$id)->first()->name}}"</h3>
            </div>
            @if(!Auth::user()->hasRole('Accounts'))
                <div style="background-color: #eaecef;">
                    <a href="{{ route('clientmanagement.redirectToRatecardAdd', $id) }}"><button class="btn btn-md btn-success "
                        style="float:right;margin:10px">Add Rate Card</button></a>
                </div>
            @endif
            <div class="card-body" style="background-color: #eaecef;padding-top:0">
                <div class="card">
                    <div class="card-body">
                        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                                with-buttons>
                                @foreach ($ratecards as $index => $row)
                                    <tr>
        
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Modules\LanguageManagement\App\Models\Language::where('id',$row->lang)->first()->name }}</td>
                                        <td>{{ $row->type=='rush'?"Rush":"Normal" }}</td>
                                        <td>{{ $row->t_rate }}</td>
                                        <td>{{ $row->v1_rate }}</td>
                                        <td>{{ $row->v2_rate }}</td>
                                        <td>{{ $row->bt_rate }}</td>
                                        <td>{{ $row->btv_rate }}</td>
                                        <td>{{ $row->t_minimum_rate }}</td>
                                        <td>{{ $row->v1_minimum_rate }}</td>
                                        <td>{{ $row->v2_minimum_rate }}</td>
                                        <td>{{ $row->bt_minimum_rate }}</td>
                                        <td>{{ $row->btv_minimum_rate }}</td>
                                        <td width="250px">
                                            @if(!Auth::user()->hasRole('Accounts'))
                                            <a href="{{ route('clientmanagement.redirectToRatecardEdit', [$id, $row->id]) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                            <a class="btn btn-danger btn-sm mb-2" title="Delete"
                                                onclick="disableEnable('{{ route('clientmanagement.ratecardDelete', [$id, $row->id]) }}')">
                                                <i class="fa fa-lg fa-fw fa-trash"></i>
                                            </a>
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

<script>
    function disableEnable(url) {
        Swal.fire({
            title: "Are you sure?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {

            if (result.value) {
                window.open(url, "_self")
            } else if (result.isDenied) {
                return false;
            }
        });
    }
</script>
