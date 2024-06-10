@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
@php
    $accountants = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Accounts');
        })
        ->get();
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

    {{-- Main Content --}}
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <x-adminlte-card title="New Client" theme="success" icon="fas fa-lg fa-person">
            <form action="{{ route('clientmanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Client Name" fgroup-class="col-md-3" required
                        value="{{ old('name') }}" label="Client Name" />
                    <x-adminlte-input name="phone_no" placeholder="Client Number" fgroup-class="col-md-3"
                        value="{{ old('phone_no') }}" label="Client Number" required />
                    {{-- <x-adminlte-input name="landline"  placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ old('landline') }}" label="Landline Number" required/> --}}
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ old('email') }}" label="Email" required />
                    <x-adminlte-select name="type" fgroup-class="col-md-3" id="type" required
                        value="{{ old('type') }}" label="Client Type">
                        <option value="">Client Type</option>
                        <option value="1">Protocol</option>
                        <option value="2">Non Protocol</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-3" required value="{{ old('metrix') }}"
                        label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}">{{ $metric->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_accountant_person_id" fgroup-class="col-md-3" required
                        value="{{ old('client_accountant_person_id') }}" label="Accountant">
                        <option value="">Select Accountant</option>
                        @foreach ($accountants as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        value="{{ old('address') }}" label="Address" required />
                    <span id="protocol" class="col-md-3">

                    </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        if (this.value == 2 || this.value == '2') {
            document.getElementById('protocol').innerHTML =
                '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><div class="input-group" ><select name="protocol_data" class="form-control" required="required"><option value="">Non Protocol Type</option><option value="Advertisement ADV">Advertisement ADV</option><option value="Consolidated CON">Consolidated CON</option></select></div></div>';
        } else {
            document.getElementById('protocol').innerHTML = '';
        }
    });
</script>
