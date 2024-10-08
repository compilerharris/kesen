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
                <li class="breadcrumb-item ">{{$contact_person->name}}</li>  
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Contact" theme="info">
            <form action="{{ route('clientmanagement.editContact', [$id, $contact_person->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">

                    <x-adminlte-input name="name" placeholder="Contact Person Name" fgroup-class="col-md-3" required
                        value="{{ $contact_person->name }}" label="Contact Person Name" />
                    <x-adminlte-input name="phone_no" placeholder="Contact Person Number"
                        fgroup-class="col-md-3" value="{{ $contact_person->phone_no }}" label="Contact Person Number" />
                    {{-- <x-adminlte-input name="landline" required placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ $contact_person->landline}}" label="Landline Number"/> --}}
                    <x-adminlte-input name="email" required placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ old('email',$contact_person->email) }}" label="Email" />
                    <x-adminlte-input name="designation" placeholder="Designation" fgroup-class="col-md-3"
                        value="{{ $contact_person->designation }}" label="Designation" />
                    <x-adminlte-input name="id" required placeholder="Contact Person Name" fgroup-class="col-md-3"
                        type="hidden" value="{{ $contact_person->id }}" />
                </div>

                <button type="submit" class="mt-3 btn btn-info" onClick="this.form.submit(); this.disabled=true; this.innerText='Updating…'; ">Submit</button>
                {{-- <x-adminlte-button label="Submit" type="submit" class="mt-3" /> --}}

            </form>
        </x-adminlte-card>
    </div>

</div>
