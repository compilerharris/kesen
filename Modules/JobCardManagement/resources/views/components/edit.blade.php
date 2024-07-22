@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php
    $estimates = Modules\EstimateManagement\App\Models\Estimates::where('status', 1)->get();
    $writer_ids=Modules\WriterManagement\App\Models\WriterLanguageMap::where('language_id',$estimate_detail->language->id)->pluck('writer_id')->toArray();
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->whereIn('id', $writer_ids)->get();
@endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php
    $qce_users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Quality Control Executive');
        })
        ->where('language_id',$estimate_detail->language->id)
        ->get();
@endphp
@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Quality Control Executive');
        })
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
                <li class="breadcrumb-item "><a href="/job-card-management/manage/list/{{$job_register->id}}/{{$job_register->estimate_document_id}}">Job No {{$job_register->sr_no}}</a></li>
                <li class="breadcrumb-item ">{{$estimate_detail->language->name}}</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Part Copy for {{$estimate_detail->document_name}}" theme="info" icon="fas fa-lg fa-person">

            <form action="{{ route('jobcardmanagement.update', $job_register->id.'|'.$job_register->estimate_document_id) }}" method="POST"
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
                            <div class="card-body" style="padding-bottom: 0;background-color: #eaecef;">
                                <div class="row ">

                                    <div class="card">
                                        {{-- <div class="card-header">
                                            <b>Translation</b>
                                        </div> --}}
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="t_unit[{{ $index }}]" placeholder="Unit"
                                                fgroup-class="col-md-2" type='text'
                                                value="{{ old('t_unit.' . $index, $job->t_unit) }}"
                                                label="T Unit" required/>
                                              
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
                                               
                                                <x-adminlte-input name="t_pd[{{ $index }}]" placeholder="T PD"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_pd.' . $index, $job->t_pd) }}" label="T PD"  required/>
                                                <x-adminlte-input name="t_cr[{{ $index }}]" placeholder="T CR"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_cr.' . $index, $job->t_cr) }}" label="T CR"/>
                                                
                                                <x-adminlte-select name="t_cnc[{{ $index }}]" label="T C/NC" fgroup-class="col-md-2">
                                                        <option value="">Select C/NC</option>
                                                        <option value="C" {{$job->t_cnc == 'C' ? 'selected' : ''}}>C</option>
                                                        <option value="NC" {{$job->t_cnc == 'NC' ? 'selected' : ''}}>NC</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_dv[{{ $index }}]" placeholder="T DV"
                                                    fgroup-class="col-md-2" value="{{ old('t_dv.' . $index, $job->t_dv) }}"
                                                    label="T DV" />
                                                
                                                    <x-adminlte-input name="v_unit[{{ $index }}]" placeholder="V1 Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v_unit.' . $index, $job->v_unit) }}" label="V1 Unit" />
                                                <x-adminlte-select name="v_employee_code[{{ $index }}]" fgroup-class="col-md-2" 
                                                    value="{{ old('v_employee_code.' . $index, $job->v_employee_code) }}" label="V1 Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}" {{ $job->v_employee_code == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v_pd[{{ $index }}]" placeholder="V1 PD" fgroup-class="col-md-2"
                                                    value="{{ old('v_pd.' . $index, $job->v_pd) }}" label="V1 PD"  type='date' />
                                                <x-adminlte-input name="v_cr[{{ $index }}]" placeholder="V1 CR" fgroup-class="col-md-2"
                                                    value="{{ old('v_cr.' . $index, $job->v_cr) }}" label="V1 CR"  type='date' />
                                                    <x-adminlte-input name="v2_unit[{{ $index }}]" placeholder="V2 Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v2_unit.' . $index, $job->v2_unit) }}" label="V2 Unit" />
                                                <x-adminlte-select name="v2_employee_code[{{ $index }}]" fgroup-class="col-md-2" 
                                                     label="V2 Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}" {{ $job->v2_employee_code == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v2_pd[{{ $index }}]" placeholder="V2 PD" fgroup-class="col-md-2"
                                                    value="{{ old('v2_pd.' . $index, $job->v2_pd) }}" label="V2 PD" type='date' />
                                                <x-adminlte-input name="v2_cr[{{ $index }}]" placeholder="V2 CR" fgroup-class="col-md-2"
                                                    value="{{ old('v2_cr.' . $index, $job->v2_cr) }}" label="V2 CR" type='date' />
                                                    <x-adminlte-select name="t_fqc[{{ $index }}]" fgroup-class="col-md-2" 
                                                    value="{{ old('t_fqc.' . $index, $job->t_fqc) }}" label="T F/QC">
                                                    <option value="">T F/QC</option>
                                                    @foreach ($qce_users as $tfc_user)
                                                        <option value="{{ $tfc_user->id }}" {{ $job->t_fqc == $tfc_user->id ? 'selected' : '' }}>{{ $tfc_user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_sentdate[{{ $index }}]"
                                                    placeholder="T Sent Date" fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_sentdate.' . $index, $job->t_sentdate) }}"
                                                    label="T Sent Date"/>
                                               
                                            </div>
                                        </div>
                                    </div>
    
                                    
                                    <div class="card" >
                                        {{-- <div class="card-header">
                                            <b>Back Translation</b>
                                        </div> --}}
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="bt_unit[{{ $index }}]" placeholder="Unit"
                                                fgroup-class="col-md-2" type='text'
                                                value="{{ old('bt_unit.' . $index, $job->bt_unit) }}"
                                                label="BT Unit" />
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

                                                <x-adminlte-input name="bt_pd[{{ $index }}]" placeholder="PD"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_pd.' . $index, $job->bt_pd) }}"
                                                    label="BT PD" />
                                                <x-adminlte-input name="bt_cr[{{ $index }}]" placeholder="CR"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_cr.' . $index, $job->bt_cr) }}"
                                                    label="BT CR" />
                                                <x-adminlte-select name="bt_cnc[{{ $index }}]" label="BT C/NC" fgroup-class="col-md-2">
                                                        <option value="">Select C/NC</option>
                                                        <option value="C" {{$job->bt_cnc == 'C' ? 'selected' : ''}}>C</option>
                                                        <option value="NC" {{$job->bt_cnc == 'NC' ? 'selected' : ''}}>NC</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_dv[{{ $index }}]" placeholder="DV"
                                                    fgroup-class="col-md-2"
                                                    value="{{ old('bt_dv.' . $index, $job->bt_dv) }}"
                                                    label="BT DV" />
                                               
                                                    <x-adminlte-input name="btv_unit[{{ $index }}]" placeholder="BTV Unit" fgroup-class="col-md-2"
                                                    value="{{ old('btv_unit.' . $index, $job->btv_unit) }}" label="BTV Unit" />
                                                <x-adminlte-select name="btv_employee_code[{{ $index }}]" fgroup-class="col-md-2" 
                                                     label="BTV Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}" {{ $job->btv_employee_code == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="btv_pd[{{ $index }}]" placeholder="BTV PD" fgroup-class="col-md-2"
                                                    value="{{ old('btv_pd.' . $index, $job->btv_pd) }}" label="BTV PD" type='date' />
                                                <x-adminlte-input name="btv_cr[{{ $index }}]" placeholder="BTV CR" fgroup-class="col-md-2"
                                                    value="{{ old('btv_cr.' . $index, $job->btv_cr) }}" label="BTV CR" type='date' />
                                                <x-adminlte-select name="bt_fqc[{{ $index }}]" fgroup-class="col-md-2" 
                                                    value="{{ old('bt_fqc.' . $index, $job->bt_fqc) }}" label="BT F/QC">
                                                    <option value="">BT F/QC</option>
                                                    @foreach ($qce_users as $btfc_user)
                                                        <option value="{{ $btfc_user->id }}" {{ $job->bt_fqc == $btfc_user->id ? 'selected' : '' }}>{{ $btfc_user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_sentdate[{{ $index }}]"
                                                    placeholder="Sent Date" fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_sentdate.' . $index, $job->bt_sentdate) }}"
                                                    label="BT Sent Date" />
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                    
                                    
                                    
                                    <x-adminlte-input name="job_no[{{ $index }}]" type="hidden"
                                         value="{{ $job_register->sr_no }}" />
                                    <x-adminlte-input name="estimate_detail_id[{{ $index }}]" type="hidden"
                                         value="{{ $estimate_detail->id }}" />
                                    <x-adminlte-input name="id[{{ $index }}]" placeholder="ID"
                                         type="hidden"
                                        value="{{ old('id.' . $index, $job->id) }}" required />
                                    <input type="button" name="button" class="btn btn-danger remove-item  mb-3"
                                    style="float:right;width: 100px"
                                    data-detail-id="{{ $job->id }}" value="Remove"></button>
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
