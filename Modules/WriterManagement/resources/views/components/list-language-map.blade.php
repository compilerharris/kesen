@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@php
    $heads = [
        [
            'label' => 'Sr. No.',
        ],
        [
            'label' => 'Language Name',
        ],
        [
            'label' => 'Translation Charges',
        ],
        [
            'label' => 'Verification',
        ],
        [
            'label' => 'Bt Charges',
        ],

        [
            'label' => 'BT Verification Charges',
        ],
        
        [
            'label' => 'Verification 2',
        ],
        [
            'label' => 'Advertising Charges',
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
                    <li class="breadcrumb-item "><a href="/writer-management">Writer </a></li>
                    <li class="breadcrumb-item active" ><a href="/writer-management/{{$id}}/edit">{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Languages</li>
                </ol>
            </nav>
            @include('components.notification')
            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All languages of "{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}"</h3>
                </div>
                @if(!Auth::user()->hasRole('Accounts'))
                    <div style="background-color: #eaecef;">
                        <a href="{{ route('writermanagement.addLanguageMapView', $id) }}"><button class="btn btn-md btn-success "
                            style="float:right;margin:10px">Add More Language</button></a>
                    </div>
                @endif
                <div class="card-body" style="background-color: #eaecef;padding-top:0">
                    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                        <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped
                            :config="$config" with-buttons>
                            @foreach ($language_map as $index => $row)
                                <tr>

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->language_id }}</td>
                                    <td>{{ $row->per_unit_charges }}</td>
                                    <td>{{ $row->checking_charges }}</td>
                                    <td>{{ $row->bt_charges }}</td>
                                    <td>{{ $row->bt_checking_charges }}</td>
                                    <td>{{ $row->verification_2 }}</td>
                                    <td>{{ $row->advertising_charges }}</td>
                                    <td width="250px">
                                        @if(!Auth::user()->hasRole('Accounts'))
                                        <a href="{{ route('writermanagement.editLanguageMap', [$id, $row->id]) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                        <a class="btn btn-danger btn-sm mb-2" title="Delete"
                                            onclick="deleteLanguageMap('{{ route('writermanagement.deleteLanguageMap', [$id, $row->id]) }}')">
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

    <script>
        function deleteLanguageMap(url) {
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
