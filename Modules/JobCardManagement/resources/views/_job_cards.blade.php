@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
<style>
    tr td{
        font-weight: 600 !important;
    }
    td a{
        font-weight: 600 !important;
    }
    td button{
        font-weight: 600 !important;
    }
</style>
@php
    $aHeads = [
        ['label' => '#'],
        ['label' => 'Date'],
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
    $ceoHeads = [
        ['label' => '#'],
        ['label' => 'Date'],
        ['label' => 'Job No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Handled By'],
        ['label' => 'Delivery Date'],
        ['label' => 'Billing Status'],
        ['label' => 'Status']
    ];
    $config['paging'] = false;
    $config['searching'] = false;
    $config['lengthMenu'] = [10, 50, 100, 500];
    $config_manage['paging'] = false;
@endphp
@use('\Carbon\Carbon','Carbon')
<div class="card-body">
    <x-adminlte-datatable id="table8" :heads="Auth::user()->hasRole('CEO')? $ceoHeads : (Auth::user()->hasRole('Accounts') ? $aHeads : $oHeads)" head-theme="dark" striped :config="$config">
        @if(Auth::user()->hasRole('CEO'))
            @foreach ($job_register as $index => $row)
                <tr>
                    <td style="font-size: 2rem;">{{ $index + 1 }}</td>
                    <td style="font-size: 2rem;">{{ $row->created_at?Carbon::parse($row->created_at)->format('j M Y'):'---' }}</td>
                    <td style="font-size: 2rem;">{{ $row->sr_no }}</td>
                    <td style="font-size: 2rem;">{{ $row->estimate?$row->estimate->client->name:($row->no_estimate?$row->no_estimate->client->name:'') }}</td>
                    <td style="font-size: 2rem;">{{ $row->estimate_document_id??'' }}</td>
                    <td style="font-size: 2rem;">{{ $row->handle_by->code??'' }}</td>
                    <td style="font-size: 2rem;">{{ $row->date?Carbon::parse($row->date)->format('j M Y'):'---' }}</td>
                    <td style="font-size: 2rem;" class="{{empty($row->bill_no)&&$row->status==1?'bg-warning':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Unpaid'?'bg-danger':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Paid'?'bg-success':''))}}">{{$row->status==2?'---':(empty($row->bill_no)&&$row->status==1?'unbilled':($row->bill_no??'---'))}}</td>
                    <td style="font-size: 2rem;" class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}> {{ $row->status ==  0 ? ($row->isJobCard?'In Progress':'---') : ($row->status == 1 ? 'Completed' : 'Canceled') }}</td>
                </tr>
            @endforeach
        @else
            @foreach ($job_register as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if (Auth::user()->hasRole('Accounts'))
                        <td>{{ $row->created_at?Carbon::parse($row->created_at)->format('j M Y'):'---' }}</td>
                    @endif
                    <td>{{ $row->sr_no }}</td>
                    <td>{{ $row->estimate?$row->estimate->client->name:($row->no_estimate?$row->no_estimate->client->name:'') }}</td>
                    <td><p style="width: 100px;">{{ $row->estimate_document_id??'' }}</p></td>
                    <td><p style="width: 70px;">{{ $row->protocol_no??'' }}</p></td>
                    <td>{{ $row->handle_by->code??'' }}</td>
                    <td><p style="width: 70px;">{{ $row->estimate?$row->estimate->client_person->name:($row->no_estimate->client_person->name??'') }}</p></td>
                    <td>{{ $row->date?Carbon::parse($row->date)->format('j M Y'):'---' }}</td>
                    @if (Auth::user()->hasRole('Accounts'))
                        <td class="{{empty($row->bill_no)&&$row->status==1?'bg-warning':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Unpaid'?'bg-danger':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Paid'?'bg-success':''))}}">{{$row->status==2?'---':(empty($row->bill_no)&&$row->status==1?'unbilled':($row->bill_no??'---'))}}</td>
                        {{-- <td class="{{($row->bill_no==null || $row->bill_no=='') && $row->status==1 ? 'bg-warning':''}}">{{ $row->bill_no!=null || $row->bill_no!='' ? "billed-".$row->bill_no:"unbilled" }}</td> --}}
                        <td>{{ $row->status==0||$row->status==2?'---':($row->bill_date&&$row->bill_date!='0000-00-00'? Carbon::parse($row->bill_date)->format('j M Y'):'---') }}</td>
                        <td>{{ $row->sent_date&&$row->sent_date!='0000-00-00'?Carbon::parse($row->sent_date)->format('j M Y'):'---' }}</td>
                    @endif
                    <td class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>{{ $row->status ==  0 ? ($row->isJobCard?'In Progress':'---') : ($row->status == 1 ? 'Completed' : 'Canceled') }}</td>
                    <td style="width:250px;">
                        <a href="{{ route('jobcardmanagement.manage.list', ['job_id' => $row->id, 'estimate_detail_id' => str_replace('/', '!', $row->estimate_document_id)]) }}" class="btn btn-info btn-sm mb-2">Manage
                        </a>
                        <a href="{{ route('jobcardmanagement.pdf', ['job_id' => $row->id]) }}"  target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                        @if(!Auth::user()->hasRole('Accounts'))
                            @if($row->status == 0)
                                <a href="{{route('jobcardmanagement.status', [$row->id,1])}}" class="btn btn-success btn-sm mb-2">Completed</a>
                            @elseif($row->status == 1)

                                <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                            @else

                                <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                            @endif

                        @endif
                        
                        @if($row->type=='site-specific')
                            @if($row->is_excel_downloaded)
                                <a class="btn btn-secondary btn-sm mb-2 disabled">Excel Already Download</a>
                            @else
                                <a href="{{route('jobregistermanagement.excell', $row->id)}}" class="btn btn-secondary btn-sm mb-2"><i class="fas fa-download"> Download Excel</i></a>
                            @endif
                        @endif
                        @if(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))
                        <a href="{{ route('jobcardmanagement.bill', ['job_id' => $row->id]) }}" class="btn btn-info btn-sm mb-2">Billing</a>
                        @endif
                        <button data-id="{{ $row->id }}" onclick="openModal(this)" data-toggle="modal" data-target="#cancelModal" class="btn btn-warning btn-sm mb-2">Remark</button>
                        <button data-id="{{ $row->id }}" onclick="openModalwU(this)" data-toggle="modal" data-target="#wUText" class="btn btn-warning btn-sm mb-2">Words/Units</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </x-adminlte-datatable>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $job_register->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Job Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cancelForm" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" id="remark" name="remark" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- wUText Modal -->
<div class="modal fade" id="wUText" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Word / Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cancelwUTextForm" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="wu">Words/Units</label>
                        <textarea class="form-control" id="wu" name="wu" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closewUTextModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script>
        function openModal(btn) {
            var jobId = $(btn).data('id');
            $.ajax({
                url: 'job-card-management/getRemark/' + jobId,
                success: function(data) {
                    $('#remark').html(data);
                }
            });
            var actionUrl = 'job-card-management/remark/' + jobId;
            $('#cancelForm').attr('action', actionUrl);
        }
        function openModalwU(btn) {
            var jobId = $(btn).data('id');
            var actionUrl = 'job-card-management/wUText/' + jobId;
            $('#cancelwUTextForm').attr('action', actionUrl);
        }
        $(document).ready(function() {
            $('#closeModal').click(function() {
                $('#cancelForm').removeAttr('action');
            });
            $('#closewUTextModal').click(function() {
                $('#cancelwUTextForm').removeAttr('action');
            });
            $(document).on('click', '.custom-pagination', function(event) {
                event.preventDefault();
                console.log($(this).attr('href').split('page=')[1])
                if(document.location.href.split('?')[1]){
                    const url = window.location.href + "&page=" + $(this).attr('href').split('page=')[1];
                    fetch_data(url);
                }else{
                    const url = "/job-card-management?page=" + $(this).attr('href').split('page=')[1];
                    fetch_data(url);
                }
            });

            function fetch_data(url) {
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#job-card-data').html(data);
                    }
                });
            }
        });
    </script>
@endsection