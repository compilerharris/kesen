@if (Session::has('message'))
    <x-adminlte-alert theme="success" title="Success" dismissable id="success-msg" class="mt-3">
        {{ Session::get('message') }}
    </x-adminlte-alert>
@endif
@if (Session::has('alert'))
    <x-adminlte-alert theme="danger" title="Error" dismissable id="alert-msg" class="mt-3">
        {{ Session::get('alert') }}
    </x-adminlte-alert>
@endif
