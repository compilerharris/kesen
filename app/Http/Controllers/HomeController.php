<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;
use Modules\WriterManagement\App\Models\WriterPayment;
use Illuminate\Support\Facades\View;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('page');
    }

    public function showBillReportForm()
    {
        return view('reports.bills-report');
    }
    public function showPaymentlReportForm(){
        return view('reports.payment-report');
    }
    public function showWriterReportForm(){
        return view('reports.writer-report');
    }

    public function generateBillReport(){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();

        $bill_data = JobRegister::where('status', '!=', 2)
            ->whereBetween('created_at', [$min, $max])
            ->when(is_array(request()->get('clients')) && count(request()->get('clients')) > 0, function($query) {
                $query->whereIn('client_id', request()->get('clients'));
            })
            ->when(request()->get('billingStatus'), function($query) {
                switch (request()->get('billingStatus')) {
                    case 1:
                        $query->where('payment_status', 'Paid');
                        break;
                    case 2:
                        $query->where('payment_status', 'Partial');
                        break;
                    case 3:
                        $query->where('payment_status', 'Unpaid');
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.pdf-bill', compact('bill_data', 'max', 'min'));
        return $pdf->stream();
    }
    public function generatePaymentReport(Request $request){
        $year = request()->get('year');
        $month = request()->get('month');
        $min = $this->getStartAndEndOfMonth($year, $month)['start_of_month'];
        $max = $this->getStartAndEndOfMonth($year, $month)['end_of_month'];
       
        $writer_payment=WriterPayment::where('writer_id',$request->writer)->whereBetween('created_at', [$min, $max])->first();
        if($writer_payment==null){
            return redirect('/payment-report')->with('alert', 'No writer payments found');
        }
        $job_card = JobCard::where(function ($query) use ($request) {
            $query->where('t_writer_code', $request->writer)
                  ->orWhere('bt_writer_code', $request->writer);
        })
        ->whereBetween('created_at', [
            Carbon::parse($writer_payment->period_from)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($writer_payment->period_to)->endOfDay()->format('Y-m-d H:i:s')
        ])
        ->get();

        // return view('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        return $pdf->stream();
        
    }
    public function generatePaymentReportPreview($writerId, $paymentId){
        $writer_payment=WriterPayment::where('id',$paymentId)->first();
        if($writer_payment==null){
            return redirect()->back()->with('alert', 'No writer payments found');
        }
        $job_card = JobCard::where(function ($query) use ($writerId) {
            $query->where('t_writer_code', $writerId)
                  ->orWhere('bt_writer_code', $writerId);
        })
        ->whereBetween('created_at', [
            Carbon::parse($writer_payment->period_from)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($writer_payment->period_to)->endOfDay()->format('Y-m-d H:i:s')
        ])
        ->get();
        // return view('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','writer_payment'));
        return $pdf->stream();
        
    }
    public function generateWriterReport(){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay()->format('Y-m-d H:i:s');
        $max = Carbon::parse(request()->get('to_date'))->endOfDay()->format('Y-m-d H:i:s');

        $job_cards = JobCard::whereBetween('created_at', [$min, $max])
        ->orWhereBetween('updated_at', [$min, $max])
        ->orderBy('job_no')
        ->get();

        $writerIds = $job_cards->flatMap(function ($job) {
            return [
                $job->t_writer_code,
                $job->v_employee_code,
                $job->bt_writer_code,
                $job->btv_employee_code
            ];
        })->unique()->filter()->values();

        $writers = Writer::whereIn('id', $writerIds)->get()->keyBy('id');

        $totalByWriters = [];
        foreach ($job_cards as $job) {
            if($job->t_unit != ''){
                $writerLan = WriterLanguageMap::where('writer_id',$job->t_writer_code)->where('language_id',$job->estimateDetail->language->id)->first();
                if($writerLan){
                    if (!isset($totalByWriters[$job->t_writer_code])) {
                        $totalByWriters[$job->t_writer_code] = [
                            'total' => 0,
                            'name' => $writers->get($job->t_writer_code)->writer_name ?? 'Unknown',
                            'code' => $writers->get($job->t_writer_code)->code ?? 'Unknown',
                        ];
                    }
                    $totalByWriters[$job->t_writer_code]['total'] += (int)$writerLan->per_unit_charges*(int)$job->t_unit;
                }
            }
            if($job->v_unit != ''){
                $writerLan = WriterLanguageMap::where('writer_id',$job->v_employee_code)->where('language_id',$job->estimateDetail->language->id)->first();
                if($writerLan){
                    if (!isset($totalByWriters[$job->v_employee_code])) {
                        $totalByWriters[$job->v_employee_code] = [
                            'total' => 0,
                            'name' => $writers->get($job->v_employee_code)->writer_name ?? 'Unknown',
                            'code' => $writers->get($job->v_employee_code)->code ?? 'Unknown',
                        ];
                    }
                    $totalByWriters[$job->v_employee_code]['total'] += (int)$writerLan->checking_charges*(int)$job->v_unit;
                }
            }
            if($job->bt_unit != ''){
                $writerLan = WriterLanguageMap::where('writer_id',$job->bt_writer_code)->where('language_id',$job->estimateDetail->language->id)->first();
                if($writerLan){
                    if (!isset($totalByWriters[$job->bt_writer_code])) {
                        $totalByWriters[$job->bt_writer_code] = [
                            'total' => 0,
                            'name' => $writers->get($job->bt_writer_code)->writer_name ?? 'Unknown',
                            'code' => $writers->get($job->bt_writer_code)->code ?? 'Unknown',
                        ];
                    }
                    $totalByWriters[$job->bt_writer_code]['total'] += (int)$writerLan->bt_charges*(int)$job->bt_unit;
                }
            }
            if($job->btv_unit != ''){
                $writerLan = WriterLanguageMap::where('writer_id',$job->btv_employee_code)->where('language_id',$job->estimateDetail->language->id)->first();
                if($writerLan){
                    if (!isset($totalByWriters[$job->btv_employee_code])) {
                        $totalByWriters[$job->btv_employee_code] = [
                            'total' => 0,
                            'name' => $writers->get($job->btv_employee_code)->writer_name ?? 'Unknown',
                            'code' => $writers->get($job->btv_employee_code)->code ?? 'Unknown',
                        ];
                    }
                    $totalByWriters[$job->btv_employee_code]['total'] += (int)$writerLan->bt_checking_charges*(int)$job->btv_unit;
                }
            }
        }
            
        $pdf = FacadePdf::loadView('reports.pdf.pdf-writer',compact('totalByWriters','min','max'));
        return $pdf->stream();
        
    }

    function getStartAndEndOfMonth($year, $month) {
        // Parse the month name to get the month number
        $monthNumber = Carbon::parse($month)->month;
    
        // Create a Carbon instance for the first day of the month
        $startOfMonth = Carbon::create($year, $monthNumber)->startOfMonth();
    
        // Get the last day of the month by modifying the start of month
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
    
        return [
            'start_of_month' => $startOfMonth->toDateString(),
            'end_of_month' => $endOfMonth->toDateString(),
        ];
    }

    public function writerWorkloadRedirect(){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        return view('reports.writer-workload-report');
    }

    public function writerWorkload(Request $request){
        $writerWorkload = JobCard::where(function ($query) use ($request) {
            $query->where('t_writer_code', $request->writer)
                  ->whereNotNull('t_pd')
                  ->whereNull('t_cr');
        })->orWhere(function ($query) use ($request) {
            $query->where('bt_writer_code', $request->writer)
                  ->whereNotNull('bt_pd')
                  ->whereNull('bt_cr');
        })->orderBy('job_no')->get();
        if(is_array($request->lang) && count($request->lang)>0){
            $writerWorkload = $writerWorkload->filter(function($job) use ($request){
                $lang = EstimatesDetails::where('id',$job->estimate_detail_id)->whereIn('lang',$request['lang'])->first();
                return $lang?true:false;
            });
        }
        $writerWorkload->writerId = $request->writer;
        // return view('reports.pdf.pdf-writer-workload', compact('writerWorkload'));
        $pdf = FacadePdf::loadView('reports.pdf.pdf-writer-workload',compact('writerWorkload'));
        return $pdf->stream();
    }

    public function getWritersByLangIds($ids)
    {
        $langIds = json_decode($ids);
        $html = '<option value="">Select Writer</option>';
        if ( count($langIds) > 0) {
            $writers = Writer::with('writer_language_map')->where('status', 1)->orderBy('created_at', 'desc')->get();
            $writers = $writers->filter(function($writer) use ($langIds){
                $count = 0;
                foreach($writer->writer_language_map as $lang){
                    $count += in_array($lang->id,$langIds)?1:0;
                }
                return $count>0?true:false;
            });
            foreach ($writers as $writer) {
                $html .= '<option value="' . $writer->id . '">' . $writer->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
    }
}
