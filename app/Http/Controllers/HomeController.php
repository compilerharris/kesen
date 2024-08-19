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
        // ->whereBetween('created_at', [$min,$max])
        ->where('created_at', '>=', $writer_payment->period_from)
        ->where('created_at', '<=', $writer_payment->period_to)
        ->get();

        if(count($job_card) > 0){
            return redirect()->back()->with('alert', 'No writer payments found');
        }
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
        // ->whereBetween('created_at', [$min,$max])
        ->where('created_at', '>=', $writer_payment->period_from)
        ->where('created_at', '<=', $writer_payment->period_to)
        ->get();

        if(count($job_card) > 0){
            return redirect()->back()->with('alert', 'No job card found in payment.');
        }
        // return view('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','writer_payment'));
        return $pdf->stream();
        
    }
    public function generateWriterReport(){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();

        $writers = Writer::where('status',1)->orderBy('created_at','desc')->get();
        if(count($writers) == 0){
            return redirect()->back()->with('alert', 'No writer found.');
        }
        foreach($writers as $writer){
            $job_card = JobCard::where(function ($query) use ($writer) {
                $query->where('t_writer_code', $writer->id)
                      ->orWhere('bt_writer_code', $writer->id);
            })
            ->where('created_at', '>=', $min)
            ->where('created_at', '<=', $max)
            ->get();
            $total = 0;
            foreach ($job_card as $job) {
                if($job->t_unit != ''){
                    $writerLan = WriterLanguageMap::where('writer_id',$writer->id)->where('language_id',$job->estimateDetail->language->id)->first();
                    if($writerLan){
                        $total+= $writerLan->per_unit_charges*$job->t_unit;
                    }
                }
                if($job->v_unit != ''){
                    $writerLan = WriterLanguageMap::where('writer_id',$writer->id)->where('language_id',$job->estimateDetail->language->id)->first();
                    if($writerLan){
                        $total += $writerLan->checking_charges*$job->v_unit;
                    }
                }
                if($job->bt_unit != ''){
                    $writerLan = WriterLanguageMap::where('writer_id',$writer->id)->where('language_id',$job->estimateDetail->language->id)->first();
                    if($writerLan){
                        $total += $writerLan->bt_charges*$job->bt_unit;
                    }
                }
            }
            $writer->payment_total_amounts = $total;
        }

        $writers = $writers->filter(function ($value) {
            return $value->payment_total_amounts != 0;
        });
            
        $pdf = FacadePdf::loadView('reports.pdf.pdf-writer',compact('writers','min','max'));
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
        $writerWorkload = JobCard::where('t_writer_code',$request->writer)->orWhere('bt_writer_code',$request->writer)->orderBy('created_at', 'desc')->get();
        $writerWorkload = $writerWorkload->sortBy('job_no');
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

    // private function processData($data)
    // {
    //     $result = [];
    //     $partCopyCounters = [];

    //     foreach ($data as $item) {
    //         if (!isset($partCopyCounters[$item->job_no])) {
    //             $partCopyCounters[$item->job_no] = [];
    //         }

    //         if (!isset($partCopyCounters[$item->job_no][$item->writer_code])) {
    //             $partCopyCounters[$item->job_no][$item->writer_code] = 0;
    //         }

    //         $partCopyCounters[$item->job_no][$item->writer_code]++;
    //         $partCopyNumber = $partCopyCounters[$item->job_no][$item->writer_code];

    //         $result[] = [
    //             'job_no' => $item->job_no,
    //             'writer_code' => $item->writer_code,
    //             'part_copy' => 'pc' . $partCopyNumber
    //         ];
    //     }

    //     // Group by job_no and writer_code and concatenate part copies
    //     $groupedResults = [];
    //     foreach ($result as $row) {
    //         $key = $row['job_no'] . '-' . $row['writer_code'];
    //         if (!isset($groupedResults[$key])) {
    //             $groupedResults[$key] = [
    //                 'job_no' => $row['job_no'],
    //                 'writer_code' => $row['writer_code'],
    //                 'part_copies' => []
    //             ];
    //         }
    //         $groupedResults[$key]['part_copies'][] = $row['part_copy'];
    //     }

    //     // Format part copies as a comma-separated string
    //     foreach ($groupedResults as &$group) {
    //         $group['part_copies'] = implode(',', $group['part_copies']);
    //     }

    //     return $groupedResults;
    // }
}
