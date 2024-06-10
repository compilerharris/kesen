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
        <x-adminlte-card title="New Writer" theme="success" icon="fas fa-lg fa-language">


            <form action="{{ route('writermanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="writer_name" placeholder="Writer Name" fgroup-class="col-md-3" required
                        value="{{ old('writer_name') }}" label="Writer Name" />
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" required
                        value="{{ old('email') }}" label="Email" type="email" />
                    <x-adminlte-input name="phone_no" placeholder="Phone Number" fgroup-class="col-md-3" required
                        value="{{ old('phone_no') }}" label="Phone Number" />
                    {{-- <x-adminlte-input name="landline"  placeholder="Landline"
                    fgroup-class="col-md-3" required value="{{ old('landline') }}" label="Landline"/> --}}
                    <x-adminlte-input name="code" placeholder="Writer Code" fgroup-class="col-md-3"
                        value="{{ old('code') }}" label="Writer Code" />
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        value="{{ old('address') }}" label="Address" />



                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
