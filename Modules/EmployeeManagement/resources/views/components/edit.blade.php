@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $roles=Spatie\Permission\Models\Role::where('name','!=','Developer')->get(); @endphp
@if ($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')@endphp
@else
    @php($def_container_class = 'container-fluid')@endphp
@endif
@php
    $config = [
        'title' => 'Select Language',
        'liveSearch' => true,
        'placeholder' => 'Search ...',
        'showTick' => true,
        'actionsBox' => true,
    ];
@endphp
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/employee-management">Employee </a></li>     
                <li class="breadcrumb-item ">{{$user->name}}</li>     
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Employee" theme="info" icon="fas fa-lg fa-person">

            <form action="{{ route('employeemanagement.update', $user->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Employee Name" fgroup-class="col-md-3" required
                        value="{{ $user->name }}" label="Employee Name" />
                    <x-adminlte-input name="phone_no" placeholder="Contact Number" fgroup-class="col-md-3"
                        value="{{ $user->phone }}" label="Contact Number" />
                    {{-- <x-adminlte-input name="landline"  placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ $user->landline }}" label="Landline Number"/> --}}
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ $user->email }}" required label="Email" />

                    <x-adminlte-input name="code" placeholder="Employee Code" fgroup-class="col-md-3" type='text'
                        value="{{ $user->code }}" required label="Employee Code" readonly/>

                    <x-adminlte-input name="password" placeholder="Password" fgroup-class="col-md-3" type='password'
                        value="{{ $user->plain_password }}"  label="Password" />
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        label="Address">{{ $user->address }}</x-adminlte-textarea>

                    <x-adminlte-select2 name="language[]" :config="$config" id="language" fgroup-class="col-md-3" required label="Language" multiple :config="['closeOnSelect' => false]">
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" {{in_array($language->id,explode(',',$user->language_id))? " selected":"" }}>
                                {{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-select name="role" fgroup-class="col-md-3" required value="{{ old('role') }}"
                        label="Role">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if ($user->hasRole($role->name)) selected @endif>
                                {{ $role->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    </span>
                </div>

                <button type="submit" class="mt-3 btn btn-info" >Submit</button>
                {{-- <x-adminlte-button label="Submit" type="submit" class="mt-3" /> --}}

            </form>
        </x-adminlte-card>
    </div>

</div>
