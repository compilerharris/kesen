@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php 
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->get(); 
    $languages = sort_languages(Modules\LanguageManagement\App\Models\Language::where('status', 1)->get());
@endphp
@php
    $config = [
        'title' => 'Select Writer',
        'liveSearch' => true,
        'placeholder' => 'Search Writer...',
        'showTick' => true,
        'actionsBox' => true,
    ];
    $configL = [
        'title' => 'Select Language',
        'liveSearch' => true,
        'placeholder' => 'Search Language...',
        'showTick' => true,
        'actionsBox' => true,
        'closeOnSelect' => false,
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

    {{-- Main Content --}}
    <div class="content" style="padding-top: 20px; margin-left: 10px">
        
        @include('components.notification')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Writer Workload</li>
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Writer Workload" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('report.writerWorkload') }}" method="POST" target="_blank">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select2 :config="$configL" name="lang[]" id="lang" fgroup-class="col-md-6" value="{{ old('lang') }}"
                        label="Language" multiple>
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}">{{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="writer" id="writer" fgroup-class="col-md-6" required label="Writer">
                        <option value="">Select Writer</option>
                        @foreach ($writers as $writer)
                            <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                
                <button type="submit" class="mt-3 btn btn-info" >Submit</button>
                {{-- <x-adminlte-button label="Submit" type="submit" class="mt-3" /> --}}
            </form>
        </x-adminlte-card>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $('#lang').change(function() {
        //     const lang = JSON.stringify(Array.from(this.selectedOptions).map(option => option.value));
        //     $.ajax({
        //         url: "/writer-workload-report/languages/" + lang,
        //         method: 'GET',
        //         success: function(data) {
        //             console.log(data);
        //             $('#writer').html(data.html);
        //         }
        //     });
        // });
    });
</script>