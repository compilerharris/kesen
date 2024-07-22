@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
@php $estimates_details=Modules\EstimateManagement\App\Models\EstimatesDetails::distinct()->pluck('document_name'); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp

@php $contact_persons=Modules\ClientManagement\App\Models\ContactPerson::where('status',1)->get(); @endphp
@php
$users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Project Manager');
            $query->orWhere('name', 'Admin');
        })
    ->get(); @endphp
@php 
$accountants = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
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


                    <x-adminlte-input name="date" placeholder="Delivery Date" fgroup-class="col-md-2" type='date'
                        value="{{ old('date', $jobRegister->date) }}" required label="Delivery Date" />
                    <x-adminlte-input name="old_job_no" placeholder="Old Job No" fgroup-class="col-md-2" 
                        value="{{ $jobRegister->old_job_no }}" type='text' label="Old Job No" />
                    <x-adminlte-select2 name="operator" fgroup-class="col-md-2" label="Checked with Operator">
                        <option value="">Select Yes/No</option>
                        <option value="Yes" {{ $jobRegister->operator == "Yes" ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ $jobRegister->operator == "No" ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="date" placeholder="Delivery Date" fgroup-class="col-md-2" type='date'
                        value="{{ old('date', $jobRegister->date) }}" required label="Delivery Date" />

                    <x-adminlte-select2 name="status" fgroup-class="col-md-2" required label="Status">
                        <option value="">Select Status</option>
                        <option value="0" {{ $jobRegister->status == 0 ? 'selected' : '' }}>In Progress</option>
                        <option value="1" {{ $jobRegister->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="2" {{ $jobRegister->status == 2 ? 'selected' : '' }}>Cancelled</option>
                    </x-adminlte-select2>
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

                <x-adminlte-button label="Update" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
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
            $.ajax({
                url: "/estimate-management/estimate-details/" + $('#estimate_number').val(),
                method: 'GET',
                success: function(data) {
                    $('#estimate_document_id').html(data.html);
                }
            });
        });
    });

    document.getElementById('category').dispatchEvent(new Event('change'));
    $(document).ready(function() {
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
        $('#category').on('change', function() {
            if ($('#category').val() == 1 || $('#category').val() == '1') {
                $('#type').css("display", "block");
            } else {
                $('#type').css("display", "none");
            }
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
</script>
