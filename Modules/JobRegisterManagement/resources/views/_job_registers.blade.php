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
    $heads = [
        [
            'label' => '#',
        ],
        [
            'label' => 'Job No',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Date',
        ],
        [
            'label' => 'Manager',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Created By',
        ],
        [
            'label' => 'Status',
        ],
        [
            'label' => 'Action',
        ],
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];
@endphp

@if ($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid')
@endif

{{-- Content Header --}}
@hasSection('content_header')
    <div class="content-header">
        <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
            @yield('content_header')
        </div>
    </div>
@endif

<div class="card-body">
    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
        <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
            with-buttons>
            @foreach ($job_registers as $index => $row)
                <tr>

                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->sr_no }}</td>
                    <td>{{ $row->estimate?$row->estimate->estimate_no:"No Estimate" }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $row->handle_by->name }}</td>
                    <td>{{ $row->client->name }}</td>
                    <td>{{ $row->created_by_id?app\Models\User::where('id',$row->created_by_id)->first()->name:'' }}</td>
                    <td class={{ $row->status == 0 ? '' : ($row->status == 1 ? 'bg-success' : 'bg-danger') }}>
                            {{ $row->status == 0 ? 'In Progress' : ($row->status == 1 ? 'Completed' :  'Canceled - '.$row->cancel_reason) }}
                    </td>
                    <td width="500px">
                        @if(!Auth::user()->hasRole('Accounts'))
                        <a href="{{ route('jobregistermanagement.edit', $row->id) }}" class="btn btn-info btn-sm mb-2">Edit
                            </a>
                        @endif
                        <a href="{{ route('jobcardmanagement.pdf', ['job_id' => $row->id]) }}"  target="_blank" class="btn btn-info btn-sm mb-2">Preview</a>
                        @if(!Auth::user()->hasRole('Accounts'))
                        <a href="{{ route('jobregistermanagement.complete', $row->id) }}" class="btn btn-info btn-sm mb-2">Job Confirmation Letter
                            </a>
                        @endif
                        @if(!Auth::user()->hasRole('Accounts'))
                            @if ($row->status == 1 || $row->status == "1")
                                <a href="{{ route('jobregistermanagement.sendFeedBackForm', $row->id) }}" class="btn btn-info btn-sm mb-2">Email Feedback Letter</a>
                            @endif
                        @endif
                        @if($row->status == 0)
                            <button data-id="{{ $row->id }}" id="cancelJob" data-toggle="modal" data-target="#cancelModal" class="btn btn-danger btn-sm mb-2">Cancel</button>
                        @elseif($row->status == 1 || $row->status == 2)
                            <a href="{{route('jobcardmanagement.status', [$row->id,0])}}" class="btn btn-info btn-sm mb-2">In Progress</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $job_registers->links() }}
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cancelForm" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Reason for Cancellation</label>
                        <textarea class="form-control" id="reason" name="reason" rows="2" required></textarea>
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

@section('js')
    <script>
        $(document).ready(function() {
            $('#cancelJob').click(function() {
                var jobId = $(this).data('id');
                var actionUrl = 'job-card-management/status/' + jobId + '/2';
                $('#cancelForm').attr('action', actionUrl);
            });
            $('#closeModal').click(function() {
                $('#cancelForm').removeAttr('action');
            });
            $(document).on('click', '.custom-pagination', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "/job-register-management?page=" + page,
                    success: function(data) {
                        console.log(data);
                        
                        $('#job-register-data').html(data);
                    }
                });
            }
        });
    </script>
@endsection