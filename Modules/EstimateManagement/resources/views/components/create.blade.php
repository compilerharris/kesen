@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php
$config = [
    'title' => 'Select Client',
    'liveSearch' => true,
    'placeholder' => 'Search Client...',
    'showTick' => true,
    'actionsBox' => true,
];
@endphp
@php $metrics = App\Models\Metrix::get(); @endphp
@php $clients = Modules\ClientManagement\App\Models\Client::where('status', 1)->get(); @endphp
@php $languages = Modules\LanguageManagement\App\Models\Language::where('status', 1)->get(); @endphp
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/estimate-management">Estimate </a></li>
                <li class="breadcrumb-item ">Add Estimate</li>
                
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="New Estimate" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('estimatemanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select2  :config="$config"  name="client_id" id="client_id" fgroup-class="col-md-2" required label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @if (old('client_id') == $client->id) selected @endif>
                                {{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-2" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-2" type="text"
                        value="{{ old('headline') }}" required label="Headline" />

                    <x-adminlte-select2 name="currency" placeholder="Currency" fgroup-class="col-md-2" required
                        value="{{ old('currency') }}" label="Currency">

                        <option value="">Select Currency</option>
                        {!! getCurrencyDropDown() !!}
                    </x-adminlte-select2>
                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-2" type='date'
                        value="{{ old('date', date('Y-m-d')) }}" required label="Mail Received on" />
                    <x-adminlte-input name="discount" placeholder="Discount" fgroup-class="col-md-2" type="text"
                        value="{{ old('discount') }}" label="Discount" />
                    <x-adminlte-select2 name="rorn" id="rorn" fgroup-class="col-md-2" required value="{{ old('rorn') }}"
                        label="Rush/Normal">
                        <option value="normal">Normal</option>
                        <option value="rush">Rush</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="type" id="type" fgroup-class="col-md-2" required value="{{ old('type') }}"
                        label="Type">
                        <option value="">Select Type</option>
                        <option value="words">Words</option>
                        <option value="unit">Unit</option>
                        <option value="minimum">Minimum</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="status" fgroup-class="col-md-2" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>Pending</option>
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                    </x-adminlte-select2>



                </div>
                <div id="repeater">
                    <div class="repeater-item mt-3">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Documents 1</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- languages -->
                                    <div class="{{ $fgroupClass ?? '' }} mb-3" style="padding-left:7.5px;">
                                        <label>Languages</label>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton_0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Language
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_0" style="max-height: 200px; overflow-y: auto; padding: 5px;">
                                                @foreach ($languages as $option)
                                                    <div class="custom-control custom-checkbox dropdown-item">
                                                        <input type="checkbox" class="custom-control-input" id="checkbox-{{ $option->id }}" onchange="changeLan(this)" name="lang_0[]" value="{{ $option->id }}" {{ in_array($option->id, old($option->name, [])) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="checkbox-{{ $option->id }}">{{ $option->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="invalid-feedback is-invalid" id="requiredMsg_0">Please select at least one language.</div>
                                    </div>
                                    <!-- document -->
                                    <x-adminlte-input name="document_name[0]" placeholder="Document Name" fgroup-class="col-md-4"  type="text" value="{{ old('document_name[0]') }}" required label="Document Name" />
                                    <!-- unit -->
                                    <x-adminlte-input name="unit[0]" placeholder="Unit" fgroup-class="col-md-2" type="number"  value="{{ old('unit[0]') }}" required label="Unit/Words" onkeyup="calculateAmount(this)"  min="1" />
                                    <!-- t rate -->
                                    <x-adminlte-input name="rate[0]" placeholder="T Rate" fgroup-class="col-md-1"  type="tell" value="{{ old('rate[0]') }}" required label="T Rate"  onkeyup="calculateAmount(this)" />
                                    <!-- t amount -->
                                    <x-adminlte-input name="amount[0]" placeholder="T Amount" fgroup-class="col-md-1"
                                        type="text" value="{{ old('amount[0]') }}" label="T Amount" readonly />
                                    <!-- v1 -->
                                    <div class="form-group col-md-1">
                                        <label>V1</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" onchange="calculateV1Amount(this)" class="custom-control-input" name="v_one[0]" id="v_one[0]">
                                            <label class="custom-control-label" for="v_one[0]"></label>
                                        </div>
                                    </div>
                                    <!-- v1 amount -->
                                    <x-adminlte-input name="verification[0]" placeholder="V1 Amount" fgroup-class="col-md-1"  type="text" value="{{ old('verification[0]') }}" label="V1 Amount" readonly/>
                                    <!-- v2 -->
                                    <div class="form-group col-md-1">
                                        <label>V2</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" onchange="calculateV2Amount(this)" class="custom-control-input" name="v_two[0]" id="v_two[0]">
                                            <label class="custom-control-label" for="v_two[0]"></label>
                                        </div>
                                    </div>
                                    <!-- v2 amount -->
                                    <x-adminlte-input name="two_way_qc_t[0]" placeholder="V2 Amount" fgroup-class="col-md-1"  type="text" value="{{ old('two_way_qc_t[0]') }}" label="V2 Amount" readonly/>
                                    <!-- layout pages -->
                                    <x-adminlte-input name="layout_pages[0]" placeholder="T Layout Pages" fgroup-class="col-md-2"
                                        type="text" value="{{ old('layout_pages[0]') }}" label="T Layout Pages" />
                                    <!-- Layout Charges -->
                                    <x-adminlte-input name="layout_charges[0]" placeholder="T Layout"  fgroup-class="col-md-1" type="text" value="{{ old('layout_charges[0]') }}" label="T Layout" />
                                    <!-- bt -->
                                    <div class="form-group col-md-1">
                                        <label>BT</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" onchange="calculateBtAmount(this)" class="custom-control-input" name="bt[0]" id="bt[0]">
                                            <label class="custom-control-label" for="bt[0]"></label>
                                        </div>
                                    </div>
                                    <!-- bt rate -->
                                    <x-adminlte-input name="back_translation[0]" placeholder="BT Rate" fgroup-class="col-md-1" type="text" value="{{ old('back_translation[0]') }}" label="BT Rate" onkeyup="calculateAmount_2(this)" />
                                    <!-- bt amount -->
                                    <x-adminlte-input name="amount_bt[0]" placeholder="BT Amount" fgroup-class="col-md-1" type="text" value="{{ old('amount_bt[0]') }}" label="BT Amount" readonly />
                                    <!-- btv -->
                                    <div class="form-group col-md-1">
                                        <label>BTV</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" onchange="calculateBtvAmount(this)" class="custom-control-input" name="btv[0]" id="btv[0]">
                                            <label class="custom-control-label" for="btv[0]"></label>
                                        </div>
                                    </div>
                                    <!-- btv amount -->
                                    <x-adminlte-input name="verification_2[0]" placeholder="BTV Amount"  fgroup-class="col-md-1" type="text" value="{{ old('verification_2[0]') }}" label="BTV Amount" readonly/>
                                    <!-- bt layout pages -->
                                    <x-adminlte-input name="bt_layout_pages[0]" placeholder="BT Layout Pages"  fgroup-class="col-md-2" type="text" value="{{ old('bt_layout_pages[0]') }}" label="BT Layout  Pages" />
                                    {{-- <x-adminlte-input name="two_way_qc_bt[0]" placeholder="Two Way QC BT"
                                        fgroup-class="col-md-3" type="text" value="{{ old('two_way_qc_bt[0]') }}"
                                        label="Two Way QC BT" /> --}}
                                    <!-- BT layout charges -->
                                    <x-adminlte-input name="layout_charges_second[0]" placeholder="BT Layout" fgroup-class="col-md-2" type="text" value="{{ old('layout_charges_second[0]') }}"  label="BT Layout" />
                                    <!-- <x-adminlte-select  name="lang_0[]" fgroup-class="col-md-3" required
                                        label="Language" multiple label="Language">
                                        <option value="">Select Language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}">
                                                {{ $language->name }}</option>
                                        @endforeach
                                    </x-adminlte-select> -->
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-danger remove-item mt-3 mb-1"
                                        style="float:right;width: 100px">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary mt-2" id="add-item">Add Document</button>
                <br>
                <x-adminlte-button label="Submit" type="submit" onclick="checkValidLan(event)" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>

<script type="text/javascript">
    var rates = [];
    $(document).ready(function() {
        let itemIndex = 1;

        // $('#add-item').click(function() {
        //     let newItem = $('.repeater-item.mt-3:first').clone();
        //     newItem.find('input, select').each(function() {
        //         $(this).val('');
        //         let name = $(this).attr('name');
        //         if (name == 'verification_2[0]') {
        //             name = 'verification_2[' + itemIndex + ']';
        //         } else if (name == "lang_0[]") {
        //             name = 'lang_' + itemIndex + "[]";                   
        //             attribute = 'lang_' + itemIndex;
        //             let name = $(this).attr('name');
        //         } else {
        //             if(name!=undefined) {
        //                 name = name.replace(/\d+/, itemIndex);
        //             }
        //         }
        //         $(this).attr('name', name);
        //     });
        //     newItem.find('.card-title').html('Document ' + (itemIndex + 1));
        //     newItem.appendTo('#repeater');
        //     itemIndex++;
        // });
        $('#add-item').click(function() {
            let newItem = $('.repeater-item.mt-3:first').clone();
            newItem.find('input, checkbox').each(function() {
                $(this).prop('checked', false);
                let name = $(this).attr('name');
                if (name === 'verification_2[0]') {
                    $(this).val('');
                    name = 'verification_2[' + itemIndex + ']';
                } else if (name === "lang_0[]") {
                    name = 'lang_' + itemIndex + "[]";               
                } else {
                    $(this).val('');
                    if (name) {
                        name = name.replace(/\d+/, itemIndex);
                    }
                }
                $(this).attr('name', name);

                // Update the id and 'for' attribute to ensure they are unique
                let id = $(this).attr('id');
                if (id) {
                    id = id.replace(/\d+/, itemIndex);
                    $(this).attr('id', id);
                }

                let label = $(this).next('label');
                if (label.length > 0) {
                    let labelFor = label.attr('for');
                    if (labelFor) {
                        labelFor = labelFor.replace(/\d+/, itemIndex);
                        label.attr('for', labelFor);
                    }
                }
            });
            newItem.find('.card-title').html('Document ' + (itemIndex + 1));
            newItem.find('#dropdownMenuButton_0').text('Select Language');
            newItem.find('#dropdownMenuButton_0').attr('id','dropdownMenuButton_'+itemIndex);
            newItem.find('.dropdown-menu').attr('aria-labelledby','dropdownMenuButton_'+itemIndex);
            newItem.find('#requiredMsg_0').attr('id','requiredMsg_'+itemIndex);
            newItem.appendTo('#repeater');
            var script = document.createElement('script');
            script.textContent = "$('#dropdownMenuButton_"+itemIndex+" + div').on('click', function(e) { e.stopPropagation();});";
            document.body.appendChild(script);
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
                $(this).find('input, checkbox').each(function() {
                    let name = $(this).attr('name');
                    if (name === 'verification_2[0]') {
                        name = 'verification_2[' + itemIndex + ']';
                    } else if (name === "lang_0") {
                        name = 'lang_' + itemIndex + "[]";  
                    } else {
                        name = name.replace(/\d+/, itemIndex);
                    }
                    $(this).attr('name', name);
                    // Update the id and 'for' attribute to ensure they are unique
                    let id = $(this).attr('id');
                    if (id) {
                        id = id.replace(/\d+/, itemIndex);
                        $(this).attr('id', id);
                    }

                    let label = $(this).next('label');
                    if (label.length > 0) {
                        let labelFor = label.attr('for');
                        if (labelFor) {
                            labelFor = labelFor.replace(/\d+/, itemIndex);
                            label.attr('for', labelFor);
                        }
                    }
                });
                $(this).find('.card-title').html('Document ' + (itemIndex + 1));
                $(this).find('.dropdown-toggle').attr('id','dropdownMenuButton_'+itemIndex);
                $(this).find('.dropdown-menu').attr('aria-labelledby','dropdownMenuButton_'+itemIndex);
                $(this).find('#requiredMsg_0').attr('id','requiredMsg_'+itemIndex);
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
    
        $('#dropdownMenuButton_0 + div').on('click', function(e) {
            e.stopPropagation();
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

    function changeLan(input) {
        const index = input.name.substring(5).replace("[]", "");
        var selected = [];
        $('input[name^="lang_'+index+'"]').each(function() {
            if ($(this).is(':checked')) {
                selected.push($(this).next('label').text());
            }
        });

        $('#dropdownMenuButton_'+index).text(selected.join(', ') || 'Select Language');
        
        // Update the hidden input value and validity
        if (selected.length > 0) {
            $('#requiredMsg_'+index).hide();
        } else {
            $('#requiredMsg_'+index).show();
        }
        if (selected.length == 1) {
            getRates(index);    
        }
    }

    function getRates(index){
        const eClientId = $('#client_id option:selected').val()?$('#client_id option:selected').val():@json($clients[0]->id);
        const eRorn = $('#rorn option:selected').val()?$('#rorn option:selected').val():'normal';
        const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
        const eLang = $(`input[name="lang_${index}[]"]:checked`).first().val()?$(`input[name="lang_${index}[]"]:checked`).first().val():@json($languages[0]->id);
        $.ajax({
            url: "/estimate-management/ratecard/" + eClientId +  "/"  + eRorn +  "/" + eType +  "/" + eLang,
            method: 'GET',
            success: function(data) {
                rates[index] = data;
                if(eType == 'minimum'){
                    document.querySelector(`input[name="rate[${index}]"]`).value = data.t_minimum_rate?data.t_minimum_rate:0;
                }else{
                    document.querySelector(`input[name="rate[${index}]"]`).value = data.t_rate?data.t_rate:0;
                }
                document.querySelector(`input[name="unit[${index}]"]`).value = 0;
                document.querySelector(`input[name="amount[${index}]"]`).value = 0;
                document.querySelector(`input[name="amount_bt[${index}]"]`).value = 0;
                document.querySelector(`input[name="verification[${index}]"]`).value = 0;
                document.querySelector(`input[name="two_way_qc_t[${index}]"]`).value = 0;
                document.querySelector(`input[name="verification_2[${index}]"]`).value = 0;
            }
        });
    }

    function calculateV1Amount(input){
        const index = input.name.substring(6).replace("]", "");
        const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
        if( $(`input[name="v_one[${index}]"]:checked`).val() != undefined ){
            const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
            const rate = eType == 'minimum'?parseFloat(rates[index].v1_minimum_rate):parseFloat(rates[index].v1_rate) || 0;
            const amount = Math.round(unit * rate);
            document.querySelector(`input[name="verification[${index}]"]`).value = amount;
        }else{
            document.querySelector(`input[name="verification[${index}]"]`).value = 0;
        }
    }

    function calculateV2Amount(input){
        const index = input.name.substring(6).replace("]", "");
        const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
        if( $(`input[name="v_two[${index}]"]:checked`).val() != undefined ){
            const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
            const rate = eType == 'minimum'?parseFloat(rates[index].v2_minimum_rate):parseFloat(rates[index].v2_rate) || 0;
            const amount = Math.round(unit * rate);
            document.querySelector(`input[name="two_way_qc_t[${index}]"]`).value = amount;
        }else{
            document.querySelector(`input[name="two_way_qc_t[${index}]"]`).value = 0;
        }
    }

    function calculateBtAmount(input){
        const index = input.name.substring(3).replace("]", "");
        const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
        if( $(`input[name="bt[${index}]"]:checked`).val() != undefined ){
            const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
            const rate = eType == 'minimum'?parseFloat(rates[index].bt_minimum_rate):parseFloat(rates[index].bt_rate) || 0;
            const amount = Math.round(unit * rate);
            document.querySelector(`input[name="back_translation[${index}]"]`).value = rate;
            document.querySelector(`input[name="amount_bt[${index}]"]`).value = amount;
        }else{
            document.querySelector(`input[name="back_translation[${index}]"]`).value = 0;
            document.querySelector(`input[name="amount_bt[${index}]"]`).value = 0;
        }
    }

    function calculateBtvAmount(input){
        const index = input.name.substring(4).replace("]", "");
        const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
        if( $(`input[name="btv[${index}]"]:checked`).val() != undefined ){
            const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
            const rate = eType == 'minimum'?parseFloat(rates[index].btv_minimum_rate):parseFloat(rates[index].btv_rate) || 0;
            const amount = Math.round(unit * rate);
            document.querySelector(`input[name="verification_2[${index}]"]`).value = amount;
        }else{
            document.querySelector(`input[name="verification_2[${index}]"]`).value = 0;
        }
    }
    
    // Validate form on submit
    function checkValidLan(e){
        let i=0;
        $('.repeater-item').each(function() {
            if ($('#dropdownMenuButton_'+i).text() === 'Select Language') {
                $('#requiredMsg_'+i).show();
                e.preventDefault();
            } else {
                $('#requiredMsg_'+i).hide();
            }
            // if ($('input[name="lang_'+i+'[]"]:checked').val() === '' || $('input[name="lang_'+i+'[]"]:checked').val() === undefined ) {
            //     $('#requiredMsg_'+i).show();
            //     e.preventDefault();
            // } else {
            //     $('#requiredMsg_'+i).hide();
            // }
            i++;
        });
    }
</script>
