@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
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
        <x-adminlte-card title="View Client" theme="success"  icon="fas fa-lg fa-person"
     >
        <form action="{{ route('clientmanagement.update', $client->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row pt-2">
                <x-adminlte-input name="name"  placeholder="Client Name"
                    fgroup-class="col-md-3" required value="{{ $client->name }}" label="Client Name"  disabled/>
                <x-adminlte-input name="phone_no"  placeholder="Client Number"
                    fgroup-class="col-md-3" value="{{ $client->phone_no}}" label="Client Number" disabled/>
                    {{-- <x-adminlte-input name="landline"  placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ $client->landline}}" label="Landline Number" disabled/> --}}
                    <x-adminlte-input name="email"  placeholder="Email"
                    fgroup-class="col-md-3" type='email' value="{{ $client->email}}" label="Email" disabled/>
                    <x-adminlte-select name="type" fgroup-class="col-md-3" id="type" required  label="Client Type" disabled>
                        <option value="">Client Type</option>
                        <option value="1" @if($client->type == '1') selected @else '' @endif>Protocol</option>
                        <option value="2" @if($client->type == '2') selected @else '' @endif>Non Protocol</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-3"  required label="Metrix" disabled>
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}" @if ($client->metrix == $metric->id) selected @endif>
                                {{ $metric->name }}</option>
                        @endforeach
                        
                    </x-adminlte-select>
                    <x-adminlte-textarea name="address"  placeholder="Address"
                    fgroup-class="col-md-3" label="Address" disabled>{{ $client->address}}</x-adminlte-textarea>
                    <span id="protocol" class="col-md-3">
                    <span id="protocol" class="col-md-3">
                        @if($client->type == '2')
                            <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                                <div class="input-group" >
                                    <select name="protocol_data" class="form-control" required="required" disabled>
                                        <option value="">Non Protocol Type</option>
                                        <option value="Advertisement ADV" @if($client->protocol_data == 'Advertisement ADV') selected @else '' @endif>Advertisement ADV</option>
                                        <option value="Consolidated CON" @if($client->protocol_data == 'Consolidated CON') selected @else '' @endif>Consolidated CON</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </span>
            </div>
            
            <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3"/>

        </form>
        </x-adminlte-card>
    </div>

</div>

<script>
 document.getElementById('type').addEventListener('change', function() {
    if(this.value == 2||this.value == '2'){
        document.getElementById('protocol').innerHTML = '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><div class="input-group" ><select name="protocol_data" class="form-control" required="required"><option value="">Non Protocol Type</option><option value="Advertisement ADV">Advertisement ADV</option><option value="Consolidated CON">Consolidated CON</option></select></div></div>';
    }else{
        document.getElementById('protocol').innerHTML = '';
    }
});

</script>