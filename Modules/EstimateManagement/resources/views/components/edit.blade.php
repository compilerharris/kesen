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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/estimate-management">Estimate </a></li>
                <li class="breadcrumb-item ">{{$estimate->estimate_no}}</li>
                
            </ol>
        </nav>
        <x-adminlte-card style="background-color: #eaecef;" title="Edit Estimate" theme="info" icon="fas fa-lg fa-person">
            <form action="{{ route('estimatemanagement.update', $estimate->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select2  :config="$config"  name="client_id" id="client_id" fgroup-class="col-md-2" required label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ $estimate->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-2" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                        @foreach ($contact_persons as $contactPerson)
                            <option value="{{ $contactPerson->id }}"
                                {{ $estimate->client_contact_person_id == $contactPerson->id ? 'selected' : '' }}>
                                {{ $contactPerson->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-2" type="text"
                        value="{{ $estimate->headline }}" required label="Headline" />
                    <x-adminlte-select2 name="currency" id="currency" placeholder="Currency" fgroup-class="col-md-2" required
                        value="{{ old('currency', $estimate->currency) }}" label="Currency">
                        <option value="">Select Currency</option>
                        <option value="AFN" @if ($estimate->currency == 'AFN') selected @endif label="Afghan afghani">
                            AFN</option>
                        <option value="ALL" @if ($estimate->currency == 'ALL') selected @endif label="Albanian lek">
                            ALL</option>
                        <option value="DZD" @if ($estimate->currency == 'DZD') selected @endif label="Algerian dinar">
                            DZD</option>
                        <option value="AOA" @if ($estimate->currency == 'AOA') selected @endif label="Angolan kwanza">
                            AOA</option>
                        <option value="ARS" @if ($estimate->currency == 'ARS') selected @endif label="Argentine peso">
                            ARS</option>
                        <option value="AMD" @if ($estimate->currency == 'AMD') selected @endif label="Armenian dram">
                            AMD</option>
                        <option value="AWG" @if ($estimate->currency == 'AWG') selected @endif label="Aruban florin">
                            AWG</option>
                        <option value="AUD" @if ($estimate->currency == 'AUD') selected @endif
                            label="Australian dollar">AUD</option>
                        <option value="AZN" @if ($estimate->currency == 'AZN') selected @endif
                            label="Azerbaijani manat">AZN</option>
                        <option value="BHD" @if ($estimate->currency == 'BHD') selected @endif
                            label="Bahraini dinar">BHD</option>
                        <option value="BSD" @if ($estimate->currency == 'BSD') selected @endif
                            label="Bahamian dollar">BSD</option>
                        <option value="BDT" @if ($estimate->currency == 'BDT') selected @endif
                            label="Bangladeshi taka">BDT</option>
                        <option value="BBD" @if ($estimate->currency == 'BBD') selected @endif
                            label="Barbadian dollar">BBD</option>
                        <option value="BYN" @if ($estimate->currency == 'BYN') selected @endif
                            label="Belarusian ruble">BYN</option>
                        <option value="BZD" @if ($estimate->currency == 'BZD') selected @endif
                            label="Belize dollar">BZD</option>
                        <option value="BMD" @if ($estimate->currency == 'BMD') selected @endif
                            label="Bermudian dollar">BMD</option>
                        <option value="BTN" @if ($estimate->currency == 'BTN') selected @endif
                            label="Bhutanese ngultrum">BTN</option>
                        <option value="BOB" @if ($estimate->currency == 'BOB') selected @endif
                            label="Bolivian boliviano">BOB</option>
                        <option value="BAM" @if ($estimate->currency == 'BAM') selected @endif
                            label="Bosnia and Herzegovina convertible mark">BAM</option>
                        <option value="BWP" @if ($estimate->currency == 'BWP') selected @endif
                            label="Botswana pula">BWP</option>
                        <option value="BRL" @if ($estimate->currency == 'BRL') selected @endif
                            label="Brazilian real">BRL</option>
                        <option value="GBP" @if ($estimate->currency == 'GBP') selected @endif
                            label="British pound">GBP</option>
                        <option value="BND" @if ($estimate->currency == 'BND') selected @endif
                            label="Brunei dollar">BND</option>
                        <option value="MMK" @if ($estimate->currency == 'MMK') selected @endif label="Burmese kyat">
                            MMK</option>
                        <option value="BIF" @if ($estimate->currency == 'BIF') selected @endif
                            label="Burundian franc">BIF</option>
                        <option value="KHR" @if ($estimate->currency == 'KHR') selected @endif
                            label="Cambodian riel">KHR</option>
                        <option value="CAD" @if ($estimate->currency == 'CAD') selected @endif
                            label="Canadian dollar">CAD</option>
                        <option value="CVE" @if ($estimate->currency == 'CVE') selected @endif
                            label="Cape Verdean escudo">CVE</option>
                        <option value="KYD" @if ($estimate->currency == 'KYD') selected @endif
                            label="Cayman Islands dollar">KYD</option>
                        <option value="XAF" @if ($estimate->currency == 'XAF') selected @endif
                            label="Central African CFA franc">XAF</option>
                        <option value="XPF" @if ($estimate->currency == 'XPF') selected @endif label="CFP franc">
                            XPF</option>
                        <option value="CLP" @if ($estimate->currency == 'CLP') selected @endif
                            label="Chilean peso">CLP</option>
                        <option value="CNY" @if ($estimate->currency == 'CNY') selected @endif
                            label="Chinese yuan">CNY</option>
                        <option value="COP" @if ($estimate->currency == 'COP') selected @endif
                            label="Colombian peso">COP</option>
                        <option value="KMF" @if ($estimate->currency == 'KMF') selected @endif
                            label="Comorian franc">KMF</option>
                        <option value="CDF" @if ($estimate->currency == 'CDF') selected @endif
                            label="Congolese franc">CDF</option>
                        <option value="CRC" @if ($estimate->currency == 'CRC') selected @endif
                            label="Costa Rican colón">CRC</option>
                        <option value="HRK" @if ($estimate->currency == 'HRK') selected @endif
                            label="Croatian kuna">HRK</option>
                        <option value="CUC" @if ($estimate->currency == 'CUC') selected @endif
                            label="Cuban convertible peso">CUC</option>
                        <option value="CUP" @if ($estimate->currency == 'CUP') selected @endif label="Cuban peso">
                            CUP</option>
                        <option value="CZK" @if ($estimate->currency == 'CZK') selected @endif
                            label="Czech koruna">CZK</option>
                        <option value="DKK" @if ($estimate->currency == 'DKK') selected @endif
                            label="Danish krone">DKK</option>
                        <option value="DOP" @if ($estimate->currency == 'DOP') selected @endif
                            label="Dominican peso">DOP</option>
                        <option value="DJF" @if ($estimate->currency == 'DJF') selected @endif
                            label="Djiboutian franc">DJF</option>
                        <option value="XCD" @if ($estimate->currency == 'XCD') selected @endif
                            label="Eastern Caribbean dollar">XCD</option>
                        <option value="EGP" @if ($estimate->currency == 'EGP') selected @endif
                            label="Egyptian pound">EGP</option>
                        <option value="ERN" @if ($estimate->currency == 'ERN') selected @endif
                            label="Eritrean nakfa">ERN</option>
                        <option value="ETB" @if ($estimate->currency == 'ETB') selected @endif
                            label="Ethiopian birr">ETB</option>
                        <option value="EUR" @if ($estimate->currency == 'EUR') selected @endif label="Euro">EUR
                        </option>
                        <option value="FKP" @if ($estimate->currency == 'FKP') selected @endif
                            label="Falkland Islands pound">FKP</option>
                        <option value="FJD" @if ($estimate->currency == 'FJD') selected @endif
                            label="Fijian dollar">FJD</option>
                        <option value="GMD" @if ($estimate->currency == 'GMD') selected @endif
                            label="Gambian dalasi">GMD</option>
                        <option value="GEL" @if ($estimate->currency == 'GEL') selected @endif
                            label="Georgian lari">GEL</option>
                        <option value="GHS" @if ($estimate->currency == 'GHS') selected @endif
                            label="Ghanaian cedi">GHS</option>
                        <option value="GIP" @if ($estimate->currency == 'GIP') selected @endif
                            label="Gibraltar pound">GIP</option>
                        <option value="GTQ" @if ($estimate->currency == 'GTQ') selected @endif
                            label="Guatemalan quetzal">GTQ</option>
                        <option value="GGP" @if ($estimate->currency == 'GGP') selected @endif
                            label="Guernsey pound">GGP</option>
                        <option value="GNF" @if ($estimate->currency == 'GNF') selected @endif
                            label="Guinean franc">GNF</option>
                        <option value="GYD" @if ($estimate->currency == 'GYD') selected @endif
                            label="Guyanese dollar">GYD</option>
                        <option value="HTG" @if ($estimate->currency == 'HTG') selected @endif
                            label="Haitian gourde">HTG</option>
                        <option value="HNL" @if ($estimate->currency == 'HNL') selected @endif
                            label="Honduran lempira">HNL</option>
                        <option value="HKD" @if ($estimate->currency == 'HKD') selected @endif
                            label="Hong Kong dollar">HKD</option>
                        <option value="HUF" @if ($estimate->currency == 'HUF') selected @endif
                            label="Hungarian forint">HUF</option>
                        <option value="ISK" @if ($estimate->currency == 'ISK') selected @endif
                            label="Icelandic króna">ISK</option>
                        <option value="INR" @if ($estimate->currency == 'INR') selected @endif
                            label="Indian rupee">INR</option>
                        <option value="IDR" @if ($estimate->currency == 'IDR') selected @endif
                            label="Indonesian rupiah">IDR</option>
                        <option value="IRR" @if ($estimate->currency == 'IRR') selected @endif
                            label="Iranian rial">IRR</option>
                        <option value="IQD" @if ($estimate->currency == 'IQD') selected @endif
                            label="Iraqi dinar">IQD</option>
                        <option value="ILS" @if ($estimate->currency == 'ILS') selected @endif
                            label="Israeli new shekel">ILS</option>
                        <option value="JMD" @if ($estimate->currency == 'JMD') selected @endif
                            label="Jamaican dollar">JMD</option>
                        <option value="JPY" @if ($estimate->currency == 'JPY') selected @endif
                            label="Japanese yen">JPY</option>
                        <option value="JEP" @if ($estimate->currency == 'JEP') selected @endif
                            label="Jersey pound">JEP</option>
                        <option value="JOD" @if ($estimate->currency == 'JOD') selected @endif
                            label="Jordanian dinar">JOD</option>
                        <option value="KZT" @if ($estimate->currency == 'KZT') selected @endif
                            label="Kazakhstani tenge">KZT</option>
                        <option value="KES" @if ($estimate->currency == 'KES') selected @endif
                            label="Kenyan shilling">KES</option>
                        <option value="KID" @if ($estimate->currency == 'KID') selected @endif
                            label="Kiribati dollar">KID</option>
                        <option value="KGS" @if ($estimate->currency == 'KGS') selected @endif
                            label="Kyrgyzstani som">KGS</option>
                        <option value="KWD" @if ($estimate->currency == 'KWD') selected @endif
                            label="Kuwaiti dinar">KWD</option>
                        <option value="LAK" @if ($estimate->currency == 'LAK') selected @endif label="Lao kip">LAK
                        </option>
                        <option value="LBP" @if ($estimate->currency == 'LBP') selected @endif
                            label="Lebanese pound">LBP</option>
                        <option value="LSL" @if ($estimate->currency == 'LSL') selected @endif
                            label="Lesotho loti">LSL</option>
                        <option value="LRD" @if ($estimate->currency == 'LRD') selected @endif
                            label="Liberian dollar">LRD</option>
                        <option value="LYD" @if ($estimate->currency == 'LYD') selected @endif
                            label="Libyan dinar">LYD</option>
                        <option value="MOP" @if ($estimate->currency == 'MOP') selected @endif
                            label="Macanese pataca">MOP</option>
                        <option value="MKD" @if ($estimate->currency == 'MKD') selected @endif
                            label="Macedonian denar">MKD</option>
                        <option value="MGA" @if ($estimate->currency == 'MGA') selected @endif
                            label="Malagasy ariary">MGA</option>
                        <option value="MWK" @if ($estimate->currency == 'MWK') selected @endif
                            label="Malawian kwacha">MWK</option>
                        <option value="MYR" @if ($estimate->currency == 'MYR') selected @endif
                            label="Malaysian ringgit">MYR</option>
                        <option value="MVR" @if ($estimate->currency == 'MVR') selected @endif
                            label="Maldivian rufiyaa">MVR</option>
                        <option value="IMP" @if ($estimate->currency == 'IMP') selected @endif label="Manx pound">
                            IMP</option>
                        <option value="MRU" @if ($estimate->currency == 'MRU') selected @endif
                            label="Mauritanian ouguiya">MRU</option>
                        <option value="MUR" @if ($estimate->currency == 'MUR') selected @endif
                            label="Mauritian rupee">MUR</option>
                        <option value="MXN" @if ($estimate->currency == 'MXN') selected @endif
                            label="Mexican peso">MXN</option>
                        <option value="MDL" @if ($estimate->currency == 'MDL') selected @endif
                            label="Moldovan leu">MDL</option>
                        <option value="MNT" @if ($estimate->currency == 'MNT') selected @endif
                            label="Mongolian tögrög">MNT</option>
                        <option value="MAD" @if ($estimate->currency == 'MAD') selected @endif
                            label="Moroccan dirham">MAD</option>
                        <option value="MZN" @if ($estimate->currency == 'MZN') selected @endif
                            label="Mozambican metical">MZN</option>
                        <option value="NAD" @if ($estimate->currency == 'NAD') selected @endif
                            label="Namibian dollar">NAD</option>
                        <option value="NPR" @if ($estimate->currency == 'NPR') selected @endif
                            label="Nepalese rupee">NPR</option>
                        <option value="ANG" @if ($estimate->currency == 'ANG') selected @endif
                            label="Netherlands Antillean guilder">ANG</option>
                        <option value="TWD" @if ($estimate->currency == 'TWD') selected @endif
                            label="New Taiwan dollar">TWD</option>
                        <option value="NZD" @if ($estimate->currency == 'NZD') selected @endif
                            label="New Zealand dollar">NZD</option>
                        <option value="NIO" @if ($estimate->currency == 'NIO') selected @endif
                            label="Nicaraguan córdoba">NIO</option>
                        <option value="NGN" @if ($estimate->currency == 'NGN') selected @endif
                            label="Nigerian naira">NGN</option>
                        <option value="KPW" @if ($estimate->currency == 'KPW') selected @endif
                            label="North Korean won">KPW</option>
                        <option value="NOK" @if ($estimate->currency == 'NOK') selected @endif
                            label="Norwegian krone">NOK</option>
                        <option value="OMR" @if ($estimate->currency == 'OMR') selected @endif
                            label="Omani rial">OMR</option>
                        <option value="PKR" @if ($estimate->currency == 'PKR') selected @endif
                            label="Pakistani rupee">PKR</option>
                        <option value="PAB" @if ($estimate->currency == 'PAB') selected @endif
                            label="Panamanian balboa">PAB</option>
                        <option value="PGK" @if ($estimate->currency == 'PGK') selected @endif
                            label="Papua New Guinean kina">PGK</option>
                        <option value="PYG" @if ($estimate->currency == 'PYG') selected @endif
                            label="Paraguayan guaraní">PYG</option>
                        <option value="PEN" @if ($estimate->currency == 'PEN') selected @endif
                            label="Peruvian sol">PEN</option>
                        <option value="PHP" @if ($estimate->currency == 'PHP') selected @endif
                            label="Philippine peso">PHP</option>
                        <option value="PLN" @if ($estimate->currency == 'PLN') selected @endif
                            label="Polish złoty">PLN</option>
                        <option value="QAR" @if ($estimate->currency == 'QAR') selected @endif
                            label="Qatari riyal">QAR</option>
                        <option value="RON" @if ($estimate->currency == 'RON') selected @endif
                            label="Romanian leu">RON</option>
                        <option value="RUB" @if ($estimate->currency == 'RUB') selected @endif
                            label="Russian ruble">RUB</option>
                        <option value="RWF" @if ($estimate->currency == 'RWF') selected @endif
                            label="Rwandan franc">RWF</option>
                        <option value="SHP" @if ($estimate->currency == 'SHP') selected @endif
                            label="Saint Helena pound">SHP</option>
                        <option value="WST" @if ($estimate->currency == 'WST') selected @endif
                            label="Samoan tālā">WST</option>
                        <option value="STN" @if ($estimate->currency == 'STN') selected @endif
                            label="São Tomé and Príncipe dobra">STN</option>
                        <option value="SAR" @if ($estimate->currency == 'SAR') selected @endif
                            label="Saudi riyal">SAR</option>
                        <option value="RSD" @if ($estimate->currency == 'RSD') selected @endif
                            label="Serbian dinar">RSD</option>
                        <option value="SLL" @if ($estimate->currency == 'SLL') selected @endif
                            label="Sierra Leonean leone">SLL</option>
                        <option value="SGD" @if ($estimate->currency == 'SGD') selected @endif
                            label="Singapore dollar">SGD</option>
                        <option value="SOS" @if ($estimate->currency == 'SOS') selected @endif
                            label="Somali shilling">SOS</option>
                        <option value="SLS" @if ($estimate->currency == 'SLS') selected @endif
                            label="Somaliland shilling">SLS</option>
                        <option value="ZAR" @if ($estimate->currency == 'ZAR') selected @endif
                            label="South African rand">ZAR</option>
                        <option value="KRW" @if ($estimate->currency == 'KRW') selected @endif
                            label="South Korean won">KRW</option>
                        <option value="SSP" @if ($estimate->currency == 'SSP') selected @endif
                            label="South Sudanese pound">SSP</option>
                        <option value="SRD" @if ($estimate->currency == 'SRD') selected @endif
                            label="Surinamese dollar">SRD</option>
                        <option value="SEK" @if ($estimate->currency == 'SEK') selected @endif
                            label="Swedish krona">SEK</option>
                        <option value="CHF" @if ($estimate->currency == 'CHF') selected @endif
                            label="Swiss franc">CHF</option>
                        <option value="LKR" @if ($estimate->currency == 'LKR') selected @endif
                            label="Sri Lankan rupee">LKR</option>
                        <option value="SZL" @if ($estimate->currency == 'SZL') selected @endif
                            label="Swazi lilangeni">SZL</option>
                        <option value="SYP" @if ($estimate->currency == 'SYP') selected @endif
                            label="Syrian pound">SYP</option>
                        <option value="TJS" @if ($estimate->currency == 'TJS') selected @endif
                            label="Tajikistani somoni">TJS</option>
                        <option value="TZS" @if ($estimate->currency == 'TZS') selected @endif
                            label="Tanzanian shilling">TZS</option>
                        <option value="THB" @if ($estimate->currency == 'THB') selected @endif
                            label="Thai baht">THB</option>
                        <option value="TOP" @if ($estimate->currency == 'TOP') selected @endif
                            label="Tongan paʻanga">TOP</option>
                        <option value="PRB" @if ($estimate->currency == 'PRB') selected @endif
                            label="Transnistrian ruble">PRB</option>
                        <option value="TTD" @if ($estimate->currency == 'TTD') selected @endif
                            label="Trinidad and Tobago dollar">TTD</option>
                        <option value="TND" @if ($estimate->currency == 'TND') selected @endif
                            label="Tunisian dinar">TND</option>
                        <option value="TRY" @if ($estimate->currency == 'TRY') selected @endif
                            label="Turkish lira">TRY</option>
                        <option value="TMT" @if ($estimate->currency == 'TMT') selected @endif
                            label="Turkmenistan manat">TMT</option>
                        <option value="TVD" @if ($estimate->currency == 'TVD') selected @endif
                            label="Tuvaluan dollar">TVD</option>
                        <option value="UGX" @if ($estimate->currency == 'UGX') selected @endif
                            label="Ugandan shilling">UGX</option>
                        <option value="UAH" @if ($estimate->currency == 'UAH') selected @endif
                            label="Ukrainian hryvnia">UAH</option>
                        <option value="AED" @if ($estimate->currency == 'AED') selected @endif
                            label="United Arab Emirates dirham">AED</option>
                        <option value="USD" @if ($estimate->currency == 'USD') selected @endif
                            label="United States dollar">USD</option>
                        <option value="UYU" @if ($estimate->currency == 'UYU') selected @endif
                            label="Uruguayan peso">UYU</option>
                        <option value="UZS" @if ($estimate->currency == 'UZS') selected @endif
                            label="Uzbekistani soʻm">UZS</option>
                        <option value="VUV" @if ($estimate->currency == 'VUV') selected @endif
                            label="Vanuatu vatu">VUV</option>
                        <option value="VES" @if ($estimate->currency == 'VES') selected @endif
                            label="Venezuelan bolívar soberano">VES</option>
                        <option value="VND" @if ($estimate->currency == 'VND') selected @endif
                            label="Vietnamese đồng">VND</option>
                        <option value="XOF" @if ($estimate->currency == 'XOF') selected @endif
                            label="West African CFA franc">XOF</option>
                        <option value="ZMW" @if ($estimate->currency == 'ZMW') selected @endif
                            label="Zambian kwacha">ZMW</option>
                        <option value="ZWB" @if ($estimate->currency == 'ZWB') selected @endif
                            label="Zimbabwean bonds">ZWB</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-2" type='date'
                        value="{{ old('date', $estimate->date) }}" required label="Mail Received on" />
                    <x-adminlte-input name="discount" placeholder="Discount" fgroup-class="col-md-2" type="text"
                        value="{{ old('discount', $estimate->discount) }}" label="Discount" />
                    <x-adminlte-select2 name="rorn" id="rorn" fgroup-class="col-md-2" required value="{{ old('rorn') }}"
                        label="Rush/Normal">
                        <option value="normal" {{$estimate->rorn=="normal"?"selected":""}}>Normal</option>
                        <option value="rush" {{$estimate->rorn=="rush"?"selected":""}}>Rush</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="type" fgroup-class="col-md-2" required label="Type">
                            <option value="">Select Type</option>
                            <option value="words" {{ old('type.', $estimate->type) == 'words' ? 'selected' : '' }}>Words
                            </option>
                            <option value="unit" {{ old('type', $estimate->type) == 'unit' ? 'selected' : '' }}>Unit
                            </option>
                            <option value="minimum" {{ old('type', $estimate->type) == 'minimum' ? 'selected' : '' }}>
                                Minimum</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="status" fgroup-class="col-md-2" required label="Status">
                        <option value="">Select Status</option>
                        <option value="0" @if ($estimate->status == '0') selected @endif>Pending</option>
                        <option value="1" @if ($estimate->status == '1') selected @endif>Approve</option>
                        <option value="2" @if ($estimate->status == '2') selected @endif>Reject</option>
                    </x-adminlte-select2>
                    

                   
                    <div id="repeater">
                        @foreach ($estimate_details as $index => $detail)
                            <div class="repeater-item mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Documents {{ $index + 1 }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- laguages -->
                                            <div class="{{ $fgroupClass ?? '' }} mb-3" style="padding-left:7.5px;">
                                                <label>Languages</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton_{{ $index }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{count($detail->languagesNames)>0?implode(', ',$detail->languagesNames):"Select Language"}}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $index }}" style="max-height: 200px; overflow-y: auto; padding: 5px;">
                                                        @foreach ($languages as $option)
                                                            <div class="custom-control custom-checkbox dropdown-item">
                                                                <input type="checkbox" class="custom-control-input" id="checkbox-{{ $index }}-{{ $option->id }}" onclick="changeLan(this)" name="lang_{{ $index }}[]" value="{{ $option->id }}" {{ in_array($option->id, $detail->languages) ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="checkbox-{{ $index }}-{{ $option->id }}">{{ $option->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback is-invalid" id="requiredMsg_{{ $index }}">Please select at least one language.</div>
                                            </div>
                                            <!-- document -->
                                            <x-adminlte-input name="document_name[{{ $index }}]" placeholder="Document Name"  fgroup-class="col-md-4" type="text" value="{{ old('document_name.' . $index,  $detail->document_name) }}" required label="Document Name" readonly />
                                            <!-- unit -->
                                            <x-adminlte-input name="unit[{{ $index }}]" placeholder="Unit" fgroup-class="col-md-2" type="text" value="{{ old('unit.' . $index, $detail->unit) }}" required label="Unit" onkeyup="calculateAmount(this)" min="1" />
                                            <!-- t rate -->
                                            <x-adminlte-input name="rate[{{ $index }}]" placeholder="T Rate" fgroup-class="col-md-1" type="text" value="{{ old('rate.' . $index, $detail->rate) }}" required label="T Rate" onkeyup="calculateAmount(this)" />
                                            <!-- t amount -->
                                            <x-adminlte-input name="amount[{{ $index }}]" placeholder="T Amount" fgroup-class="col-md-1" type="text" value="{{ ceil($detail->unit * $detail->rate) }}"  label="T Amount" readonly />
                                            <!-- v1 -->
                                            <div class="form-group col-md-1">
                                                <label>V1</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" onchange="calculateV1Amount(this)"  class="custom-control-input" name="v_one[{{$index}}]" id="v_one[{{$index}}]" {{$detail->v1?"checked":""}}>
                                                    <label class="custom-control-label" for="v_one[{{$index}}]"></label>
                                                </div>
                                            </div>
                                            <!-- v1 amount -->
                                            <x-adminlte-input name="verification[{{ $index }}]" placeholder="V1 Amount"  fgroup-class="col-md-1" type="text" value="{{ old('verification.' . $index,  $detail->verification) }}" label="V1 Amount" readonly />
                                            <!-- v2 -->
                                            <div class="form-group col-md-1">
                                                <label>V2</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" onchange="calculateV2Amount(this)"  class="custom-control-input" name="v_two[{{$index}}]" id="v_two[{{$index}}]" {{$detail->v2?"checked":""}}>
                                                    <label class="custom-control-label" for="v_two[{{$index}}]"></label>
                                                </div>
                                            </div>
                                            <!-- v2 amount -->
                                            <x-adminlte-input name="two_way_qc_t[{{ $index }}]" placeholder="V2 Amount"  fgroup-class="col-md-1" type="text" value="{{ old('two_way_qc_t.' . $index,  $detail->two_way_qc_t) }}" label="V2 Amount" readonly/>
                                            <!-- layout pages -->
                                            <x-adminlte-input name="layout_pages[{{ $index }}]" placeholder="T Layout Pages"  fgroup-class="col-md-2" type="text" value="{{ old('layout_pages.' . $index,  $detail->layout_pages) }}" label="T Layout Pages" />
                                            <!-- layout charges -->
                                            <x-adminlte-input name="layout_charges[{{ $index }}]" placeholder="T Layout"  fgroup-class="col-md-1" type="text" value="{{ old('layout_charges.' . $index,  $detail->layout_charges) }}" label="T Layout" />
                                            <!-- bt -->
                                            <div class="form-group col-md-1">
                                                <label>BT</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" onchange="calculateBtAmount(this)" class="custom-control-input" name="bt[{{$index}}]" id="bt[{{$index}}]"{{$detail->bt?"checked":""}}>
                                                    <label class="custom-control-label" for="bt[{{$index}}]"></label>
                                                </div>
                                            </div>
                                            <!-- bt rate -->
                                            <x-adminlte-input name="back_translation[{{ $index }}]" placeholder="BT Rate" fgroup-class="col-md-1" type="text" value="{{ old('back_translation.' . $index,  $detail->back_translation) }}" label="BT Rate" onkeyup="calculateAmount_2(this)" />
                                            <!-- bt amount -->
                                            <x-adminlte-input name="amount_bt[{{ $index }}]" placeholder="BT Amount" fgroup-class="col-md-1" type="text" value="{{ $detail->unit *  $detail->back_translation }}" label="BT Amount" readonly />
                                            <!-- BTV -->
                                            <div class="form-group col-md-1">
                                                <label>BTV</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" onchange="calculateBtvAmount(this)"  class="custom-control-input" name="btv[{{$index}}]" id="btv[{{$index}}]" {{$detail->btv?"checked":""}}>
                                                    <label class="custom-control-label" for="btv[{{$index}}]"></label>
                                                </div>
                                            </div>
                                            <!-- btv -->
                                            <x-adminlte-input name="verification_2[{{ $index }}]" placeholder="BTV Amount" fgroup-class="col-md-1" type="text" value="{{ old('verification_2.' .  $index, $detail->verification_2) }}" label="BTV Amount" readonly/>
                                            {{-- <x-adminlte-input name="two_way_qc_bt[{{ $index }}]"
                                                placeholder="Two Way QC BT" fgroup-class="col-md-3" type="text"
                                                value="{{ old('two_way_qc_bt.' . $index, $detail->two_way_qc_bt) }}"
                                                label="Two Way QC BT" /> --}}
                                            <!-- bt layout pages -->
                                            <x-adminlte-input name="bt_layout_pages[{{ $index }}]" placeholder="BT Layout Pages"  fgroup-class="col-md-2" type="text" value="{{ old('bt_layout_pages.' . $index,  $detail->bt_layout_pages) }}" label="BT Layout Pages" />
                                            <!-- bt layout charges -->
                                            <x-adminlte-input name="layout_charges_second[{{ $index }}]" placeholder="BT Layout Charges" fgroup-class="col-md-2" type="text" value="{{ old('layout_charges_second.' . $index, $detail->layout_charges_2) }}" label="BT Layout Charges" />
                                            <!-- <x-adminlte-select name="lang_{{ $index }}[]"
                                                fgroup-class="col-md-3" label="Language" multiple for="lang_{{ $index }}" >
                                                <option value="">Select Language</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}"
                                                        {{ in_array($language->id, $detail->languages) ? 'selected' : '' }}>
                                                        {{ $language->name }}</option>
                                                @endforeach
                                            </x-adminlte-select> -->
                                        </div>
                                        <div class="row">
                                            <input type="button" name="button"
                                                class="btn btn-danger remove-item mt-3 mb-1"
                                                style="float:right;width: 100px"
                                                data-detail-name="{{ $detail->document_name }}"
                                                data-detail-unit="{{ $detail->unit }}"
                                                data-detail-rate="{{ $detail->rate }}"
                                                data-detail-estimateid="{{ $detail->estimate_id }}"
                                                value="Remove"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        loadRatecard(@json($estimate_details));
        addLangScripts();  
        let tempIndex = {{ count($estimate_details) }};
        let itemIndex = {{ count($estimate_details) }};

        $('#add-item').click(function() {
            let newItem = $('.repeater-item.mt-3:first').clone();
            newItem.find('.card-title').html('Document ' + (itemIndex + 1));
            newItem.find('input, checkbox').each(function() {
                $(this).prop('checked', false);
                let name = $(this).attr('name');
                if(name != "lang_0[]"){
                    $(this).val('');
                }
                if (name == "button") {
                    $(this).attr('value', 'Remove');
                    $(this).attr('data-detail-estimateid', '');
                } else {
                    name = name.replace(/\d+/, itemIndex);
                    $(this).attr('name', name);
                    if (name == 'document_name[' + itemIndex + ']') {
                        $(this).removeAttr('readonly');
                    }
                }
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
                let detailName = $(this).data('detail-name');
                let detailUnit = $(this).data('detail-unit');
                let detailRate = $(this).data('detail-rate');
                let detailEstimateId = $(this).data('detail-estimateid');

                if (detailName && detailUnit && detailRate && detailEstimateId) {
                    $.ajax({
                        url: "{{ url('/estimate-management/detail/delete') }}",
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            document_name: detailName,
                            unit: detailUnit,
                            rate: detailRate,
                            estimate_id: detailEstimateId
                        },
                        success: function(response) {
                            tempIndex--;
                            console.log(response.success);
                        }
                    });
                }
                $(this).closest('.repeater-item').remove();
                updateIndices();
            }
        });

        function updateIndices() {
            itemIndex = 0;
            // $('.repeater-item').each(function() {
            //     let newItem = $(this);
            //     newItem.find('input, select').each(function() {
            //         let name = $(this).attr('name');
            //         name = name.replace(/\d+/, itemIndex);
            //         $(this).attr('name', name);
            //         if (name == 'document_name[' + itemIndex + ']') {
            //             $(this).removeAttr('readonly');
            //         }
            //     });
            //     newItem.find('.card-title').html('Document ' + (itemIndex + 1));
            //     itemIndex++;
            // });
            $('.repeater-item').each(function() {
                let newItem = $(this);
                newItem.find('input, checkbox').each(function() {
                    let name = $(this).attr('name');
                    name = name.replace(/\d+/, itemIndex);
                    $(this).attr('name', name);
                    if (name == 'document_name[' + itemIndex + ']') {
                        $(this).removeAttr('readonly');
                    }
                    newItem.attr('name', name);
                    // Update the id and 'for' attribute to ensure they are unique
                    let id = newItem.attr('id');
                    if (id) {
                        id = id.replace(/\d+/, itemIndex);
                        newItem.attr('id', id);
                    }

                    let label = newItem.next('label');
                    if (label.length > 0) {
                        let labelFor = label.attr('for');
                        if (labelFor) {
                            labelFor = labelFor.replace(/\d+/, itemIndex);
                            label.attr('for', labelFor);
                        }
                    }
                });
                newItem.find('.card-title').html('Document ' + (itemIndex + 1));
                newItem.find('.dropdown-toggle').attr('id','dropdownMenuButton_'+itemIndex);
                newItem.find('.dropdown-menu').attr('aria-labelledby','dropdownMenuButton_'+itemIndex);
                newItem.find('.invalid-feedback').attr('id','requiredMsg_'+itemIndex);
                itemIndex++;
            });
        }

        // Additional script for client_id change event
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

        // Initial script for amount calculation
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
        const amount = unit * rate;
        document.querySelector(`input[name="amount[${index}]"]`).value = amount;
    }

    function calculateAmount_2(input) {
        const name = input.name;
        const match = name.match(/\[(\d+)\]/);
        const index = match ? match[1] : 0;

        const unit = parseFloat(document.querySelector(`input[name="unit[${index}]"]`).value) || 0;
        const rate = parseFloat(document.querySelector(`input[name="back_translation[${index}]"]`).value) || 0;
        const amount = unit * rate;
        document.querySelector(`input[name="amount_bt[${index}]"]`).value = amount;
    }

    function changeLan(input) {
        console.log(input);
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
            const v1Amount = unit * rate;
            document.querySelector(`input[name="verification[${index}]"]`).value = v1Amount;
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
            const amount = unit * rate;
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
            const amount = unit * rate;
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
            const amount = unit * rate;
            document.querySelector(`input[name="verification_2[${index}]"]`).value = amount;
        }else{
            document.querySelector(`input[name="verification_2[${index}]"]`).value = 0;
        }
    }

    function loadRatecard(estimateDetails){
        estimateDetails.forEach((element,index) => {
            const eClientId = $('#client_id option:selected').val()?$('#client_id option:selected').val():@json($clients[0]->id);
            const eRorn = $('#rorn option:selected').val()?$('#rorn option:selected').val():'normal';
            const eType = $('#type option:selected').val()?$('#type option:selected').val():'minimum';
            const eLang = $(`input[name="lang_${index}[]"]:checked`).first().val()?$(`input[name="lang_${index}[]"]:checked`).first().val():@json($languages[0]->id);
            $.ajax({
                url: "/estimate-management/ratecard/" + eClientId +  "/"  + eRorn +  "/" + eType +  "/" + eLang,
                method: 'GET',
                success: function(data) {
                    rates[index] = data;
                }
            });
        });
        console.log(rates);
    }

    // Validate form on submit
    function checkValidLan(e){
        let i=0;
        $('.repeater-item').each(function() {
            console.log($('#dropdownMenuButton_'+i).text());
            // console.log(i,$('input[name="lang_'+i+'[]"]:checked').val());
            // if ($('input[name="lang_'+i+'[]"]:checked').val() === '' || $('input[name="lang_'+i+'[]"]:checked').val() === undefined ) {
            if ($('#dropdownMenuButton_'+i).text() === 'Select Language') {
                $('#requiredMsg_'+i).show();
                e.preventDefault();
            } else {
                $('#requiredMsg_'+i).hide();
            }
            i++;
        });
    }

    function addLangScripts(){
        let scriptIndex = 0;
        $('.repeater-item').each(function() {
            var script = document.createElement('script');
            script.textContent = "$('#dropdownMenuButton_"+scriptIndex+" + div').on('click', function(e) { e.stopPropagation();});";
            document.body.appendChild(script);
            scriptIndex++;
        });
    }
</script>
