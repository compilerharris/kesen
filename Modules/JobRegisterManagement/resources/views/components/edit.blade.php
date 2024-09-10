@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php 
    $languages = Modules\LanguageManagement\App\Models\Language::where('status', 1)->get();
    $languages = sort_languages($languages);
@endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
@php $estimates_details=Modules\EstimateManagement\App\Models\EstimatesDetails::distinct()->pluck('document_name'); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp

@php $contact_persons=Modules\ClientManagement\App\Models\ContactPerson::where('client_id',$jobRegister->client_id)->where('status',1)->get(); @endphp
@php
$users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('status',1)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Project Manager');
            $query->orWhere('name', 'Admin');
        })
    ->get(); @endphp
@php 
$accountants = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('status',1)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Accounts');
        })
    ->get(); 
@endphp
@php $metrics=App\Models\Metrix::get(); @endphp
@php
    $config = [
        'title' => 'Select Estimate Number',
        'liveSearch' => true,
        'placeholder' => 'Search Estimate Number...',
        'showTick' => true,
        'actionsBox' => true,
        'closeOnSelect' => false
    ];
@endphp
@php
    $config_language = [
        'placeholder' => 'Search Language...',
        'allowClear' => true,
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
                <li class="breadcrumb-item "><a href="/job-register-management">Job Register </a></li>
                <li class="breadcrumb-item active"> Job No {{ $jobRegister->sr_no}} of {{ $jobRegister->clientName}}</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Job Register Document ''{{ $jobRegister->estimate_document_id }}''" theme="info"
            icon="fas fa-lg fa-person">
            <form action="{{ route('jobregistermanagement.update', $jobRegister->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row pt-2">

                    {{-- <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-3" required :config="$config" label="Estimate Number" id="estimate_number">
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}" {{ $jobRegister->estimate_id == $estimate->id ? 'selected' : '' }}>{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    
                    <x-adminlte-input name="estimate_document_id" placeholder="Estimate Document" fgroup-class="col-md-3" value="{{ $jobRegister->estimate_document_id }}" readonly/>
                    
                     --}}


                    @if($jobRegister->estimateType == 'no_estimate')
                        {{-- no estimate start --}}
                        {{-- document --}}
                        <x-adminlte-input name="document_name" placeholder="Document Name"
                        fgroup-class="col-md-2 no_estimate" type="text" value="{{ old('document_name',$jobRegister->estimate_document_id) }}" label="Document Name" readonly />
                        {{-- client --}}
                        <x-adminlte-select2 name="client_id" id="client_id" fgroup-class="col-md-2 no_estimate" required label="Client">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ $jobRegister->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                        {{-- contact person --}}
                        <x-adminlte-select2 name="client_contact_person_id" id="client_contact_person_id" fgroup-class="col-md-2 no_estimate" required label="Contact Person">
                            <option value="">Select Contact Person</option>
                            @foreach ($contact_persons as $contactPerson)
                                <option value="{{ $contactPerson->id }}"
                                    {{ $jobRegister->client_contact_person_id == $contactPerson->id ? 'selected' : '' }}>
                                    {{ $contactPerson->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                        {{-- languages --}}
                        <div class="form-group col-md-3 no_estimate">
                            <label for="lang">Language</label>
                            <x-adminlte-select2 name="lang[]" id="lang" multiple :config="['closeOnSelect' => false]">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" {{ in_array($language->id, $jobRegister->languages) ? 'selected' : '' }}>
                                        {{ $language->name }}</option>
                                @endforeach
                            </x-adminlte-select2>
                            <span class="invalid-feedback is-invalid" id="requiredMsg">Please select at least one language.</span>
                        </div>
                        <!-- t -->
                        <div class="form-group col-md-1 no_estimate">
                            <label>Translation</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="t" id="t" {{$jobRegister->estimate_details[0]->t?'checked':'' }}>
                                <label class="custom-control-label" for="t"></label>
                            </div>
                        </div>
                        <!-- v1 -->
                        <div class="form-group col-md-1 no_estimate">
                            <label>V1</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" {{$jobRegister->estimate_details[0]->v1?'checked':''}} name="v1" id="v1">
                                <label class="custom-control-label" for="v1"></label>
                            </div>
                        </div>
                        <!-- v2 -->
                        <div class="form-group col-md-1 no_estimate">
                            <label>V2</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" {{$jobRegister->estimate_details[0]->v2?'checked':''}} name="v2" id="v2">
                                <label class="custom-control-label" for="v2"></label>
                            </div>
                        </div>
                        <!-- bt -->
                        <div class="form-group col-md-1 no_estimate">
                            <label>BT</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" {{$jobRegister->estimate_details[0]->bt?'checked':''}} name="bt" id="bt">
                                <label class="custom-control-label" for="bt"></label>
                            </div>
                        </div>
                        <!-- btv -->
                        <div class="form-group col-md-1 no_estimate">
                            <label>BTV</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" {{$jobRegister->estimate_details[0]->btv?'checked':''}} name="btv" id="btv">
                                <label class="custom-control-label" for="btv"></label>
                            </div>
                        </div>
                        {{-- no estimate end --}}
                    @endif
                    <x-adminlte-select2 name="handled_by_id" fgroup-class="col-md-2" required label="Manager">
                        <option value="">Select Manager</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $jobRegister->handled_by_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="category" fgroup-class="col-md-2" id="category" required
                        value="{{ old('category') }}" label="Category">
                        <option value="">Category</option>
                        <option value="1" {{ $jobRegister->category == 1 ? 'selected' : '' }}>Protocol</option>
                        <option value="2" {{ $jobRegister->category == 2 ? 'selected' : '' }}>Non-Protocol /
                            Advertising - Consolidate CON</option>
                    </x-adminlte-select2>
                    <span id="type" class="col-md-2"
                        @if ($jobRegister->category == '1') style="display: block;" @else style="display: none;" @endif>
                        <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                            <label for="language">Job Type</label><br>
                            <div class="input-group">
                                <select class="form-control" name="type">
                                    <option value="">Job Type</option>
                                    <option value="new" {{ $jobRegister->type == 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="amendment"
                                        {{ $jobRegister->type == 'amendment' ? 'selected' : '' }}>Amendment</option>
                                    <option value="site-specific"
                                        {{ $jobRegister->type == 'site-specific' ? 'selected' : '' }}>Site Specific
                                    </option>
                                </select>
                            </div>
                        </div>
                    </span>
                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-2"
                        value="{{ old('protocol_no', $jobRegister->protocol_no) }}" label="Protocol Number" />
                    <x-adminlte-input name="version_no" placeholder="Version No" fgroup-class="col-md-2"
                        value="{{ old('version_no', $jobRegister->version_no) }}" label="Version No" />
                    <x-adminlte-input name="version_date" placeholder="Version Date" fgroup-class="col-md-2" type="date"
                        value="{{ old('version_date', $jobRegister->version_date) }}" label="Version Date" />
                    <x-adminlte-input name="old_job_no" placeholder="Old Job No" fgroup-class="col-md-2" 
                        value="{{ $jobRegister->old_job_no }}" type='text' label="Old Job No" />
                    {{-- <x-adminlte-select2 name="operator" fgroup-class="col-md-2" label="Checked with Operator">
                        <option value="">Select Yes/No</option>
                        <option value="Yes" {{ $jobRegister->operator == "Yes" ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ $jobRegister->operator == "No" ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2> --}}
                    <x-adminlte-input name="date" placeholder="Delivery Date" fgroup-class="col-md-2" type='date'
                        value="{{ old('date', $jobRegister->date) }}" required label="Delivery Date" />
                    {{-- <x-adminlte-select2 name="status" fgroup-class="col-md-2" required label="Status">
                        <option value="">Select Status</option>
                        <option value="0" {{ $jobRegister->status == 0 ? 'selected' : '' }}>In Progress</option>
                        <option value="1" {{ $jobRegister->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="2" {{ $jobRegister->status == 2 ? 'selected' : '' }}>Cancelled</option>
                    </x-adminlte-select2> --}}
                    <x-adminlte-select2 name="other_details[]" fgroup-class="col-md-2"  :config="$config"
                        label="Other Estimates" id="other_details" multiple>
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}"
                                {{ in_array($estimate->id, explode(',', $jobRegister->other_details)) ? 'selected' : '' }}>
                                {{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <span id="cancel" class="col-md-3">
                        @if ($jobRegister->status == 2)
                            <label for="language">
                                Cancel Reason
                            </label>

                            <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                                <div class="input-group">
                                    <textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason">{{ $jobRegister->cancel_reason }}</textarea>
                                </div>
                            </div>
                        @endif
                    </span>

                </div>

                @if($jobRegister->estimateType=='no_estimate')
                <button type="submit" id="jobRegisterSubmit" class="mt-3 btn btn-info">Update</button>
                @else
                    <button type="submit" class="mt-3 btn btn-info">Update</button>
                @endif
            </form>
        </x-adminlte-card>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        // const estimate = @json($jobRegister->estimateType??'');
        // if( estimate == "no_estimate"){
        //     alert(estimate);
        //     $('.no_estimate').show();
        //     $('.estimate').hide();
        // }else{
        //     $('.estimate').show();
        //     $('.no_estimate').hide();
        // }
        $('#estimate_number').on('change', function() {
            $.ajax({
                url: "/estimate-management/estimate/" + $('#estimate_number').val(),
                method: 'GET',
                success: function(data) {
                    if (data != false) {
                        document.getElementById("client_contact_person_id").value = data
                            .client_contact_person_id;
                        document.getElementById("client_id").value = data.client_id;
                    }
                }
            });
        });

        $("#jobRegisterSubmit").on("click", function(event) {
            checkLang(event);
        });

        $("#lang").on("change", function(event) {
            checkLang(event);
        });

        function checkLang(event){
            var selectedLanguages = $('#lang').val();
            if (!selectedLanguages || selectedLanguages.length === 0) {
                event.preventDefault();
                $('#requiredMsg').show();
            } else {
                $('#requiredMsg').hide();
            }
        }
        $('#category').on('change', function() {
            if ($('#category').val() == 1 || $('#category').val() == '1') {
                $('#type').css("display", "block");
            } else {
                $('#type').css("display", "none");
            }
        });

        $('#client_id').change(function() {
            let client_id = this.value;
            $.ajax({
                url: "/estimate-management/client/" + client_id,
                method: 'GET',
                success: function(data) {
                    $('#client_contact_person_id').html(data.html);
                }
            });
        });

        // enable disable T
        $('#bt').click(function() {
            if ($(this).is(':checked')) {
                $('#t').prop('disabled', false);
            } else {
                $('#t').prop('disabled', true);
                $('#t').prop('checked', true);
            }
        });
    })

    document.getElementById('category').dispatchEvent(new Event('change'));
    // document.getElementById('status').addEventListener('change', function() {
    //     if (this.value == 2 || this.value == '2') {
    //         document.getElementById('cancel').innerHTML =
    //             '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Cancel Reason</label><br><div class="input-group"><textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason"></textarea></div></div>';
    //     } else {
    //         document.getElementById('cancel').innerHTML = '';
    //     }
    // });
</script>
