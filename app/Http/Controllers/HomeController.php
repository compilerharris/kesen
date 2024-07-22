<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\JobCardManagement\App\Models\JobCard;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\JobRegisterManagement\App\Models\JobRegister;
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

    public function generateBillReport()
    {
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();
        $bill_data=JobRegister::where('status','!=', 2)->where('created_at', '>=',Carbon::parse(request()->get("from_date"))->startOfDay())->where('created_at', '<=',Carbon::parse(request()->get("to_date"))->endOfDay())->get();
        $pdf = FacadePdf::loadView('reports.pdf.pdf-bill',compact('bill_data','max','min'));
        return $pdf->stream();
        
    }
    public function generatePaymentReport(Request $request){
        $year = request()->get('year');
        $month = request()->get('month');
        $min = $this->getStartAndEndOfMonth($year, $month)['start_of_month'];
        $max = $this->getStartAndEndOfMonth($year, $month)['end_of_month'];
       
        $writer_payment=WriterPayment::whereBetween('created_at', [$min, $max])->first();
        if($writer_payment==null){
            return redirect('/payment-report')->with('alert', 'No writer payments found');
        }
        $job_card = JobCard::where(function ($query) use ($request) {
            $query->where('t_writer_code', $request->writer)
                  ->orWhere('bt_writer_code', $request->writer);
        })
        ->where('created_at', '>=', $writer_payment->period_from)
        ->where('created_at', '<=', $writer_payment->period_to)
        ->get();
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        return $pdf->stream();
        
    }
    public function generateWriterReport(){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();

    $writer_report = WriterPayment::whereBetween('created_at', [$min, $max])
        ->selectRaw('writer_id, SUM(total_amount) as payment_total_amounts')
        ->groupBy('writer_id')
        ->get();
    $pdf = FacadePdf::loadView('reports.pdf.pdf-writer',compact('writer_report','min','max'));
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
    
}
