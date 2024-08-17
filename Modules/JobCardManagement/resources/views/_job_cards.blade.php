@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
@php
    $aHeads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Protocol No'],
        ['label' => 'Handled By'],
        ['label' => 'Contact Person'],
        ['label' => 'Delivery Date'],
        ['label' => 'Billing Status'],
        ['label' => 'Bill Date'],
        ['label' => 'Bill Sent Date'],
        ['label' => 'Status'],
        ['label' => 'Action'],
    ];
    $oHeads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Protocol No'],
        ['label' => 'Handled By'],
        ['label' => 'Contact Person'],
        ['label' => 'Delivery Date'],
        ['label' => 'Status'],
        ['label' => 'Action'],
    ];
    $config['paging'] = false;
    $config['lengthMenu'] = [10, 50, 100, 500];
    $config_manage['paging'] = false;
@endphp
<div class="card-body">
    <x-adminlte-datatable id="table8" :heads="Auth::user()->hasRole('Accounts') ? $aHeads : $oHeads" head-theme="dark" striped :config="$config" with-buttons>
        @foreach ($job_register as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->sr_no }}</td>
                <td>{{ $row->estimate?$row->estimate->client->name:$row->no_estimate->client->name }}</td>
                <td>{{ $row->estimate_document_id }}</td>
                <td><p style="width: 70px;">{{ $row->protocol_no }}</p></td>
                <td>{{ $row->handle_by->code }}</td>
                <td>{{ $row->estimate?$row->estimate->client_person->name:($row->no_estimate->client_person->name??'') }}</td>
                <td>{{ $row->date?\Carbon\Carbon::parse($row->date)->format('j M Y'):'' }}</td>
                @if (Auth::user()->hasRole('Accounts'))
                    <td class="{{($row->bill_no==null || $row->bill_no=='')&& $row->status==1 ? 'bg-warning':''}}">{{ $row->bill_no!=null || $row->bill_no!='' ? "billed-".$row->bill_no:"unbilled" }}</td>
                    <td>{{ $row->bill_date? \Carbon\Carbon::parse($row->bill_date)->format('j M Y'):'' }}</td>
                    <td>{{ $row->sent_date?\Carbon\Carbon::parse($row->sent_date)->format('j M Y'):'' }}</td>
                @endif
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
                    <button data-id="{{ $row->id }}" id="cancelJob" data-toggle="modal" data-target="#cancelModal" class="btn btn-warning btn-sm mb-2">Remark</button>
                    
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $job_register->links() }}
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.custom-pagination', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "/job-card-management?page=" + page,
                    success: function(data) {
                        $('#job-card-data').html(data);
                    }
                });
            }
        });
    </script>
@endsection