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
                <li class="breadcrumb-item "><a href="/client-management">Client </a></li>     
                <li class="breadcrumb-item "><a href="/client-management/{{$id}}/edit">{{Modules\ClientManagement\App\Models\Client::where('id',$id)->first()->name}}</a></li>    
                <li class="breadcrumb-item "><a href="/client-management/{{$id}}/view-contacts">View Contacts</a></li>  
                <li class="breadcrumb-item ">Add Contact Person</li>  
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="New Contact" theme="info">
            <form action="{{ route('clientmanagement.storeContact', $id) }}" method="POST">
                @method('POST')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Contact Person Name" fgroup-class="col-md-3" required
                        value="{{ old('name') }}" label="Contact Person Name" />
                    <x-adminlte-input name="phone_no"  placeholder="Contact Person Number"
                        fgroup-class="col-md-3" value="{{ old('phone_no') }}" label="Contact Person Number" />
                    {{-- <x-adminlte-input name="landline" required placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ old('landline') }}" label="Landline Number"/> --}}
                    <x-adminlte-input name="email"  placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ old('email') }}" label="Email" />
                    <x-adminlte-input name="designation" placeholder="Designation" fgroup-class="col-md-3"
                        value="{{ old('designation') }}" label="Designation" />
                    <span id="protocol" class="col-md-3">

                    </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
