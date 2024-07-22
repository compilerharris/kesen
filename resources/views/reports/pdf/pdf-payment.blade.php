<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Advice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
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
            <h1>Linguistic Systems</h1>
            <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA, ANDHERI EAST, MUMBAI - 400 093</p>
            <p>022 4034 8888 / 022 4034 8801 / 022 4034 8845</p>
            <p>PAN NO: AADFL1698N GST NO: 27AADFL1698N1ZP</p>
        </div>
        <h2>PAYMENT ADVICE</h2>
        <table class="info-table">
            <tr>
                <td >{{Modules\WriterManagement\App\Models\Writer::where('id',$writer_payment->writer_id)->first()->writer_name}}</td>
                <td style="width: 212px;">Payment Date : <b>{{Carbon\Carbon::parse($writer_payment->created_at)->format('j M Y')}}</b></td>
            </tr>
            <tr>
                <td >An Electronic payment has been done into your account being translation charges for the jobs listed below :</td>
                <td >Payment Method : <b>{{$writer_payment->payment_method??''}}</b></td>
            </tr>
            <tr>
                <td ></td>
                <td >NEFT Reference : <b>{{$writer_payment->online_ref_no??''}}</b></td>
            </tr>
            <tr>
                <td ></td>
                <td >Amount : <b>INR {{$writer_payment->total_amount??''}}</b></td>
            </tr>
        </table>
        <table class="payment-table">
            <tr>
                <th>Month</th>
                <th>Job No.</th>
                <th>Description</th>
                <th>Units</th>
                <th>Language</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
            @php $total = 0; @endphp
            @foreach ($job_card as $job)
                @if($job->t_unit != '')
                    <tr>
                        <td>{{Carbon\Carbon::parse($job->created_at)->format('M Y')}}</td>
                        <td>{{$job->job_no}}</td>
                        <td>T</td>
                        <td>{{$job->t_unit}}</td>
                        <td>{{ $job->estimateDetail->language->name }}</td>
                        <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges}}</td>
                        <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges*$job->t_unit}}</td>
                        @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges*$job->t_unit @endphp
                    </tr>
                    @endif
                @if($job->v_unit != '')
                <tr>
                    <td>{{Carbon\Carbon::parse($job->created_at)->format('M Y')}}</td>
                    <td>{{$job->job_no}}</td>
                    <td>V</td>
                    <td>{{$job->v_unit}}</td>
                    <td>{{ $job->estimateDetail->language->name }}</td>
                    <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges}}</td>
                    <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->v_unit}}</td>
                    @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->v_unit @endphp
                </tr>
                @endif
                @if($job->bt_unit != '')
                <tr>
                    <td>{{Carbon\Carbon::parse($job->created_at)->format('M Y')}}</td>
                    <td>{{$job->job_no}}</td>
                    <td>BT</td>
                    <td>{{$job->bt_unit}}</td>
                    <td>{{ $job->estimateDetail->language->name }}</td>
                    <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges}}</td>
                    <td>{{Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->bt_unit}}</td>
                    @php $total+=Modules\WriterManagement\App\Models\WriterLanguageMap::where('writer_id',$writer_payment->writer_id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_charges*$job->bt_unit @endphp
                </tr>
                @endif
            @endforeach

            @php 
                $subtotal=$total;
            @endphp
            
            
            <tr class="total-row">
                <td colspan="6">Total</td>
                <td>{{$total}}</td>
            </tr>
            @if($writer_payment->apply_gst == 1)
                <tr class="total-row">
                    <td colspan="6">GST 18%</td>
                    <td>{{round($subtotal*0.18)}}</td>
                </tr>
                @php $total+=$subtotal*0.18 @endphp
            @endif
            @if($writer_payment->apply_tds == 1)
                <tr class="total-row">
                    <td colspan="6">TDS 10%</td>
                    <td>{{round($subtotal*0.1)}}</td>
                </tr>
                @php
                $total-=$subtotal*0.1
            @endphp
                @if($writer_payment->performance_charge)
                <tr class="total-row">
                    <td colspan="6">Performance</td>
                    <td>{{($writer_payment->performance_charge)}}</td>
                </tr>
                @php
                    $total+=$writer_payment->performance_charge
                @endphp
                @endif
                @if($writer_payment->deductible)
                <tr class="total-row">
                    <td colspan="6">Deductible</td>
                    <td>{{($writer_payment->deductible)}}</td>
                </tr>
                    @php
                        $total-=$writer_payment->deductible
                    @endphp
                @endif
            
                <tr class="total-row">
                    <td colspan="6">Total</td>
                    <td>{{round($total)}}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Grand Total</td>
                    <td>{{round($total)}}</td>
                </tr>
            @else
            @if($writer_payment->performance_charge)
                <tr class="total-row">
                    <td colspan="6">Performance</td>
                    <td>{{($writer_payment->performance_charge)}}</td>
                
                </tr>
                @php
                    $total+=$writer_payment->performance_charge
                @endphp
            
            @endif
            @if($writer_payment->deductible)
                <tr class="total-row">
                    <td colspan="6">Deductible</td>
                    <td>{{($writer_payment->deductible)}}</td>
                </tr>
                @php
                    $total-=$writer_payment->deductible
                @endphp
            @endif
            
                <tr class="total-row">
                    <td colspan="6">Total</td>
                    <td>{{round($total)}}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Grand Total</td>
                    <td>{{round($total)}}</td>
                </tr>
            @endif

            
        </table>
        <p class="amount-words">Rupees : {{number_to_words($total-($total*0.1))}}</p>
    </div>
</body>
</html>
