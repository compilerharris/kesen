<?php

use Modules\ClientManagement\App\Models\Client;
use Modules\EstimateManagement\App\Models\Estimates;
use NumberToWords\NumberToWords;

if (!function_exists('checkRequestUrl')) {
    function checkRequestUrl($patterns,$currentUrl)
    {
        foreach ($patterns as $pattern) {
            // If the pattern contains 'regex:', treat it as a regular expression
            if (strpos($pattern, 'regex:') === 0) {
                $regex = substr($pattern, 6); // Extract the regex pattern
                if (preg_match($regex, $currentUrl)) {
                   return true;
                }
            } else {
                // Otherwise, treat it as a simple string match
                if (fnmatch($pattern, $currentUrl)) {
                    echo "Current URL matches the pattern: $pattern";
                    return true;
                }
            }
        }
        return false;
    }
}

if(!function_exists('getCurrentDate')){
    function getCurrentDate(){
        return date('Y-m-d');
    }
}

if(!function_exists('calculateTotals')){
    function calculateTotals($details, $discount=0) {
        $sub_total = 0;
        $uniqueDetails = collect();
        foreach ($details as $detail) {
            $combination = $detail->document_name . '-' . $detail->unit;
            if (!$uniqueDetails->contains($combination)){
                    $uniqueDetails->push($combination);
            $unit = $detail->unit;
            $rate = $detail->rate;
            $layout_charges = $detail->layout_charges ?? 0;
            $back_translation = $detail->back_translation ?? 0;
            $verification = $detail->verification ?? 0;
            $two_way_qc_t = $detail->two_way_qc_t ?? 0;
            $two_way_qc_bt = $detail->two_way_qc_bt ?? 0;
            $verification_2 = $detail->verification_2 ?? 0;
            $layout_charges_2 = $detail->layout_charges_2 ?? 0;
    
            $sub_total += (($unit * $rate) + $layout_charges + $back_translation + $verification + $two_way_qc_t + $two_way_qc_bt + $verification_2 + $layout_charges_2)*((Modules\EstimateManagement\App\Models\EstimatesDetails::where('document_name', $detail->document_name)->where('unit', $detail->unit)->count()));
            }
        }
    
        $net_total = $sub_total - $discount;
        $gst = ($net_total / 100) * 18;
        $total = $net_total + $gst;
    
       return $total;
    }
    
}

if(!function_exists('getCurrencyDropDown')){
    function getCurrencyDropDown(){
        return <<<HTML
        <option value="AFN" label="Afghan afghani">AFN</option>
        <option value="ALL" label="Albanian lek">ALL</option>
        <option value="DZD" label="Algerian dinar">DZD</option>
        <option value="AOA" label="Angolan kwanza">AOA</option>
        <option value="ARS" label="Argentine peso">ARS</option>
        <option value="AMD" label="Armenian dram">AMD</option>
        <option value="AWG" label="Aruban florin">AWG</option>
        <option value="AUD" label="Australian dollar">AUD</option>
        <option value="AZN" label="Azerbaijani manat">AZN</option>
        <option value="BHD" label="Bahraini dinar">BHD</option>
        <option value="BSD" label="Bahamian dollar">BSD</option>
        <option value="BDT" label="Bangladeshi taka">BDT</option>
        <option value="BBD" label="Barbadian dollar">BBD</option>
        <option value="BYN" label="Belarusian ruble">BYN</option>
        <option value="BZD" label="Belize dollar">BZD</option>
        <option value="BMD" label="Bermudian dollar">BMD</option>
        <option value="BTN" label="Bhutanese ngultrum">BTN</option>
        <option value="BOB" label="Bolivian boliviano">BOB</option>
        <option value="BAM" label="Bosnia and Herzegovina convertible mark">BAM</option>
        <option value="BWP" label="Botswana pula">BWP</option>
        <option value="BRL" label="Brazilian real">BRL</option>
        <option value="GBP" label="British pound">GBP</option>
        <option value="BND" label="Brunei dollar">BND</option>
        <option value="MMK" label="Burmese kyat">MMK</option>
        <option value="BIF" label="Burundian franc">BIF</option>
        <option value="KHR" label="Cambodian riel">KHR</option>
        <option value="CAD" label="Canadian dollar">CAD</option>
        <option value="CVE" label="Cape Verdean escudo">CVE</option>
        <option value="KYD" label="Cayman Islands dollar">KYD</option>
        <option value="XAF" label="Central African CFA franc">XAF</option>
        <option value="XPF" label="CFP franc">XPF</option>
        <option value="CLP" label="Chilean peso">CLP</option>
        <option value="CNY" label="Chinese yuan">CNY</option>
        <option value="COP" label="Colombian peso">COP</option>
        <option value="KMF" label="Comorian franc">KMF</option>
        <option value="CDF" label="Congolese franc">CDF</option>
        <option value="CRC" label="Costa Rican colón">CRC</option>
        <option value="HRK" label="Croatian kuna">HRK</option>
        <option value="CUC" label="Cuban convertible peso">CUC</option>
        <option value="CUP" label="Cuban peso">CUP</option>
        <option value="CZK" label="Czech koruna">CZK</option>
        <option value="DKK" label="Danish krone">DKK</option>
        <option value="DOP" label="Dominican peso">DOP</option>
        <option value="DJF" label="Djiboutian franc">DJF</option>
        <option value="XCD" label="Eastern Caribbean dollar">XCD</option>
        <option value="EGP" label="Egyptian pound">EGP</option>
        <option value="ERN" label="Eritrean nakfa">ERN</option>
        <option value="ETB" label="Ethiopian birr">ETB</option>
        <option value="EUR" label="Euro">EUR</option>
        <option value="FKP" label="Falkland Islands pound">FKP</option>
        <option value="FJD" label="Fijian dollar">FJD</option>
        <option value="GMD" label="Gambian dalasi">GMD</option>
        <option value="GEL" label="Georgian lari">GEL</option>
        <option value="GHS" label="Ghanaian cedi">GHS</option>
        <option value="GIP" label="Gibraltar pound">GIP</option>
        <option value="GTQ" label="Guatemalan quetzal">GTQ</option>
        <option value="GGP" label="Guernsey pound">GGP</option>
        <option value="GNF" label="Guinean franc">GNF</option>
        <option value="GYD" label="Guyanese dollar">GYD</option>
        <option value="HTG" label="Haitian gourde">HTG</option>
        <option value="HNL" label="Honduran lempira">HNL</option>
        <option value="HKD" label="Hong Kong dollar">HKD</option>
        <option value="HUF" label="Hungarian forint">HUF</option>
        <option value="ISK" label="Icelandic króna">ISK</option>
        <option value="INR" label="Indian rupee" selected>INR</option>
        <option value="IDR" label="Indonesian rupiah">IDR</option>
        <option value="IRR" label="Iranian rial">IRR</option>
        <option value="IQD" label="Iraqi dinar">IQD</option>
        <option value="ILS" label="Israeli new shekel">ILS</option>
        <option value="JMD" label="Jamaican dollar">JMD</option>
        <option value="JPY" label="Japanese yen">JPY</option>
        <option value="JEP" label="Jersey pound">JEP</option>
        <option value="JOD" label="Jordanian dinar">JOD</option>
        <option value="KZT" label="Kazakhstani tenge">KZT</option>
        <option value="KES" label="Kenyan shilling">KES</option>
        <option value="KID" label="Kiribati dollar">KID</option>
        <option value="KGS" label="Kyrgyzstani som">KGS</option>
        <option value="KWD" label="Kuwaiti dinar">KWD</option>
        <option value="LAK" label="Lao kip">LAK</option>
        <option value="LBP" label="Lebanese pound">LBP</option>
        <option value="LSL" label="Lesotho loti">LSL</option>
        <option value="LRD" label="Liberian dollar">LRD</option>
        <option value="LYD" label="Libyan dinar">LYD</option>
        <option value="MOP" label="Macanese pataca">MOP</option>
        <option value="MKD" label="Macedonian denar">MKD</option>
        <option value="MGA" label="Malagasy ariary">MGA</option>
        <option value="MWK" label="Malawian kwacha">MWK</option>
        <option value="MYR" label="Malaysian ringgit">MYR</option>
        <option value="MVR" label="Maldivian rufiyaa">MVR</option>
        <option value="IMP" label="Manx pound">IMP</option>
        <option value="MRU" label="Mauritanian ouguiya">MRU</option>
        <option value="MUR" label="Mauritian rupee">MUR</option>
        <option value="MXN" label="Mexican peso">MXN</option>
        <option value="MDL" label="Moldovan leu">MDL</option>
        <option value="MNT" label="Mongolian tögrög">MNT</option>
        <option value="MAD" label="Moroccan dirham">MAD</option>
        <option value="MZN" label="Mozambican metical">MZN</option>
        <option value="NAD" label="Namibian dollar">NAD</option>
        <option value="NPR" label="Nepalese rupee">NPR</option>
        <option value="ANG" label="Netherlands Antillean guilder">ANG</option>
        <option value="TWD" label="New Taiwan dollar">TWD</option>
        <option value="NZD" label="New Zealand dollar">NZD</option>
        <option value="NIO" label="Nicaraguan córdoba">NIO</option>
        <option value="NGN" label="Nigerian naira">NGN</option>
        <option value="KPW" label="North Korean won">KPW</option>
        <option value="NOK" label="Norwegian krone">NOK</option>
        <option value="OMR" label="Omani rial">OMR</option>
        <option value="PKR" label="Pakistani rupee">PKR</option>
        <option value="PAB" label="Panamanian balboa">PAB</option>
        <option value="PGK" label="Papua New Guinean kina">PGK</option>
        <option value="PYG" label="Paraguayan guaraní">PYG</option>
        <option value="PEN" label="Peruvian sol">PEN</option>
        <option value="PHP" label="Philippine peso">PHP</option>
        <option value="PLN" label="Polish złoty">PLN</option>
        <option value="QAR" label="Qatari riyal">QAR</option>
        <option value="RON" label="Romanian leu">RON</option>
        <option value="RUB" label="Russian ruble">RUB</option>
        <option value="RWF" label="Rwandan franc">RWF</option>
        <option value="SHP" label="Saint Helena pound">SHP</option>
        <option value="WST" label="Samoan tālā">WST</option>
        <option value="STN" label="São Tomé and Príncipe dobra">STN</option>
        <option value="SAR" label="Saudi riyal">SAR</option>
        <option value="RSD" label="Serbian dinar">RSD</option>
        <option value="SLL" label="Sierra Leonean leone">SLL</option>
        <option value="SGD" label="Singapore dollar">SGD</option>
        <option value="SOS" label="Somali shilling">SOS</option>
        <option value="SLS" label="Somaliland shilling">SLS</option>
        <option value="ZAR" label="South African rand">ZAR</option>
        <option value="KRW" label="South Korean won">KRW</option>
        <option value="SSP" label="South Sudanese pound">SSP</option>
        <option value="SRD" label="Surinamese dollar">SRD</option>
        <option value="SEK" label="Swedish krona">SEK</option>
        <option value="CHF" label="Swiss franc">CHF</option>
        <option value="LKR" label="Sri Lankan rupee">LKR</option>
        <option value="SZL" label="Swazi lilangeni">SZL</option>
        <option value="SYP" label="Syrian pound">SYP</option>
        <option value="TJS" label="Tajikistani somoni">TJS</option>
        <option value="TZS" label="Tanzanian shilling">TZS</option>
        <option value="THB" label="Thai baht">THB</option>
        <option value="TOP" label="Tongan paʻanga">TOP</option>
        <option value="PRB" label="Transnistrian ruble">PRB</option>
        <option value="TTD" label="Trinidad and Tobago dollar">TTD</option>
        <option value="TND" label="Tunisian dinar">TND</option>
        <option value="TRY" label="Turkish lira">TRY</option>
        <option value="TMT" label="Turkmenistan manat">TMT</option>
        <option value="TVD" label="Tuvaluan dollar">TVD</option>
        <option value="UGX" label="Ugandan shilling">UGX</option>
        <option value="UAH" label="Ukrainian hryvnia">UAH</option>
        <option value="AED" label="United Arab Emirates dirham">AED</option>
        <option value="USD" label="United States dollar">USD</option>
        <option value="UYU" label="Uruguayan peso">UYU</option>
        <option value="UZS" label="Uzbekistani soʻm">UZS</option>
        <option value="VUV" label="Vanuatu vatu">VUV</option>
        <option value="VES" label="Venezuelan bolívar soberano">VES</option>
        <option value="VND" label="Vietnamese đồng">VND</option>
        <option value="XOF" label="West African CFA franc">XOF</option>
        <option value="ZMW" label="Zambian kwacha">ZMW</option>
        <option value="ZWB" label="Zimbabwean bonds">ZWB</option>
      HTML;
    }
}

if(!function_exists('generateEstimateNumber')){
    function generateEstimateNumber($client_id) {
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        if ($currentMonth >= 4) {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }
        
        $nextYearShort = substr($endYear, 2);
        $financialYear = $startYear . '-' . $nextYearShort;
        
        $count = Estimates::count() + 1;
        $estimate_metric = Client::where('id', $client_id)->with('client_metric')->first();
        $estimate_metric_code = $estimate_metric->client_metric->code;
        
        $formattedID = str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . $estimate_metric_code . '/' . $financialYear;
        
        return $formattedID;
    }
    
}
    
    if (!function_exists('number_to_words')) {
        function number_to_words($number)
        {
            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getNumberTransformer('en');
    
            $words = $numberTransformer->toWords(round($number));
            $words = ucwords(str_replace('-', ' ', $words));
    
            return $words . " Only";
        }
    }
