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
        <x-adminlte-card title="Show Language" theme="success"  icon="fas fa-lg fa-language"
    >
        
        <form action="{{ route('language-management.update', $language->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row pt-2">
                <x-adminlte-input name="name"  placeholder="Language Name"
                    fgroup-class="col-md-6" required value="{{ $language->name }}" label="Language Name" disabled/>
                <x-adminlte-input name="code"  placeholder="Language Code"
                    fgroup-class="col-md-6" value="{{ $language->code}}" label="Language Code" disabled/>
                    
            </div>
            
            <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3"/>

        </form>
        </x-adminlte-card>
    </div>

</div>
