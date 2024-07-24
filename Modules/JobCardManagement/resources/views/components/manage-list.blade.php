@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Date'],
        ['label' => 'Protocol No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Handled By'],
        ['label' => 'Billing Status'],
        ['label' => 'Bill Date'],
        ['label' => 'Informed To'],
        ['label' => 'Sent Date'],
        ['label' => 'Status'],
        ['label' => 'Action'],
    ];

    $config = [
        'order' => [[1, 'desc']],
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];

    $heads_manage = [
        ['label' => '#'],
        ['label' => 'Document Name'],
        ['label' => 'Language'],
        ['label' => 'Part Copy Created'],
        ['label' => 'Action'],
    ];

    $config_manage = [
        'order' => [[1, 'desc']],
    ];
    $config_manage['paging'] = true;
@endphp

@if (!isset($list_estimate_language))
    
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
                border-color: #28a745 !important;
            }
        </style>
        <div class="content" style="padding-top: 20px; margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">Job Card </li>
                </ol>
            </nav>
            @include('components.notification')

            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All Job Cards</h3>
                </div>
                <div class="card-body" style="background-color: #eaecef;">
                    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                        <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <td>From Date:</td>
                                    <form action="job-card-management">
                                        <td><input type="date" id="min" name="min"></td>
                                        <td>To Date:</td>
                                        <td><input type="date" id="max" name="max"></td>
                                        <td><input class="btn btn-info" type="submit" value="Filter"></td>
                                        <td><input class="btn btn-info" type="submit" value="Reset" name="reset"></td>
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                        <span class="right badge badge-primary p-2 fs-6 mt-2 mb-2">Total Job Card:
                            {{ $job_register->count() }}</span>
                        <span class="right badge badge-success p-2 fs-6">Total Completed:
                            {{ $job_register->complete_count }}</span>
                        <span class="right badge badge-danger p-2 fs-6">Total Canceled:
                            {{ $job_register->cancel_count }}</span>
                        @if (request()->input('min') || request()->input('max'))
                            <a
                                href="{{ route('jobcardmanagement.exportJobCard') }}?min={{ request()->input('min') }}&max={{ request()->input('max') }}" target="_blank"><button
                                    class="btn btn-sm btn-info" title="Edit"
                                    style="width:132px;margin-left:5px;height:33px" > 
                                    Export
                                </button></a>
                        @else
                            <a href="{{ route('jobcardmanagement.exportJobCard') }}" target="_blank"><button
                                    class="btn btn-sm btn-info " title="Edit"
                                    style="width:132px;margin-left:5px;height:33px" >
                                    Export
                                </button></a>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config" with-buttons>
                                    @foreach ($job_register as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->sr_no }}</td>
                                            <td>{{ $row->date?\Carbon\Carbon::parse($row->date)->format('j M Y'):'' }}</td>
                                            <td>{{ $row->protocol_no }}</td>
                                            <td>{{ $row->estimate->client->name }}</td>
                                            <td>{{ $row->estimate_document_id }}</td>
                                            <td>{{ $row->handle_by->name }}</td>
                                            <td>{{ $row->bill_no!=null || $row->bill_no!='' ? "billed-".$row->bill_no:"unbilled" }}</td>
                                            <td>{{ $row->bill_date? \Carbon\Carbon::parse($row->bill_date)->format('j M Y'):'' }}</td>
                                            <td>{{ $row->estimate->client_person->name??'' }}</td>
                                            <td>{{ $row->sent_date?\Carbon\Carbon::parse($row->sent_date)->format('j M Y'):'' }}</td>
                                            <td
                                                    class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                                                    {{ $row->status == 0 ? 'In Progress' : ($row->status == 1 ? 'Completed' : 'Canceled') }}
                                            </td>
                                            
                                            <td style="width:250px;">
                                                
                                                <a href="{{ route('jobcardmanagement.manage.list', ['job_id' => $row->id, 'estimate_detail_id' => $row->estimate_document_id]) }}" class="btn btn-info btn-sm mb-2">Manage
                                                </a>
                                                <a href="{{ route('jobcardmanagement.pdf', ['job_id' => $row->id]) }}"  target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                                                @if(!Auth::user()->hasRole('Accounts'))
                                                    @if($row->status == 0)
                                                        <a href="{{route('jobcardmanagement.status', [$row->id,1])}}" class="btn btn-info btn-sm mb-2">Completed</a>
                                                    @elseif($row->status == 1)
                        
                                                        <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                                                    @else
                        
                                                        <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                            
                                                        <a href="{{route('jobcardmanagement.status', [$row->id,1])}}" class="btn btn-info btn-sm mb-2">Completed</a>
                                                    @endif
        
                                                @endif
                                                
                                                @if($row->type=='site-specific')
                                                    @if($row->is_excel_downloaded)
                                                        <a class="btn btn-info btn-sm mb-2 disabled">Excel Already Download</a>
                                                    @else
                                                        <a href="{{route('jobregistermanagement.excell', $row->id)}}" class="btn btn-info btn-sm mb-2">Download Excel</a>
                                                    @endif
                                                @endif
                                                @if(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))
                                                <a href="{{ route('jobcardmanagement.bill', ['job_id' => $row->id]) }}" class="btn btn-info btn-sm mb-2">Billing</a>
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

@else

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
                border-color: #28a745 !important;
            }
        </style>
        <div class="content" style="padding-top: 20px; margin-left: 10px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
                    <li class="breadcrumb-item ">Job No {{$job_register->sr_no}}</li>
                </ol>
            </nav>
            @include('components.notification')

            <br><br>
            <div class="card card-info" style="margin:10px">
                <div class="card-header">
                    <h3 style="margin:0">All languages of job no "{{$job_register->sr_no}}"</h3>
                </div>
                <div class="card-body" style="background-color: #eaecef;">
                    <div class="card">
                        <div class="card-body">
                            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                                <x-adminlte-datatable id="table8" :heads="$heads_manage" head-theme="dark" striped :config="$config_manage" with-buttons>
                                    @foreach ($estimate_detail as $index => $detail)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $detail->document_name }}</td>
                                            <td>{{ Modules\LanguageManagement\App\Models\Language::where('id', $detail->lang)->first()->name }}</td>
                                            <td class="{{ $detail->partCopyCreate=='Yes'?'bg-success':'' }}">{{ $detail->partCopyCreate }}</td>
                                            <td width="250px">
                                                @if(!Auth::user()->hasRole('Accounts'))
                                                    <a href="{{route('jobcardmanagement.manage.add', ['job_id' => $job_register->id, 'estimate_detail_id' => $detail->id])}}" class="btn btn-info btn-sm mb-2">{{ $detail->partCopyCreate=='Yes'?'Edit':'Add' }}</a>
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
@endif
