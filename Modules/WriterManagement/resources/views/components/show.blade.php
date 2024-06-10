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

            <x-adminlte-card title="View Writer" theme="success" icon="fas fa-lg fa-language">


                <form action="{{ route('writermanagement.update', $writer->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row pt-2">
                        <x-adminlte-input name="writer_name" placeholder="Writer Name" fgroup-class="col-md-3" required
                            value="{{ $writer->writer_name }}" label="Writer Name" disabled/>
                        <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" required
                            value="{{ $writer->email }}" label="Email" disabled/>
                        <x-adminlte-input name="phone_no" placeholder="Phone Number" fgroup-class="col-md-3" required
                            value="{{ $writer->phone_no }}" label="Phone Number" disabled/>
                        {{-- <x-adminlte-input name="landline" placeholder="Landline" fgroup-class="col-md-3" required
                            value="{{ $writer->landline }}" label="Landline" disabled/> --}}
                        <x-adminlte-input name="code" placeholder="Writer Code" fgroup-class="col-md-3"
                            value="{{ $writer->code }}" label="Writer Code" disabled/>
                        <x-adminlte-textarea name="address" placeholder="Address"
                            fgroup-class="col-md-3" label="Address" disabled>{{ $writer->address }}</x-adminlte-textarea>



                    </div>

                    <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3"/>

                </form>
            </x-adminlte-card>
        </div>

    </div>
