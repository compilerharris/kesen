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
                <li class="breadcrumb-item "><a href="/language-management">Language </a></li>
                <li class="breadcrumb-item ">Add Language</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="New Language" theme="info" icon="fas fa-lg fa-language">


            <form action="{{ route('language-management.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Language Name" fgroup-class="col-md-6" required
                        value="{{ old('name') }}" label="Language Name" />
                    <x-adminlte-input name="code" placeholder="Language Code" fgroup-class="col-md-6"
                        value="{{ old('code') }}" label="Language Code" />


                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
