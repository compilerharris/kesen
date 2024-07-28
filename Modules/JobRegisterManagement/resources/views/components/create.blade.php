@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->orderBy('created_at','desc')->get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $contact_persons=Modules\ClientManagement\App\Models\ContactPerson::where('status',1)->get(); @endphp
@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Project Manager');
            $query->orWhere('name', 'Admin');
        })
        ->get();
@endphp
@php
    $config = [
        'title' => 'Select Estimate Number',
        'liveSearch' => true,
        'placeholder' => 'Search ...',
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
                <li class="breadcrumb-item "><a href="/job-register-management">Job Register </a></li>
                <li class="breadcrumb-item active">Add Job Register</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="New Job Register" theme="info" icon="fas fa-lg fa-person">

            <form action="{{ route('jobregistermanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-2" required
                        label="Estimate Number" id="estimate_number">
                        <option value="">Select Estimate</option>
                        <option value="no_estimate">No Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}">{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    {{-- no estimate start --}}
                    <x-adminlte-select2 :config="$config" name="client_id" id="client_id" fgroup-class="col-md-2 no_estimate" label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @if (old('client_id') == $client->id) selected @endif>
                                {{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-2 no_estimate" label="Contact Person">
                        <option value="">Select Contact Person</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="document_name" placeholder="Document Name"
                        fgroup-class="col-md-2 no_estimate" type="text" value="{{ old('document_name') }}" label="Document Name" />
                    {{-- <x-adminlte-select2  :config="$config" name="lang[]" id="lang" fgroup-class="col-md-2 no_estimate" label="Language" multiple>
                        <option value="">Select Languages</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}">
                                {{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select2> --}}
                    <div class="form-group col-md-2 no_estimate">
                        <label for="lang">Language</label>
                        <x-adminlte-select2 name="lang[]" id="lang" multiple>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">
                                    {{ $language->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                        <span class="invalid-feedback is-invalid" id="requiredMsg">Please select at least one language.</span>
                    </div>
                    {{-- no estimate end --}}
                    <x-adminlte-select2 name="estimate_document_id" id="estimate_document_id" fgroup-class="col-md-2 estimate" label="Estimate Document">
                        <option value="">Select Estimate Document</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="handled_by_id" fgroup-class="col-md-2" required
                        value="{{ old('handled_by_id') }}" label="Manager">
                        <option value="">Select Manager</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="category" fgroup-class="col-md-2" id="category" required
                        value="{{ old('category') }}" label="Category">
                        <option value="">Select Category</option>
                        <option value="1">Protocol</option>
                        <option value="2">Non-Protocol / Advertising - Consolidate CON</option>
                    </x-adminlte-select2>
                    <span id="type" class="col-md-2" style="display: none;"></span>
                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-2"
                        value="{{ old('protocol_no') }}" label="Protocol Number" />
                    <x-adminlte-input name="version_no" placeholder="Version No" fgroup-class="col-md-2"
                    value="{{ old('version_no') }}" label="Version No" />
                    <x-adminlte-input name="version_date" placeholder="Version Date" fgroup-class="col-md-2" type="date"
                        value="{{ old('version_date') }}" label="Version Date" />
                    <x-adminlte-input name="old_job_no" placeholder="Old Job No" fgroup-class="col-md-2"
                        type='text' label="Old Job No" />
                    <x-adminlte-select2 name="operator" fgroup-class="col-md-2" value="{{ old('operator') }}"
                        label="Checked with Operator">
                        <option value="">Select Yes/No</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="date" placeholder="Delivery Date " fgroup-class="col-md-2" type='date' value="{{ old('date', date('Y-m-d')) }}" required label="Delivery Date"/>
                    <x-adminlte-select2 name="status" fgroup-class="col-md-2" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>In Progress</option>
                        <option value="1">Completed</option>
                        <option value="2">Cancelled</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="other_details[]" fgroup-class="col-md-2"  :config="$config"
                        label="Other Estimates" id="other_details" multiple>
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}">{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <span id="site_specific_path" class="col-md-3"></span>
                    <span id="cancel" class="col-md-3"></span>
                </div>

                <x-adminlte-button label="Submit" type="submit" id="jobRegisterSubmit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.no_estimate').hide();
        $('#estimate_number').on('change', function() {
            // $.ajax({
            //     url: "/estimate-management/estimate/" + $('#estimate_number').val(),
            //     method: 'GET',
            //     success: function(data) {
            //         if (data != false) {
            //             document.getElementById("client_contact_person_id").value = data
            //                 .client_contact_person_id;
            //             document.getElementById("client_id").value = data.client_id;
            //         }
            //     }
            // });
            if($('#estimate_number').val() == 'no_estimate'){
                $('.no_estimate').show();
                $('.estimate').hide();
                $('.no_estimate #client_id').attr('required',true);
                $('.no_estimate #client_contact_person_id').attr('required',true);
                $('.no_estimate input').attr('required',true);
                $('.no_estimate li input').removeAttr('required');
                $('.estimate select').removeAttr('required');
            }else{
                $('.estimate').show();
                $('.no_estimate').hide();
                $('.estimate select').attr('required',true);
                $('.no_estimate select').removeAttr('required');
                $('.no_estimate input').removeAttr('required');
                $.ajax({
                    url: "/estimate-management/estimate-details/" + $('#estimate_number').val(),
                    method: 'GET',
                    success: function(data) {
                        $('#estimate_document_id').html(data.html);
                    }
                });
            }
        });

        $("#jobRegisterSubmit").on("click", function(event) {
            checkLang(event);
        });
        
        $("#lang").on("change", function(event) {
            checkLang(event);
        });

        function checkLang(event){
            if($('#estimate_number').val() == 'no_estimate'){
                var selectedLanguages = $('#lang').val();
                if (!selectedLanguages || selectedLanguages.length === 0) {
                    event.preventDefault();
                    $('#requiredMsg').show();
                } else {
                    $('#requiredMsg').hide();
                }
            }
        }

        $('#category').on('change', function() {

            if ($('#category').val() == 1 || $('#category').val() == '1') {
                $('#type').css("display", "block");
                document.getElementById('type').innerHTML = '<div class="form-group col-md-12" style="padding: 0px; margin:0px"><label for="language">Job Type</label><br><div class="input-group"><select name="type"  class="form-control"><option value="">Job Type</option><option value="new">New</option><option  value="amendment">Amendment</option><option value="site-specific">Site Specific</option></select></div></div>';
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
    })
    document.getElementById('status').addEventListener('change', function() {
        if (this.value == 2 || this.value == '2') {
            document.getElementById('cancel').innerHTML =
                '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Cancel Reason</label><br><div class="input-group"><textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason"></textarea></div></div>';
        } else {
            document.getElementById('cancel').innerHTML = '';
        }

    });
    document.getElementById('category').addEventListener('change', function() {

    });
</script>
