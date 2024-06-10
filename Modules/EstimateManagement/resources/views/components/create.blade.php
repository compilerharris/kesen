@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
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
        <x-adminlte-card title="New Estimate" theme="success" icon="fas fa-lg fa-person">
            <form action="{{ route('estimatemanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-3" required label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @if (old('client_id') == $client->id) selected @endif>
                                {{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-3" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-3" type="text"
                        value="{{ old('headline') }}" required label="Headline" />

                    <x-adminlte-select name="currency" placeholder="Currency" fgroup-class="col-md-3" required
                        value="{{ old('currency') }}" label="Currency">

                        <option value="">Select Currency</option>
                        {!! getCurrencyDropDown() !!}
                    </x-adminlte-select>
                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-3" type='date'
                        value="{{ old('date', date('Y-m-d')) }}" required label="Mail Received on" />
                    <x-adminlte-input name="discount" placeholder="Discount" fgroup-class="col-md-3" type="text"
                        value="{{ old('discount') }}" label="Discount" />
                    <x-adminlte-select name="type" fgroup-class="col-md-3" required value="{{ old('type') }}"
                        label="Type">
                        <option value="">Select Type</option>
                        <option value="words">Words</option>
                        <option value="unit">Unit</option>
                        <option value="minimum">Minimum</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="status" fgroup-class="col-md-3" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>Pending</option>
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                    </x-adminlte-select>



                </div>
                <div id="repeater">
                    <div class="repeater-item mt-3">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Documents 1</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-adminlte-input name="document_name[0]" placeholder="Document Name"
                                        fgroup-class="col-md-3" type="text" value="{{ old('document_name[0]') }}"
                                        required label="Document Name" />

                                    <x-adminlte-input name="unit[0]" placeholder="Unit" fgroup-class="col-md-3"
                                        type="number" value="{{ old('unit[0]') }}" required label="Unit/Words"
                                        onkeyup="calculateAmount(this)" min="1" value="1" />
                                    <x-adminlte-input name="rate[0]" placeholder="Translation Rate"
                                        fgroup-class="col-md-3" type="tell" value="{{ old('rate[0]') }}" required
                                        label="Translation Rate" onkeyup="calculateAmount(this)" />
                                    <x-adminlte-input name="amount[0]" placeholder="Amount" fgroup-class="col-md-3"
                                        type="text" value="{{ old('amount[0]') }}" label="Amount" readonly />
                                    <x-adminlte-input name="verification[0]" placeholder="Verification"
                                        fgroup-class="col-md-3" type="text" value="{{ old('verification[0]') }}"
                                        label="Verification" />
                                    <x-adminlte-input name="two_way_qc_t[0]" placeholder="Two Way QC T"
                                        fgroup-class="col-md-3" type="text" value="{{ old('two_way_qc_t[0]') }}"
                                        label="Two Way QC T" />
                                    <x-adminlte-input name="layout_charges[0]" placeholder="Layout Charges"
                                        fgroup-class="col-md-3" type="text"
                                        value="{{ old('layout_charges[0]') }}" label="Layout Charges" />
                                    <x-adminlte-input name="back_translation[0]" placeholder="Back Translation Rate"
                                        fgroup-class="col-md-3" type="text"
                                        value="{{ old('back_translation[0]') }}" label="Back Translation Rate"
                                        onkeyup="calculateAmount_2(this)" />
                                    <x-adminlte-input name="amount_bt[0]" placeholder="Amount"
                                        fgroup-class="col-md-3" type="text" value="{{ old('amount_bt[0]') }}"
                                        label="Amount" readonly />
                                    <x-adminlte-input name="verification_2[0]"
                                        placeholder="Back Translation Verification" fgroup-class="col-md-3"
                                        type="text" value="{{ old('verification_2[0]') }}"
                                        label="Back Translation Verification" />
                                    <x-adminlte-input name="two_way_qc_bt[0]" placeholder="Two Way QC BT"
                                        fgroup-class="col-md-3" type="text" value="{{ old('two_way_qc_bt[0]') }}"
                                        label="Two Way QC BT" />
                                    <x-adminlte-input name="layout_charges_second[0]" placeholder="BT Layout Charges"
                                        fgroup-class="col-md-3" type="text"
                                        value="{{ old('layout_charges_second[0]') }}" label="BT Layout Charges" />
                                    <x-adminlte-select name="lang_0[]" fgroup-class="col-md-3" required
                                        label="Language" multiple>
                                        <option value="">Select Language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}">
                                                {{ $language->name }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-danger remove-item mt-3 mb-3"
                                        style="float:right;width: 100px">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary mt-5" id="add-item">Add Document</button>
                <br>
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        let itemIndex = 1;

        $('#add-item').click(function() {
            let newItem = $('.repeater-item.mt-3:first').clone();
            newItem.find('input, select').each(function() {
                $(this).val('');
                let name = $(this).attr('name');
                if (name === 'verification_2[0]') {
                    name = 'verification_2[' + itemIndex + ']';
                } else if (name === "lang_0") {
                    name = 'lang_' + itemIndex + "[]";
                } else {
                    name = name.replace(/\d+/, itemIndex);
                }
                $(this).attr('name', name);
            });
            newItem.find('.card-title').html('Document ' + (itemIndex + 1));
            newItem.appendTo('#repeater');
            itemIndex++;
        });

        $(document).on('click', '.remove-item', function() {
            if ($('.repeater-item').length > 1) {
                $(this).closest('.repeater-item').remove();
                updateIndices();
            }
        });

        function updateIndices() {
            itemIndex = 0;
            $('.repeater-item').each(function() {
                $(this).find('input, select').each(function() {
                    let name = $(this).attr('name');
                    if (name === 'verification_2[0]') {
                        name = 'verification_2[' + itemIndex + ']';
                    } else if (name === "lang_0") {
                        name = 'lang_' + itemIndex + "[]";
                    } else {
                        name = name.replace(/\d+/, itemIndex);
                    }
                    $(this).attr('name', name);
                });
                $(this).find('.card-title').html('Document ' + (itemIndex + 1));
                itemIndex++;
            });
        }

        $('#client_id').change(function() {
            let client_id = this.value;
            $.ajax({
                url: "/estimate-management/client/" + client_id,
                method: 'GET',
                success: function(data) {
                    $('#client_contact_person_id').html(data.html);
                }
            });
        });

        $('input[name^="unit"], input[name^="rate"], input[name^="back_translation"]').on('input', function() {
            calculateAmount(this);
            calculateAmount_2(this);
        });
    });

    function calculateAmount(input) {
        const name = input.name;
        const match = name.match(/\[(\d+)\]/);
        const index = match ? match[1] : 0;

        const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
        const rate = parseFloat(document.querySelector(`input[name="rate[${index}]"]`).value) || 0;
        const amount = Math.round(unit * rate);
        document.querySelector(`input[name="amount[${index}]"]`).value = amount;
    }

    function calculateAmount_2(input) {
        const name = input.name;
        const match = name.match(/\[(\d+)\]/);
        const index = match ? match[1] : 0;

        const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
        const rate = parseFloat(document.querySelector(`input[name="back_translation[${index}]"]`).value) || 0;
        const amount = Math.round(unit * rate);
        document.querySelector(`input[name="amount_bt[${index}]"]`).value = amount;
    }
</script>
