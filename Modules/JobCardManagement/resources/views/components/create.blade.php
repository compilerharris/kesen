@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)

@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->get();
    $writer_ids=Modules\WriterManagement\App\Models\WriterLanguageMap::where('language_id',$estimate_detail->language->id)->pluck('writer_id')->toArray();
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->whereIn('id', $writer_ids)->get();
@endphp
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
        <x-adminlte-card style="background-color: #eaecef;" title="Add Part Copy for {{$estimate_detail->document_name}}" theme="info" icon="fas fa-lg fa-person">
           
            <form action="{{ route('jobcardmanagement.store') }}" method="POST">
                @csrf
                <div id="repeater">
                    <div class="repeater-item mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Part Copy 1</h3>
                            </div>
                            <div class="card-body" style="padding-bottom: 0;background-color: #eaecef;">
                                <div class="row pt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="t_unit[0]" placeholder="Unit" fgroup-class="col-md-2"
                                                value="{{ old('t_unit[0]') }}" label="T Unit*" required />
                                                <x-adminlte-select name="t_writer[0]" fgroup-class="col-md-2" required
                                                    value="{{ old('t_writer[0]') }}" label="T Writer*">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_pd[0]" placeholder="PD" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('t_pd[0]') }}"
                                                    label="T PD*"  required/>
                                                <x-adminlte-input name="t_cr[0]" placeholder="CR" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('t_cr[0]') }}"
                                                    label="T CR"/>
                                                <x-adminlte-select name="t_cnc[0]" label="T C/NC" fgroup-class="col-md-2">
                                                        <option value="">Select C/NC</option>
                                                        <option value="C">C</option>
                                                        <option value="NC">NC</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_dv[0]" placeholder="DV" fgroup-class="col-md-2"
                                                    value="{{ old('t_dv[0]') }}" label="T DV" />
                                                
                                                    <x-adminlte-input name="v_unit[0]" placeholder="V1 Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v_unit[0]') }}" label="V1 Unit" />
                                                <x-adminlte-select name="v_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('v_employee_code[0]') }}" label="V1 Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v_pd[0]" placeholder="V1 PD" fgroup-class="col-md-2"
                                                    value="{{ old('v_pd[0]') }}" label="V1 PD" type='date' />
                                                <x-adminlte-input name="v_cr[0]" placeholder="V1 CR" fgroup-class="col-md-2"
                                                    value="{{ old('v_cr[0]') }}" label="V1 CR" type='date' />
                                                    <x-adminlte-input name="v2_unit[0]" placeholder="V2 Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v2_unit[0]') }}" label="V2 Unit" />
                                                    <x-adminlte-select name="v2_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('v2_employee_code[0]') }}" label="V2 Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v2_pd[0]" placeholder="V2 PD" fgroup-class="col-md-2"
                                                    value="{{ old('v2_pd[0]') }}" label="V2 PD" type='date' />
                                                <x-adminlte-input name="v2_cr[0]" placeholder="V2 CR" fgroup-class="col-md-2"
                                                    value="{{ old('v2_cr[0]') }}" label="V2 CR" type='date' />
                                                <x-adminlte-select name="t_fqc[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('t_fqc[0]') }}" label="T F/QC">
                                                    <option value="">T F/QC</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_sentdate[0]" placeholder="Sent Date"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_sentdate[0]') }}"
                                                    label="T Sent Date"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="bt_unit[0]" placeholder="Unit" fgroup-class="col-md-2"
                                                    value="{{ old('bt_unit[0]') }}" label="BT Unit" />
                                                <x-adminlte-select name="bt_writer[0]" fgroup-class="col-md-2"
                                                    value="{{ old('bt_writer[0]') }}" label="BT Writer">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}">{{ $writer->writer_name }}
                                                        </option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_pd[0]" placeholder="PD" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('bt_pd[0]') }}"
                                                    label="BT PD"  />
                                                <x-adminlte-input name="bt_cr[0]" placeholder="CR" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('bt_cr[0]') }}"
                                                    label="BT CR"  />
                                                
                                                <x-adminlte-select name="bt_cnc[0]" label="BT C/NC" fgroup-class="col-md-2">
                                                    <option value="">Select C/NC</option>
                                                    <option value="C">C</option>
                                                    <option value="NC">NC</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_dv[0]" placeholder="DV" fgroup-class="col-md-2"
                                                    value="{{ old('bt_dv[0]') }}" label="BT DV" />
                                                
                                                    <x-adminlte-input name="btv_unit[0]" placeholder="BTV Unit" fgroup-class="col-md-2"
                                                    value="{{ old('btv_unit[0]') }}" label="BTV Unit" />
                                                <x-adminlte-select name="btv_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('btv_employee_code[0]') }}" label="BTV Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="btv_pd[0]" placeholder="BTV PD" fgroup-class="col-md-2"
                                                    value="{{ old('btv_pd[0]') }}" label="BTV PD" type='date' />
                                                <x-adminlte-input name="btv_cr[0]" placeholder="BTV CR" fgroup-class="col-md-2"
                                                    value="{{ old('btv_cr[0]') }}" label="BTV CR" type='date' />
                                                <x-adminlte-select name="bt_fqc[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('bt_fqc[0]') }}" label="BT F/QC">
                                                    <option value="">BT F/QC</option>
                                                    @foreach ($qce_users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_sentdate[0]" placeholder="Sent Date"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_sentdate[0]') }}"
                                                    label="BT Sent Date"  />
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <x-adminlte-input name="job_no[0]" type="hidden" fgroup-class="col-md-3"
                                        value="{{ $job_register->sr_no }}" />
                                    <x-adminlte-input name="estimate_detail_id[0]" type="hidden" fgroup-class="col-md-3"
                                        value="{{ $estimate_detail->id }}" />
        
                                </div>
                            </div>
                            
                                <button type="button" class="btn btn-danger remove-item mb-2 ml-3 mt-4"
                                    style="float:right;width: 100px">Remove</button>
                            
                        </div>
                        
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary mt-2" id="add-item">Add Partition</button>
                <br>
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
<script>
   $(document).ready(function() {
    let itemIndex = 1;

    $('#add-item').click(function() {
        let newItem = $('.repeater-item.mt-3:first').clone();
        newItem.find('input, select').each(function() {
            $(this).val('');
            let name = $(this).attr('name');
            if (name == 'verification_2[0]') {
                name = 'verification_2[' + itemIndex + ']';
            } else {
                name = name.replace(/\d+/, itemIndex);
            }
            $(this).attr('name', name);
        });
        newItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
        newItem.appendTo('#repeater');
        itemIndex++;
    });

    $(document).on('click', '.remove-item', function() {
        if ($('.repeater-item').length > 1) {
            $(this).closest('.repeater-item').remove();
            updateIndices();
        }
    });

    function updateIndices() {
        itemIndex = 0;
        $('.repeater-item').each(function() {
            let newItem = $(this);
            newItem.find('input, select').each(function() {
                let name = $(this).attr('name');
                if (name == 'verification_2[0]') {
                    name = 'verification_2[' + itemIndex + ']';
                } else {
                    name = name.replace(/\d+/, itemIndex);
                }
                $(this).attr('name', name);
            });
            newItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
            itemIndex++;
        });
    }
});

</script>
