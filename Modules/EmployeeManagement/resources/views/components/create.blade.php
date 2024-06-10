@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $roles=Spatie\Permission\Models\Role::where('name','!=','Developer')->get(); @endphp
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
        <x-adminlte-card title="New Employee" theme="success" icon="fas fa-lg fa-person">

            <form action="{{ route('employeemanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Employee Name" fgroup-class="col-md-3" required
                        value="{{ old('name') }}" label="Employee Name" />
                    <x-adminlte-input name="phone_no" placeholder="Employee Number" fgroup-class="col-md-3"
                        value="{{ old('phone_no') }}" label="Employee Number" />
                    {{-- <x-adminlte-input name="landline"  placeholder="Landline Number"
                    fgroup-class="col-md-3" value="{{ old('landline') }}" label="Landline Number"/> --}}
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ old('email') }}" required label="Email" />

                    <x-adminlte-input name="code" placeholder="Employee Code" fgroup-class="col-md-3" type='text'
                        value="{{ old('code') }}" required label="Employee Code" />

                    <x-adminlte-input name="password" placeholder="Password" fgroup-class="col-md-3" type='password'
                        value="{{ old('password') }}" required label="Password" />
                    <x-adminlte-input name="confirm_password" placeholder="Confirm Password" fgroup-class="col-md-3"
                        type='password' value="{{ old('confirm_password') }}" required label="Confirm Password" />
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        value="{{ old('address') }}" label="Address" />

                    <x-adminlte-select name="language" fgroup-class="col-md-3" required value="{{ old('language') }}"
                        label="Language">
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}">{{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="role" fgroup-class="col-md-3" required value="{{ old('role') }}"
                        label="Role">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
