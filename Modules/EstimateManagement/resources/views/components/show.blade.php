@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=App\Models\Metrix::get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp

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
        <x-adminlte-card title="View Estimate" theme="success" icon="fas fa-lg fa-person">

            <form method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="estimate_no" placeholder="Estimate Number" fgroup-class="col-md-3" required
                        value="{{ $estimate->estimate_no }}" label="Estimate Number" disabled />
                        <x-adminlte-select name="metrix" fgroup-class="col-md-3" required label="Metrix" disabled>
                            <option value="">Select Metrix</option>
                            @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}" @if ($estimate->metrix == $metric->id) selected @endif>
                                {{ $metric->name }}</option>
                        @endforeach
                        </x-adminlte-select>
                    <x-adminlte-input name="client_id" placeholder="Client Name" fgroup-class="col-md-3"
                        value="{{ $estimate->client->name??'' }}" disabled label="Client Name" />
                    <x-adminlte-input name="client_contact_person_id" placeholder="Client Contact Person Name"
                        fgroup-class="col-md-3" value="{{ $estimate->client_person->name??'' }}" disabled
                        label="Client Contact Person Name" />
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-3" type="text"
                        value="{{ $estimate->headline }}" required label="Headline" disabled />
                    <x-adminlte-input name="amount" placeholder="Amount" fgroup-class="col-md-3" type="text"
                        value="{{ $estimate->amount }}" required label="Amount" disabled />
                        <x-adminlte-input name="currency" placeholder="Currency" fgroup-class="col-md-3" type='text'
                        value="{{ $estimate->currency }}" disabled label="Currency" />
                    <x-adminlte-select name="status" fgroup-class="col-md-3" required label="Status" disabled>
                        <option value="">Select Status</option>
                        <option value="0" @if ($estimate->status == '0') selected @endif>Pending</option>
                        <option value="1" @if ($estimate->status == '1') selected @endif>Approve</option>
                        <option value="2" @if ($estimate->status == '2') selected @endif>Reject</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="discount" placeholder="discount" fgroup-class="col-md-3" type="text"
                        value="{{ old('discount', $estimate->discount) }}" required label="Discount" disabled/>
                    
                </div>
                <div id="repeater">
                    @foreach ($estimate->details as $index => $detail)
                        <div class="repeater-item mt-3">
                            <div class="row">
                                <x-adminlte-input name="document_name[{{ $index }}]" placeholder="Document Name"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('document_name.' . $index, $detail->document_name) }}" required
                                    label="Document Name" disabled />

                                <x-adminlte-select name="type[{{ $index }}]" fgroup-class="col-md-3" required
                                    label="Type" disabled>
                                    <option value="">Select Type</option>
                                    <option value="word"
                                        {{ old('type.' . $index, $detail->type) == 'word' ? 'selected' : '' }}>Word
                                    </option>
                                    <option value="unit"
                                        {{ old('type.' . $index, $detail->type) == 'unit' ? 'selected' : '' }}>Unit
                                    </option>
                                </x-adminlte-select>
                                <x-adminlte-input name="unit[{{ $index }}]" placeholder="Unit"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('unit.' . $index, $detail->unit) }}" required label="Unit"
                                    disabled />
                                <x-adminlte-input name="rate[{{ $index }}]" placeholder="Rate"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('rate.' . $index, $detail->rate) }}" required label="Rate"
                                    disabled />
                                <x-adminlte-input name="verification[{{ $index }}]" placeholder="Verification"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('verification.' . $index, $detail->verification) }}" required
                                    label="Verification" disabled />
                                    <x-adminlte-input name="layout_charges[{{ $index }}]"
                                    placeholder="Layout Charges" fgroup-class="col-md-3" type="text"
                                    value="{{ old('layout_charges.' . $index, $detail->layout_charges) }}" required
                                    label="Layout Charges" disabled />
                                    <x-adminlte-input name="back_translation[{{ $index }}]"
                                    placeholder="Back Translation" fgroup-class="col-md-3" type="text"
                                    value="{{ old('back_translation.' . $index, $detail->back_translation) }}" required
                                    label="Back Translation" disabled />
                                    <x-adminlte-input name="verification_2[{{ $index }}]" placeholder="Back Translation Verification"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('verification_2.' . $index, $detail->verification_2) }}" required
                                    label="Back Translation Verification" disabled />
                                <x-adminlte-input name="layout_charges_second[{{ $index }}]"
                                    placeholder="Layout Charges 2" fgroup-class="col-md-3" type="text"
                                    value="{{ old('layout_charges_second.' . $index, $detail->layout_charges_2) }}"
                                    required label="Layout Charges 2" disabled />
                                <x-adminlte-input name="lang[{{ $index }}]" placeholder="Lang"
                                    fgroup-class="col-md-3" type="text"
                                    value="{{ old('lang.' . $index, $detail->lang) }}" required label="Lang"
                                    disabled />
                            </div>

                        </div>
                    @endforeach
                </div>
                <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
