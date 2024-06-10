<?php

namespace Modules\WriterManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;
use Modules\WriterManagement\App\Models\WriterPayment;

class WriterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $writers=Writer::all();
        return view('writermanagement::index')->with('writers',$writers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('writermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers',
            'phone_no' => 'required|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=new Writer();
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone_no;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->created_by=auth()->user()->id;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('message','Writer Added Successfully');

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $writer=Writer::find($id);
        return view('writermanagement::show')->with('writer',$writer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $writer=Writer::find($id);
        $language_map=WriterLanguageMap::where('writer_id',$id)->get();
        $payments= WriterPayment::where('writer_id',$id)->get();
        return view('writermanagement::edit',compact('writer','language_map','payments'))->with('id',$id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers,email,'.$id,
            'phone_no' => 'required|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=Writer::find($id);
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone_no;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('message','Writer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function viewLanguageMaps($writer_id){
        $language_map=WriterLanguageMap::where('writer_id',$writer_id)->get();
        return view('writermanagement::language-maps')->with('language_map',$language_map)->with('id',$writer_id);
    }

    public  function deleteLanguageMap($writer_id,$id){
        $language_map=WriterLanguageMap::find($id);
        $language_map->delete();
        return redirect()->back();
    }

    public function editLanguageMap($writer_id,$id){
        $languages=Language::all();
        $language_map=WriterLanguageMap::find($id);
        
        return view('writermanagement::edit-language')->with('language_map',$language_map)->with('id',$writer_id)->with('languages',$languages);
    }

    public function updateLanguageMap($writer_id,$id,Request $request){
       
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',
        ]);
        $language_map=WriterLanguageMap::find($id);
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Session::flash('message', 'Language Map Updated Successfully');
        return redirect()->back();
    }

    public function addLanguageMapView($writer_id){
        $languages=Language::all();
        return view('writermanagement::add-language')->with('id',$writer_id)->with('languages',$languages);
    }

    public function addLanguageMap($writer_id,Request $request){
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',

        ]);
        $language_map=new WriterLanguageMap();
        $language_map->writer_id=$writer_id;
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Session::flash('message', 'Language Map Added Successfully');
        return redirect(route('writermanagement.viewLanguageMaps',['writer_id'=>$writer_id]));
        
    }

    public function disableEnableWriter($id){
        $writer=Writer::find($id);
        if($writer->status==1){
            $writer->status=0;
        }else{
            $writer->status=1;
        }
        $writer->save();
        return redirect()->route('writermanagement.index');
    }


    public function viewPayments($writer_id){
       $writer_payments= WriterPayment::where('writer_id',$writer_id)->get();
       return view('writermanagement::view-payments')->with('id',$writer_id)->with('payments',$writer_payments);
    }

    public function addPaymentView($writer_id){
        return view('writermanagement::add-payment')->with('id',$writer_id);
    }

    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'writer_id' => 'required|string',
            'payment_method' => 'required|string',
            'metrix' => 'required|string',
            'apply_gst' => 'required|boolean',
            'apply_tds' => 'required|boolean',
            'period_from' => 'required|date',
            'period_to' => 'required|date',
            'online_ref_no' => 'nullable|string',
            'cheque_no' => 'nullable|string',
            'performance_charge' => 'required|numeric',
            'deductible' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payment = new WriterPayment($request->all());
        $payment->save();

        return redirect(route('writermanagement.viewPayments',$payment->writer_id))->with('message', 'Payment added successfully.');
    }

    public function editPaymentView($writer_id,$id){
        $payment = WriterPayment::find($id);
        return view('writermanagement::edit-payment')->with('payment',$payment)->with('id',$writer_id);
    }

    public function editPayment(Request $request, $writer_id,$id)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string',
            'metrix' => 'required|string',
            'apply_gst' => 'required|boolean',
            'apply_tds' => 'required|boolean',
            'period_from' => 'required|date',
            'period_to' => 'required|date',
            'online_ref_no' => 'nullable|string',
            'cheque_no' => 'nullable|string',
            'performance_charge' => 'required|numeric',
            'deductible' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $payment = WriterPayment::where('id',$id)->first();
        $payment->update($request->all());
        
        return redirect()->back();
    }

    public function showPayment($writer_id,$id)
    {
        $payment = WriterPayment::findOrFail($id);
        return view('writermanagement::show-payments', compact('payment'));
    }

}
