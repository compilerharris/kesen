@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp

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
                <li class="breadcrumb-item "><a href="/client-management">Client </a></li>     
                <li class="breadcrumb-item "><a href="/client-management/{{$id}}/edit">{{Modules\ClientManagement\App\Models\Client::where('id',$id)->first()->name}}</a></li>    
                <li class="breadcrumb-item "><a href="/client-management/{{$id}}/view-ratecards">View Rate Cards</a></li>  
                <li class="breadcrumb-item ">Rate Card - {{Modules\LanguageManagement\App\Models\Language::where('id',$ratecard->lang)->first()->name}}</li>  
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Rate Card of {{Modules\LanguageManagement\App\Models\Language::where('id',$ratecard->lang)->first()->name}}" theme="info">
            <form action="{{ route('clientmanagement.ratecardEdit', [$id,$ratecard->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="" fgroup-class="col-md-2" label="Lnaguage" readonly value="{{ Modules\LanguageManagement\App\Models\Language::where('id',$ratecard->lang)->first()->name }}"/>
                    <x-adminlte-select2 name="type" fgroup-class="col-md-2" id="type" required
                         label="Rate Type" placeholder="Rate Type">
                        <option value="">Rate Type</option>
                        <option value="rush" @if (old('type',$ratecard->type) == 'rush') selected @else '' @endif>Rush</option>
                        <option value="normal" @if (old('type',$ratecard->type) == 'normal') selected @else '' @endif>Normal</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="t_rate" placeholder="T Rate" fgroup-class="col-md-2" required
                        value="{{ old('t_rate',$ratecard->t_rate) }}" label="T Rate" />
                    <x-adminlte-input name="v1_rate" placeholder="V1 Rate" fgroup-class="col-md-2" required
                        value="{{ old('v1_rate',$ratecard->v1_rate) }}" label="V1 Rate" />
                    <x-adminlte-input name="v2_rate" placeholder="V2 Rate" fgroup-class="col-md-2" required
                        value="{{ old('v2_rate',$ratecard->v2_rate) }}" label="V2 Rate" />
                    <x-adminlte-input name="bt_rate" placeholder="BT Rate" fgroup-class="col-md-2" required
                        value="{{ old('bt_rate',$ratecard->bt_rate) }}" label="BT Rate" />
                    <x-adminlte-input name="btv_rate" placeholder="BTV Rate" fgroup-class="col-md-2" required
                        value="{{ old('btv_rate',$ratecard->btv_rate) }}" label="BTV Rate" />
                    <x-adminlte-input name="t_minimum_rate" placeholder="T Minimum Rate" fgroup-class="col-md-2" required
                        value="{{ old('t_minimum_rate',$ratecard->t_minimum_rate) }}" label="T Minimum Rate" />
                    <x-adminlte-input name="v1_minimum_rate" placeholder="V1 Minimum Rate" fgroup-class="col-md-2" required
                        value="{{ old('v1_minimum_rate',$ratecard->v1_minimum_rate) }}" label="V1 Minimum Rate" />
                    <x-adminlte-input name="v2_minimum_rate" placeholder="V2 Minimum Rate" fgroup-class="col-md-2" required
                        value="{{ old('v2_minimum_rate',$ratecard->v2_minimum_rate) }}" label="V2 Minimum Rate" />
                    <x-adminlte-input name="bt_minimum_rate" placeholder="BT Minimum Rate" fgroup-class="col-md-2" required
                        value="{{ old('bt_minimum_rate',$ratecard->bt_minimum_rate) }}" label="BT Minimum Rate" />
                    <x-adminlte-input name="btv_minimum_rate" placeholder="BTV Minimum Rate" fgroup-class="col-md-2" required
                        value="{{ old('btv_minimum_rate',$ratecard->btv_minimum_rate) }}" label="BTV Minimum Rate" />
                </div>

                <x-adminlte-button label="Submit" type="submit" id="ratecardSubmit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>
</div>