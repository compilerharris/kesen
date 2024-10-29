<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Advice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
        }
        .container {
            width: 95%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: green;
            margin: 0;
        }
        .header p {
            margin: 0;
        }
        .info-table, .payment-table {
            width: 100%;
            border-collapse: collapse;
            
        }
        .info-table td, .payment-table th, .payment-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .info-table td:nth-child(2), .payment-table th, .payment-table td {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
        }
        .amount-words {
            font-weight: bold;
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($writer_payment->payment_metric)
                @if ($writer_payment->payment_metric->code == 'KCP')
                    <img src="{{ public_path('img/kesen-communication.jpg') }}" alt="Kesen Communication" width="100%">
                @elseif ($writer_payment->payment_metric->code == 'KLB')
                    <img src="{{ public_path('img/kesen-language-buea.jpg') }}" alt="Kesen Language Bureau" width="100%">
                @elseif ($writer_payment->payment_metric->code == 'LGS')
                    <img src="{{ public_path('img/kesen-linguist-system.jpg') }}" alt="Kesen Linguist System" width="100%">
                @else
                    <img src="{{ public_path('img/kesen-linguist-servi-llp.jpg') }}" alt="Kesen Linguist Servi LLP" width="100%">
                @endif
            @else
                <img src="{{ public_path('img/kesen-linguist-servi-llp.jpg') }}" alt="Kesen Linguist Servi LLP" width="100%">
            @endif
            {{-- <center><img src="{{public_path('img/logo.png')}}" alt="Kesen Logo" width="30%" style="display:block"></center>
            <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA, ANDHERI EAST, MUMBAI - 400 093</p>
            <p>022 4034 8888 / 022 4034 8801 / 022 4034 8845</p>
            <p>PAN NO: AADFL1698N GST NO: 27AADFL1698N1ZP</p> --}}
        </div>
        <h2>PAYMENT ADVICE</h2>
        <table class="info-table">
            <tr>
                <td><b>{{Modules\WriterManagement\App\Models\Writer::where('id',$writer_payment->writer_id)->first()->writer_name}}</b></td>
                <td style="width: 212px;text-align: left;">Payment Date : <b>{{Carbon\Carbon::parse($writer_payment->created_at)->format('j M Y')}}</b></td>
            </tr>
            <tr>
                <td >An Electronic payment has been done into your account being translation charges for the jobs listed below :</td>
                <td style="text-align: left;">Payment Method : <b>{{$writer_payment->payment_method??'---'}}</b></td>
            </tr>
            <tr>
                <td ></td>
                <td style="text-align: left;">NEFT Reference : <b>{{$writer_payment->online_ref_no??'---'}}</b></td>
            </tr>
            <tr>
                <td ></td>
                <td style="text-align: left;">Amount : <b>INR {{round($writer_payment->total_amount)??''}}</b></td>
            </tr>
        </table>
        <table class="payment-table">
            <tr>
                <th style="text-align: center;">Month</th>
                <th style="text-align: center;">Job No.</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Units</th>
                <th style="text-align: center;">Language</th>
                <th style="text-align: center;">Rate</th>
                <th style="text-align: center;">Amount</th>
            </tr>
            @php $total = 0; @endphp
            @foreach ($job_card as $job)
                @if($job->t_unit != '' && $job->t_unit != 0)
                    <tr>
                        <td style="text-align: center;">{{Carbon\Carbon::parse($job->created_at)->format('j M Y')}}</td>
                        <td style="text-align: center;">{{$job->job_no}}</td>
                        <td style="text-align: center;">Translation</td>
                        <td style="text-align: center;">{{$job->t_unit}}</td>
                        <td style="text-align: center;">{{ $job->estimateDetail->language->name }}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges}}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges*$job->t_unit}}</td>
                        @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges*$job->t_unit @endphp
                    </tr>
                    @endif
                @if($job->v_unit != '' && $job->v_unit != 0)
                    <tr>
                        <td style="text-align: center;">{{Carbon\Carbon::parse($job->created_at)->format('j M Y')}}</td>
                        <td style="text-align: center;">{{$job->job_no}}</td>
                        <td style="text-align: center;">Verification</td>
                        <td style="text-align: center;">{{$job->v_unit}}</td>
                        <td style="text-align: center;">{{ $job->estimateDetail->language->name }}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges}}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->v_unit}}</td>
                        @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->v_unit @endphp
                    </tr>
                @endif
                @if($job->bt_unit != '' && $job->bt_unit != 0)
                    <tr>
                        <td style="text-align: center;">{{Carbon\Carbon::parse($job->created_at)->format('j M Y')}}</td>
                        <td style="text-align: center;">{{$job->job_no}}</td>
                        <td style="text-align: center;">Back Translation</td>
                        <td style="text-align: center;">{{$job->bt_unit}}</td>
                        <td style="text-align: center;">{{ $job->estimateDetail->language->name }}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_charges}}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_charges*$job->bt_unit}}</td>
                        @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_charges*$job->bt_unit @endphp
                    </tr>
                @endif
                @if($job->btv_unit != '' && $job->btv_unit != 0)
                    <tr>
                        <td style="text-align: center;">{{Carbon\Carbon::parse($job->created_at)->format('j M Y')}}</td>
                        <td style="text-align: center;">{{$job->job_no}}</td>
                        <td style="text-align: center;">Back Trans Verification</td>
                        <td style="text-align: center;">{{$job->btv_unit}}</td>
                        <td style="text-align: center;">{{ $job->estimateDetail->language->name }}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_checking_charges}}</td>
                        <td style="text-align: center;">{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_checking_charges*$job->btv_unit}}</td>
                        @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_checking_charges*$job->btv_unit @endphp
                    </tr>
                @endif
            @endforeach

            @php 
                $subtotal=$total;
            @endphp
            
            
            <tr class="total-row">
                <td colspan="6">Sub Total</td>
                <td style="text-align: center;">{{$total}}</td>
            </tr>
            @if($writer_payment->apply_gst == 1)
                <tr class="total-row">
                    <td colspan="6">GST 18%</td>
                    <td style="text-align: center;">{{round($subtotal*0.18)}}</td>
                </tr>
                @php $total+=$subtotal*0.18 @endphp
            @endif
            @if($writer_payment->apply_tds == 1)
                <tr class="total-row">
                    <td colspan="6">TDS 10%</td>
                    <td style="text-align: center;">{{round($subtotal*0.1)}}</td>
                </tr>
                @php
                $total-=$subtotal*0.1
            @endphp
                @if($writer_payment->performance_charge)
                <tr class="total-row">
                    <td colspan="6">Performance</td>
                    <td style="text-align: center;">{{($writer_payment->performance_charge)}}</td>
                </tr>
                @php
                    $total+=$writer_payment->performance_charge
                @endphp
                @endif
                @if($writer_payment->deductible)
                <tr class="total-row">
                    <td colspan="6">Deductible</td>
                    <td style="text-align: center;">{{($writer_payment->deductible)}}</td>
                </tr>
                    @php
                        $total-=$writer_payment->deductible
                    @endphp
                @endif
            
                <tr class="total-row">
                    <td colspan="6">Grand Total</td>
                    <td style="text-align: center;">{{round($total)}}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Net Total</td>
                    <td style="text-align: center;">{{round($total)}}</td>
                </tr>
            @else
            @if($writer_payment->performance_charge)
                <tr class="total-row">
                    <td colspan="6">Performance</td>
                    <td style="text-align: center;">{{($writer_payment->performance_charge)}}</td>
                
                </tr>
                @php
                    $total+=$writer_payment->performance_charge
                @endphp
            
            @endif
            @if($writer_payment->deductible)
                <tr class="total-row">
                    <td colspan="6">Deductible</td>
                    <td style="text-align: center;">{{($writer_payment->deductible)}}</td>
                </tr>
                @php
                    $total-=$writer_payment->deductible
                @endphp
            @endif
                <tr class="total-row">
                    <td colspan="6">Grand Total</td>
                    <td style="text-align: center;">{{round($total)}}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Net Total</td>
                    <td style="text-align: center;">{{round($total)}}</td>
                </tr>
            @endif
        </table>
        <p class="amount-words">Rupees : {{number_to_words($total)}}.</p>
        <div>
            <div style="display: block;font-size: 12px;margin-bottom: 10px">
                <p style="display: inline">For </p>
                <p style="font-weight: bold;display: inline">{{ $writer_payment->payment_metric?$writer_payment->payment_metric->name:'' }}</p>
            </div>
            @php
                $emp = \App\Models\User::where('id',$writer_payment->created_by)->first();
            @endphp
            @if($emp)
                @if (file_exists(public_path('img/'.$emp->code.'.png')))
                    <img src="{{ public_path('img/'.$emp->code.'.png') }}" alt="{{Auth::user()->name}}" width="120px" style="margin-left:20px;margin-bottom:-10px;">
                @endif
            @else
                <div style="height: 50px;"></div>
            @endif
            <div style="margin-bottom: 5px;">
                _________________________
            </div>
            <div >
                <span style="display: inline;padding-left: 35px;font-size: 12px"><strong>Authorized Signatory</strong></span>
                {{-- <span style="float: right;font-weight: bold;font-size: 12px;display: inline">Help us to Serve you Better</span> --}}
            </div>
        </div>
    </div>
</body>
</html>
