<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;
use Modules\WriterManagement\App\Models\WriterPayment;
use App\Mail\WriterPayment as WP;
use Illuminate\Support\Facades\Mail;
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
        if(Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts')){
            return redirect('job-card-management');
        }else if(Auth::user()->hasRole('Admin')){
            return redirect('job-register-management');
        }
        return redirect('estimate-management');
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

        $jobRegisterIds = JobRegister::whereBetween('created_at',[
            Carbon::parse($writer_payment->period_from)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($writer_payment->period_to)->endOfDay()->format('Y-m-d H:i:s')
        ])->pluck('sr_no')->toArray();

        $job_card = JobCard::whereIn('job_no',$jobRegisterIds)
        ->where(function ($query) use ($request) {
            $query->where('t_writer_code', $request->writer)
                  ->orWhere('bt_writer_code', $request->writer);
        })
        ->get();

        // return view('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
        return $pdf->stream();
        
    }
    public function generatePaymentReportPreview($writerId, $paymentId, $purpose){
        $writer_payment=WriterPayment::where('id',$paymentId)->first();
        if($writer_payment==null){
            return redirect()->back()->with('alert', 'No writer payments found');
        }

        $jobRegisterIds = JobRegister::whereBetween('created_at',[
            Carbon::parse($writer_payment->period_from)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($writer_payment->period_to)->endOfDay()->format('Y-m-d H:i:s')
        ])->pluck('sr_no')->toArray();
        
        $job_card = JobCard::whereIn('job_no',$jobRegisterIds)
        ->where(function ($query) use ($writerId) {
            $query->where('t_writer_code', $writerId)
                  ->orWhere('v_employee_code', $writerId)
                  ->orWhere('bt_writer_code', $writerId)
                  ->orWhere('btv_employee_code', $writerId);
        })
        ->get();
        if($purpose == 'preview'){
            // return view('reports.pdf.pdf-payment',compact('job_card','max','min','writer_payment'));
            $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','writer_payment'));
            return $pdf->stream();
        }
        try{
            $wEmail = Writer::where('id',$writerId)->first();
            if(!$wEmail){
                return redirect()->back()->with('alert', 'Please enter writer email id from writer management to send email.');
            }
            Mail::to($wEmail)->send(new WP($job_card,$writer_payment,$wEmail));
        }catch (\Exception $e) {
            return back()->with('alert', 'Failed to send writer payment email: ' . $e->getMessage());
        }
        
    }
    public function generateWriterReport() {
        // Parse and format date ranges
        $min = Carbon::parse(request()->get('from_date'))->startOfDay()->format('Y-m-d H:i:s');
        $max = Carbon::parse(request()->get('to_date'))->endOfDay()->format('Y-m-d H:i:s');
    
        // Fetch job register IDs based on date range
        $jobRegisterIds = JobRegister::whereBetween('created_at', [$min, $max])->pluck('sr_no')->toArray();

        
        // Fetch job cards based on job register IDs
        $job_cards = JobCard::whereIn('job_no', $jobRegisterIds)->with('estimateDetail.language')->orderBy('job_no')->get();
    
        // Collect unique writer IDs from job cards
        $writerIds = $job_cards->flatMap(function ($job) {
            return [
                $job->t_writer_code,
                $job->v_employee_code,
                $job->bt_writer_code,
                $job->btv_employee_code
            ];
        })->unique()->filter()->values();
    
        // Fetch writers with their language maps in one go
        $writers = Writer::with(['writer_language_map' => function ($query) {
            $query->with('language'); // Eager load language for filtering in-memory
        }])->whereIn('id', $writerIds)->where('code', '!=', 'INT')->get()->keyBy('id');
    
        // Prepare total by writers
        $totalByWriters = [];
    
        foreach ($job_cards as $job) {
            // Check and calculate for each type of unit
            $this->calculateWriterTotal($job, 't', $totalByWriters, $writers);
            $this->calculateWriterTotal($job, 'v', $totalByWriters, $writers, 'checking_charges');
            $this->calculateWriterTotal($job, 'bt', $totalByWriters, $writers, 'bt_charges');
            $this->calculateWriterTotal($job, 'btv', $totalByWriters, $writers, 'bt_checking_charges');
        }
    
        // Filter out writers with total of zero
        $totalByWriters = array_filter($totalByWriters, function ($writer) {
            return $writer['total'] != 0;
        });
    
        // Generate PDF and return the response
        $pdf = FacadePdf::loadView('reports.pdf.pdf-writer', compact('totalByWriters', 'min', 'max'));
        return $pdf->stream();
    }
    private function calculateWriterTotal($job, $type, &$totalByWriters, $writers, $chargeType = 'per_unit_charges') {
        $writerCodeField = $type . '_writer_code';
        $unitField = $type . '_unit';
        
        if (!empty($job->$unitField)) {
            $writer = $writers->get($job->$writerCodeField);
    
            if ($writer) {
                // Get the language name from the job's estimate detail
                $languageName = $job->estimateDetail?$job->estimateDetail->language->name:'';
    
                // Filter the language map by language name
                $languageMap = $writer->writer_language_map->first(function ($map) use ($languageName) {
                    return $map->language->name === $languageName;
                });
                
                if ($languageMap) {
                    if (!isset($totalByWriters[$job->$writerCodeField])) {
                        $totalByWriters[$job->$writerCodeField] = [
                            'total' => 0,
                            'name' => $writer->writer_name ?? 'Unknown',
                            'code' => $writer->code ?? 'Unknown',
                        ];
                    }
                    
                    $totalByWriters[$job->$writerCodeField]['total'] += (int)$languageMap->$chargeType * (int)$job->$unitField;
                }
            }
        }
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
