@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
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
        <x-adminlte-card title="New Job Register" theme="success" icon="fas fa-lg fa-person">

            <form action="{{ route('jobregistermanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-3" required :config="$config"
                        label="Estimate Number" id="estimate_number">
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}">{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select name="estimate_document_id" id="estimate_document_id" fgroup-class="col-md-3"
                        required label="Estimate Document">
                        <option value="">Select Estimate Document</option>
                    </x-adminlte-select>


                    <x-adminlte-select name="handled_by_id" fgroup-class="col-md-3" required
                        value="{{ old('handled_by_id') }}" label="Manager">
                        <option value="">Select Manager</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>


                    <x-adminlte-select name="category" fgroup-class="col-md-3" id="category" required
                        value="{{ old('category') }}" label="Category">
                        <option value="">Category</option>
                        <option value="1">Protocol</option>
                        <option value="2">Non-Protocol / Advertising - Consolidate CON</option>
                    </x-adminlte-select>
                    <span id="type" class="col-md-3" style="display: none;">

                    </span>

                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-3"
                        value="{{ old('protocol_no') }}" label="Protocol Number" />
                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-3" type='date'
                        value="{{ old('date', date('Y-m-d')) }}" required label="Date"
                        min="{{ getCurrentDate() }}" />

                    <x-adminlte-input name="old_job_no" placeholder="Old Job No" fgroup-class="col-md-3" required
                        type='text' label="Old Job No" />

                    <x-adminlte-select name="status" fgroup-class="col-md-3" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>In Progress</option>
                        <option value="1">Completed</option>
                        <option value="2">Cancelled</option>
                    </x-adminlte-select>
                    <x-adminlte-select2 name="other_details[]" fgroup-class="col-md-3" required :config="$config"
                        label="Other Estimates" id="other_details" multiple>
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}">{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <span id="site_specific_path" class="col-md-3">

                    </span>


                    <span id="cancel" class="col-md-3">

                    </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
<script type="text/javascript">
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
            $.ajax({
                url: "/estimate-management/estimate-details/" + $('#estimate_number').val(),
                method: 'GET',
                success: function(data) {
                    $('#estimate_document_id').html(data.html);
                }
            });
        });
        $('#category').on('change', function() {

            if ($('#category').val() == 1 || $('#category').val() == '1') {

                $('#type').css("display", "block");
                document.getElementById('type').innerHTML =
                    '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Job Type</label><br><div class="input-group"><select class="form-control"><option value="">Job Type</option><option value="new">New</option><option value="amendment">Amendment</option><option value="site-specific">Site Specific</option></select></div></div>';
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
    document.getElementById('category').addEventListener('change', function() {

    });
</script>
