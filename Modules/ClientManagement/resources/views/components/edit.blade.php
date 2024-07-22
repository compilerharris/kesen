@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
@php $accountants = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Accounts');
        })
    ->get(); @endphp
@php
    $heads = [
        [
            'label' => 'Sr. No.',
        ],
        [
            'label' => 'Contact Person Name',
        ],
        [
            'label' => 'Client Email',
        ],
        [
            'label' => 'Contact No',
        ],

        [
            'label' => 'Designation',
        ],
        [
            'label' => 'Action',
        ],
    ];

    $config = [
        'order' => [[1, 'desc']],
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];
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
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/client-management">Client </a></li>     
                <li class="breadcrumb-item ">{{$client->name}}</li>     
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Client" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('clientmanagement.update', $client->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="name" placeholder="Client Name" fgroup-class="col-md-3" required
                        value="{{ $client->name }}" label="Client Name" />
                    <x-adminlte-input name="phone_no"  placeholder="Contact Number" fgroup-class="col-md-3"
                        value="{{ $client->phone_no }}" label="Contact Number" />
                    {{-- <x-adminlte-input name="landline" required placeholder="Landline Number" fgroup-class="col-md-3"
                        value="{{ $client->landline }}" label="Landline Number" /> --}}
                    <x-adminlte-input name="email" placeholder="Email" fgroup-class="col-md-3" type='email'
                        value="{{ $client->email }}" label="Email" />
                    <x-adminlte-select name="type" fgroup-class="col-md-3" id="type" required
                        label="Client Type">
                        <option value="">Client Type</option>
                        <option value="1" @if ($client->type == '1') selected @else '' @endif>Protocol
                        </option>
                        <option value="2" @if ($client->type == '2') selected @else '' @endif>Non Protocol
                        </option>
                    </x-adminlte-select>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-3" required label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}" @if ($client->metrix == $metric->id) selected @endif>
                                {{ $metric->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_accountant_person_id" fgroup-class="col-md-3" required
                        label="Accountant">
                        <option value="">Select Accountant</option>
                        @foreach ($accountants as $user)
                            <option value="{{ $user->id }}"
                                {{ $client->client_accountant_person_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-textarea name="address" placeholder="Address" fgroup-class="col-md-3"
                        label="Address">{{ $client->address }}</x-adminlte-textarea>
                    <span id="protocol" class="col-md-3">
                        <span id="protocol" class="col-md-3">
                            @if ($client->type == '2')
                                <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                                    <div class="input-group">
                                        <select name="protocol_data" class="form-control" required="required">
                                            <option value="">Non Protocol Type</option>
                                            <option value="Advertisement ADV"
                                                @if ($client->protocol_data == 'Advertisement ADV') selected @else '' @endif>Advertisement
                                                ADV</option>
                                            <option value="Consolidated CON"
                                                @if ($client->protocol_data == 'Consolidated CON') selected @else '' @endif>Consolidated
                                                CON</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
            <br>
            @if (count($contact_persons) > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 10px">Contact Person</h3>
                        <a href="{{ route('clientmanagement.addContact', $client->id) }}"><button class="btn btn-md btn-success "
                            style="float:right;">Add Contact</button></a>
                    </div>
                    <div class="card-body">
                        
                    
                        <x-adminlte-datatable id="table8" class="mt-3" :heads="$heads" head-theme="dark" striped
                    :config="$config" with-buttons>
                    @foreach ($contact_persons as $index => $row)
                        <tr>

                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone_no }}</td>
                            {{-- <td>{{ $row->landline }}</td> --}}
                            <td>{{ $row->designation }}</td>
                            <td width="250px">
                                <a href="{{ route('clientmanagement.editContactForm', [$client->id, $row->id]) }}" class="btn btn-info btn-sm mb-2">Edit</a>
                                @if ($row->status == 1)
                                    <a
                                        href="{{ route('clientmanagement.disableEnableContact', [$client->id, $row->id]) }}" class="btn btn-danger btn-sm mb-2">Disable</a>
                                @else
                                    <a
                                        href="{{ route('clientmanagement.disableEnableContact', [$client->id, $row->id]) }}" class="btn btn-success btn-sm mb-2">Enable</a>
                                @endif
                                <!-- <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="disableEnable('{{ route('clientmanagement.deleteContact', [$client->id, $row->id]) }}')">
                                   Delete
                                </button> -->
                                <a class="btn btn-danger btn-sm mb-2" title="Delete" onclick="disableEnable('{{ route('clientmanagement.deleteContact', [$client->id, $row->id]) }}')">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </x-adminlte-datatable>

                    </div>
                </div>
            @endif
        </x-adminlte-card>
    </div>

</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        if (this.value == 2 || this.value == '2') {
            document.getElementById('protocol').innerHTML =
                '<label>Non Protocol Type</label><div class="form-group col-md-12" style="padding: 0px;margin:0px"><div class="input-group" ><select name="protocol_data" class="form-control" required="required"><option value="">Non Protocol Type</option><option value="Advertisement ADV">Advertisement ADV</option><option value="Consolidated CON">Consolidated CON</option></select></div></div>';
        } else {
            document.getElementById('protocol').innerHTML = '';
        }
    });

    function disableEnable(url) {
        Swal.fire({
            title: "Are you sure?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {

            if (result.value) {
                window.open(url, "_self")
            } else if (result.isDenied) {
                return false;
            }
        });
    }
</script>
