@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')

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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/writer-management">Writer </a></li>
                <li class="breadcrumb-item" ><a href="/writer-management/{{$id}}/edit">{{Modules\WriterManagement\App\Models\Writer::where('id',$id)->first()->writer_name}}</a></li>
                <li class="breadcrumb-item" ><a href="/writer-management/{{$id}}/view-language-maps">View Language Map</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$language_map->language_id}}</li>
            </ol>
        </nav>
        @include('components.notification')
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Language Map" theme="info">
            <form action="{{ route('writermanagement.updateLanguageMap', [$id, $language_map->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row pt-2">
                    <x-adminlte-select name="language" fgroup-class="col-md-3" required label="Language">
                        <option value="">Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" @if ($language_map->language_id == $language->name) selected @endif>
                                {{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="per_unit_charges" placeholder="Translation Charges" fgroup-class="col-md-3"
                        value="{{ $language_map->per_unit_charges }}" label="Translation Charges" required/>
                    <x-adminlte-input name="checking_charges" placeholder="Verification" fgroup-class="col-md-3"
                        value="{{ $language_map->checking_charges }}" label="Verification" required/>
                        <x-adminlte-input name="verification_2" placeholder="Verification 2"
                        fgroup-class="col-md-3" value="{{ $language_map->verification_2 }}" label="Verification 2" required/>
                    <x-adminlte-input name="bt_charges" placeholder="BT Charges" fgroup-class="col-md-3" type='text'
                        value="{{ $language_map->bt_charges }}" label="BT Charges" required/>
                    <x-adminlte-input name="bt_checking_charges" placeholder="BT Verification Charges"
                        fgroup-class="col-md-3" value="{{ $language_map->bt_checking_charges }}"
                        label="BT Verification Charges" required/>
                        
                    <x-adminlte-input name="advertising_charges" placeholder="Advertising Charges"
                        fgroup-class="col-md-3" value="{{ $language_map->advertising_charges }}"
                        label="Advertising Charges" required/>

                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>
</div>
