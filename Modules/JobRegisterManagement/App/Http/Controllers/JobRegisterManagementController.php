<?php

namespace Modules\JobRegisterManagement\App\Http\Controllers;

use Modules\JobRegisterManagement\App\Sheet\KesenExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ClientManagement\App\Models\Client;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class JobRegisterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $job_registers=JobRegister::all();
        return view('jobregistermanagement::index')->with('job_registers',$job_registers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobregistermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estimate_id' => 'required|string',
            'handled_by_id' => 'required|string',
            'other_details' => 'nullable|array',
            'estimate_document_id' => 'required|string|unique:job_register,estimate_document_id',
            'category' => 'required|integer',
            'type' => 'string',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'protocol_no' => 'string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            #'site_specific' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $job_register=new JobRegister();
        $job_register->client_id = Estimates::where('id',$request->estimate_id)->first()->client_id;
        $job_register->client_contact_person_id =  Estimates::where('id',$request->estimate_id)->first()->client_contact_person_id;
        $job_register->estimate_id = $request->estimate_id;
        $job_register->handled_by_id = $request->handled_by_id;
        $job_register->created_by_id = auth()->user()->id;
        $job_register->other_details = implode(',',$request->other_details);
        $job_register->category = $request->category;
        $job_register->estimate_document_id = $request->estimate_document_id;
        $job_register->type = $request->type;
        $job_register->old_job_no=$request->old_job_no;
        $job_register->client_accountant_person_id = Client::where('id',Estimates::where('id',$request->estimate_id)->first()->client_id)->first()->client_accountant_person_id;
        $job_register->date = $request->date;
        $job_register->description = $request->estimate_document_id;
        $job_register->protocol_no = $request->protocol_no;
        $job_register->status = $request->status;
        $job_register->cancel_reason = $request->cancel_reason;
        $job_register->bill_no = $request->bill_no;
        $job_register->bill_date = $request->bill_date;
        $job_register->informed_to = $request->client_contact_person_id;
        $job_register->invoice_date = $request->invoice_date;
        $job_register->sent_date = $request->sent_date;
        #$job_register->site_specific = $request->site_specific;

        $job_register->save();
        
        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        return view('jobregistermanagement::show', compact('jobRegister'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
       
        return view('jobregistermanagement::edit', compact('jobRegister'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'handled_by_id' => 'required|string',
            'other_details' => 'nullable|array',
            'category' => 'required|integer',
            'type' => 'string',
            'date' => 'required|date',
            'protocol_no' => 'required|string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            #'site_specific' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $jobRegister = JobRegister::where('id', $id)->first();

        $jobRegister->handled_by_id = $request->handled_by_id;
        $jobRegister->other_details = implode(',',$request->other_details);
        $jobRegister->type = $request->type;
        $jobRegister->category = $request->category;
        $jobRegister->date = $request->date;
        $jobRegister->old_job_no=$request->old_job_no;
        $jobRegister->description = $request->estimate_document_id;
        $jobRegister->protocol_no = $request->protocol_no;
        $jobRegister->status = $request->status;
        $jobRegister->cancel_reason = $request->cancel_reason;
        $jobRegister->bill_no = $request->bill_no;
        $jobRegister->bill_date = $request->bill_date;
        $jobRegister->invoice_date = $request->invoice_date;
        $jobRegister->sent_date = $request->sent_date;
           # 'site_specific' => $request->site_specific,
        $jobRegister->save();        

        

        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function viewPdf($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        $pdf = Pdf::loadView('jobregistermanagement::pdf', ['jobRegister' => $jobRegister]);
        return $pdf->stream();
    }

    public function generateExcel($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        return Excel::download(new KesenExport($jobRegister), $jobRegister->description.'.xlsx');
        
    }

}
