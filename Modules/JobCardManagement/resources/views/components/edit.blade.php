@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php
    $estimates = Modules\EstimateManagement\App\Models\Estimates::where('status', 1)->get();
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->get();
@endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->get();
@endphp
@php
    $config = [
        'title' => 'Select Estimate Number',
        'liveSearch' => true,
        'placeholder' => 'Search Estimate Number...',
        'showTick' => true,
        'actionsBox' => true,
    ];
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

    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <x-adminlte-card title="Edit Job Card" theme="success" icon="fas fa-lg fa-person">

            <form action="{{ route('jobcardmanagement.update', $job_register->sr_no) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="repeater">
                    @foreach ($job_card as $index => $job)
                        <div class="repeater-item mt-3">

                           <div class="card ">
                            <div class="card-header">
                                <h3 class="card-title">Part Copy {{ $index + 1 }}</h3>
                                
                            </div>
                            <div class="card-body">
                                <div class="row ">

                                    <div class="card">
                                        {{-- <div class="card-header">
                                            <b>Translation</b>
                                        </div> --}}
                                        <div class="card-body">
                                            <div class="row pt-2">
    
                                                <x-adminlte-select name="t_writer[{{ $index }}]"
                                                    fgroup-class="col-md-2" required
                                                    value="{{ old('t_writer.' . $index, $job->t_writer_code) }}"
                                                    label="T Writer">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}"
                                                            {{ $job->t_writer_code == $writer->id ? 'selected' : '' }}>
                                                            {{ $writer->writer_name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_unit[{{ $index }}]" placeholder="Unit"
                                                fgroup-class="col-md-2" type='text'
                                                value="{{ old('t_unit.' . $index, $job->t_unit) }}"
                                                label="T Unit" />
                                                <x-adminlte-select name="t_emp_code[{{ $index }}]"
                                                    fgroup-class="col-md-2" required
                                                    value="{{ old('t_emp_code.' . $index, $job->t_emp_code) }}"
                                                    label="T Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $job->t_emp_code == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-select name="t_two_way_emp_code[{{ $index }}]"
                                                    fgroup-class="col-md-2" value="{{ old('t_two_way_emp_code.' . $index) }}"
                                                    label="BT Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $job->t_two_way_emp_code == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_pd[{{ $index }}]" placeholder="T PD"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_pd.' . $index, $job->t_pd) }}" label="T PD" />
                                                <x-adminlte-input name="t_cr[{{ $index }}]" placeholder="T CR"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_cr.' . $index, $job->t_cr) }}" label="T CR" />
                                                <x-adminlte-input name="t_cnc[{{ $index }}]" placeholder="T CN"
                                                    fgroup-class="col-md-2" value="{{ old('t_cnc.' . $index, $job->t_cnc) }}"
                                                    label="T C/CN" />
                                                <x-adminlte-input name="t_dv[{{ $index }}]" placeholder="T DV"
                                                    fgroup-class="col-md-2" value="{{ old('t_dv.' . $index, $job->t_dv) }}"
                                                    label="T DV" />
                                                <x-adminlte-input name="t_fqc[{{ $index }}]" placeholder="T QC"
                                                    fgroup-class="col-md-2" value="{{ old('t_fqc.' . $index, $job->t_fqc) }}"
                                                    label="T F/QC" />
                                                <x-adminlte-input name="t_sentdate[{{ $index }}]"
                                                    placeholder="T Sent Date" fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_sentdate.' . $index, $job->t_sentdate) }}"
                                                    label="T Sent Date" />
                                            </div>
                                        </div>
                                    </div>
    
                                    
                                    <div class="card">
                                        {{-- <div class="card-header">
                                            <b>Back Translation</b>
                                        </div> --}}
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-select name="bt_writer[{{ $index }}]"
                                                    fgroup-class="col-md-2"
                                                    value="{{ old('bt_writer.' . $index, $job->bt_writer_code) }}"
                                                    label="BT Writer">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}"
                                                            {{ $job->bt_writer_code == $writer->id ? 'selected' : '' }}>
                                                            {{ $writer->writer_name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_unit[{{ $index }}]" placeholder="Unit"
                                                fgroup-class="col-md-2" type='text'
                                                value="{{ old('bt_unit.' . $index, $job->bt_unit) }}"
                                                label="BT Unit" />
                                                <x-adminlte-select name="bt_emp_code[{{ $index }}]"
                                                    fgroup-class="col-md-2" value="{{ old('bt_emp_code.' . $index) }}"
                                                    label="BT Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $job->bt_emp_code == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-select name="bt_two_way_emp_code[{{ $index }}]"
                                                    fgroup-class="col-md-2" value="{{ old('bt_two_way_emp_code.' . $index) }}"
                                                    label="BT Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $job->bt_two_way_emp_code == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_pd[{{ $index }}]" placeholder="PD"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_pd.' . $index, $job->bt_pd) }}"
                                                    label="BT PD" />
                                                <x-adminlte-input name="bt_cr[{{ $index }}]" placeholder="CR"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_cr.' . $index, $job->bt_cr) }}"
                                                    label="BT CR" />
                                                <x-adminlte-input name="bt_cnc[{{ $index }}]" placeholder="CN"
                                                    fgroup-class="col-md-2"
                                                    value="{{ old('bt_cnc.' . $index, $job->bt_cnc) }}"
                                                    label="BT C/CN" />
                                                <x-adminlte-input name="bt_dv[{{ $index }}]" placeholder="DV"
                                                    fgroup-class="col-md-2"
                                                    value="{{ old('bt_dv.' . $index, $job->bt_dv) }}"
                                                    label="BT DV" />
                                                <x-adminlte-input name="bt_fqc[{{ $index }}]" placeholder="QC"
                                                    fgroup-class="col-md-2"
                                                    value="{{ old('bt_fqc.' . $index, $job->bt_fqc) }}"
                                                    label="BT F/QC" />
                                                <x-adminlte-input name="bt_sentdate[{{ $index }}]"
                                                    placeholder="Sent Date" fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_sentdate.' . $index, $job->bt_sentdate) }}"
                                                    label="BT Sent Date" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <input type="button" name="button" class="btn btn-danger remove-item mt-3 mb-3"
                                            style="float:right;width: 100px"
                                            data-detail-id="{{ $job->id }}" value="Remove"></button>
                                    
                                    <x-adminlte-input name="job_no[{{ $index }}]" type="hidden"
                                         value="{{ $job_register->sr_no }}" />
                                    <x-adminlte-input name="estimate_detail_id[{{ $index }}]" type="hidden"
                                         value="{{ $estimate_detail->id }}" />
                                    <x-adminlte-input name="id[{{ $index }}]" placeholder="ID"
                                         type="hidden"
                                        value="{{ old('id.' . $index, $job->id) }}" required />
                                </div>
    
                            </div>
                           </div>
                           

                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary" id="add-item">Add Partition</button>
                <br>
                <x-adminlte-button label="Update" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>

</div>

<script type="text/javascript">
   $(document).ready(function() {
    let itemIndex = {{ count($job_card) }};

    $('#add-item').click(function() {
        let newItem = $('.repeater-item.mt-3:first').clone();
        newItem.find('input, select').each(function() {
            $(this).val('');
            let name = $(this).attr('name');

            if(name === "button") {
                $(this).attr('value', 'Remove');
                $(this).attr('data-detail-id', '');
            } else {
                name = name.replace(/\d+/, itemIndex);
                $(this).attr('name', name);
            }
        });
        newItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
        newItem.appendTo('#repeater');
        itemIndex++;
    });

    $(document).on('click', '.remove-item', function() {
        if ($('.repeater-item').length > 1) {
            let detailId = $(this).data('detail-id');

            if (detailId) {
                $.ajax({
                    url: "{{ url('/job-card-management/manage/delete/') }}/" + detailId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log(response.success);
                    }
                });
            }
            $(this).closest('.repeater-item').remove();
            updateIndices();
        }
    });

    function updateIndices() {
        itemIndex = 0;
        $('.repeater-item').each(function() {
            let currentItem = $(this);
            currentItem.find('input, select').each(function() {
                let name = $(this).attr('name');
                name = name.replace(/\d+/, itemIndex);
                $(this).attr('name', name);
            });
            currentItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
            itemIndex++;
        });
    }
});

</script>
