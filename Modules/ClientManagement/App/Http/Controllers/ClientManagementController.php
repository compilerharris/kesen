<?php

namespace Modules\ClientManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\ClientManagement\App\Models\Ratecard;

class ClientManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client=Client::orderBy('created_at','desc')->get();
        return view('clientmanagement::index')->with('client',$client->values());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        return view('clientmanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:clients,email',
            'phone_no'=>'nullable|numeric|unique:clients,phone_no',
            'landline'=>'nullable|numeric|unique:clients,landline',
            'type'=>'required|in:1,2',
            'client_accountant_person_id'=>'required',
            'metrix'=>'required',
            'protocol_data'=>'required_if:type,2',
            'address'=>'nullable',
        ]);
        $client=new Client();
        $client->name=$request->name;
        $client->email=$request->email;
        $client->phone_no=$request->phone_no;
        $client->landline=$request->landline;
        $client->type=$request->type;
        $client->client_accountant_person_id=$request->client_accountant_person_id;
        $client->metrix=$request->metrix;
        $client->protocol_data=$request->protocol_data;
        $client->address=$request->address;
        $client->save();
        return redirect('/client-management')->with('message', 'Client created successfully.');;
    }
   
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $client=Client::find($id);
        return view('clientmanagement::show')->with('client',$client);
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $client=Client::find($id);
        $contact_persons=ContactPerson::where('client_id',$id)->orderBy('created_at','desc')->get();
        $ratecards=Ratecard::where('client_id',$id)->orderBy('created_at','desc')->get();
        return view('clientmanagement::edit',compact('client','contact_persons','ratecards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:clients,email,' . $id . ',id',
            'phone_no'=>'nullable|numeric|unique:clients,phone_no,' . $id . ',id',
            'landline'=>'nullable|numeric|unique:clients,landline,' . $id . ',id',
            'type'=>'required|in:1,2',
            'client_accountant_person_id'=>'required',
            'metrix'=>'required',
            'protocol_data'=>'required_if:type,2',
            'address'=>'nullable',
        ]);
        $client=Client::find($id);
        $client->name=$request->name;
        $client->email=$request->email;
        $client->phone_no=$request->phone_no;
        $client->landline=$request->landline;
        $client->metrix=$request->metrix;
        $client->client_accountant_person_id=$request->client_accountant_person_id;
        $client->type=$request->type;
        $client->protocol_data=$request->protocol_data;
        $client->address=$request->address;
        $client->save();
        return redirect('/client-management')->with('message', 'Client updated successfully.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function disableEnableClient($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $client=Client::find($id);
        if($client->status==1){
            $client->status=0;
        }else{
            $client->status=1;
        }
        $client->save();
        return redirect('/client-management');
    }

    public function viewContacts($id){
        $contact_persons=ContactPerson::where('client_id',$id)->orderBy('created_at','desc')->get();
        return view('clientmanagement::list_contacts')->with('id',$id)->with('contact_persons',$contact_persons);
    }

    public function addContactForm($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        return view('clientmanagement::add_contact')->with('id',$id);
    }

    public function storeContact(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:contact_persons,email',
            'phone_no'=>'required|numeric|unique:contact_persons,phone_no',
            'landline'=>'nullable|numeric|unique:contact_persons,landline',
            'designation'=>'nullable',
        ]);
        $contact_persons=new ContactPerson();
        $contact_persons->name=$request->name;
        $contact_persons->client_id=$id;
        $contact_persons->email=$request->email;
        $contact_persons->phone_no=$request->phone_no;
        $contact_persons->landline=$request->landline;
        $contact_persons->designation=$request->designation;
        $contact_persons->save();
        return redirect(route('clientmanagement.viewContacts', $id))->with('message', 'Contact added successfully.');;
    }
    
    public function editContactForm($id,$contact_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $contact_person=ContactPerson::find($contact_id);
        return view('clientmanagement::edit_contact')->with('id',$id)->with('contact_person',$contact_person);
    }

    public function editContact(Request $request,$id,$contact_id){
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:contact_persons,email,' . $contact_id . ',id',
            'phone_no'=>'required|numeric|unique:contact_persons,phone_no,' . $contact_id . ',id',
            'landline'=>'nullable|numeric|unique:contact_persons,landline,' . $contact_id . ',id',
            'designation'=>'nullable',
        ]);
        $contact_person=ContactPerson::find($contact_id);
        $contact_person->name=$request->name;
        $contact_person->email=$request->email;
        $contact_person->phone_no=$request->phone_no;
        $contact_person->landline=$request->landline;
        $contact_person->designation=$request->designation;
        $contact_person->save();

        return redirect(route('clientmanagement.viewContacts', $id))->with('message', 'Contact updated successfully.');;
    }

    public function disableEnableContact($id,$contact_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $contact_person=ContactPerson::find($contact_id);
        if($contact_person->status==1){
            $contact_person->status=0;
        }else{
            $contact_person->status=1;
        }
        $contact_person->save();
        return redirect(route('clientmanagement.viewContacts', $id));
    }
    public function deleteContact($id,$contact_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $contact_person=ContactPerson::find($contact_id);
        $contact_person->email=$contact_person->email.'-deleted'.date('Y-m-d H:i:s');
        $contact_person->landline=$contact_person->landline.'-deleted'.date('Y-m-d H:i:s');
        $contact_person->phone_no=$contact_person->phone_no.'-deleted'.date('Y-m-d H:i:s');
        $contact_person->delete();
        return redirect(route('clientmanagement.viewContacts', $id));
    }

    // rate card

    public function redirectToRatecardList($id){
        $ratecards=Ratecard::where('client_id',$id)->orderBy('created_at','desc')->get();
        return view('clientmanagement::list_ratecards')->with('id',$id)->with('ratecards',$ratecards);
    }

    public function redirectToRatecardAdd($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        return view('clientmanagement::add_ratecard')->with('id',$id);
    }

    public function ratecardAdd(Request $request,$id){
        $request->validate([
            'type'=>'required',
            't_rate'=>'required',
            'v1_rate'=>'required',
            'v2_rate'=>'required',
            'bt_rate'=>'required',
            'btv_rate'=>'required',
            't_minimum_rate'=>'required',
            'v1_minimum_rate'=>'required',
            'v2_minimum_rate'=>'required',
            'bt_minimum_rate'=>'required',
            'btv_minimum_rate'=>'required',
            'lang.*' => 'string'
        ],[
            'type.required'=>'Please select type.',
            't_rate.required'=>'Please select T Rate.',
            'v1_rate.required'=>'Please select V1 Rate.',
            'v2_rate.required'=>'Please select V2 Rate.',
            'bt_rate.required'=>'Please select BT Rate.',
            'btv_rate.required'=>'Please select BTV Rate.',
            't_minimum_rate.required'=>'Please select T Minimum Rate.',
            'v1_minimum_rate.required'=>'Please select V1 Minimum Rate.',
            'v2_minimum_rate.required'=>'Please select V2 Minimum Rate.',
            'bt_minimum_rate.required'=>'Please select BT Minimum Rate.',
            'btv_minimum_rate.required'=>'Please select BTV Minimum Rate.'
        ]);

        if( count($request->lang) > 0){
            foreach($request->lang as $language){
                $ratecard = new Ratecard();
                $ratecard->client_id=$id;
                $ratecard->type=$request->type;
                $ratecard->t_rate=$request->t_rate;
                $ratecard->v1_rate=$request->v1_rate;
                $ratecard->v2_rate=$request->v2_rate;
                $ratecard->bt_rate=$request->bt_rate;
                $ratecard->btv_rate=$request->btv_rate;
                $ratecard->t_minimum_rate=$request->t_minimum_rate;
                $ratecard->v1_minimum_rate=$request->v1_minimum_rate;
                $ratecard->v2_minimum_rate=$request->v2_minimum_rate;
                $ratecard->bt_minimum_rate=$request->bt_minimum_rate;
                $ratecard->btv_minimum_rate=$request->btv_minimum_rate;
                $ratecard->lang=$language;
                $ratecard->save();
            }
            return redirect(route('clientmanagement.redirectToRatecardList', $id))->with('message', 'Rate Card added successfully.');
        }
        return redirect(back())->with('alert', 'Please select at least one language.');
    }
    
    public function redirectToRatecardEdit($id,$ratecardId){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $ratecard=Ratecard::find($ratecardId);
        return view('clientmanagement::edit_ratecard')->with('id',$id)->with('ratecard',$ratecard);
    }

    public function ratecardEdit(Request $request,$id,$ratecardId){
        $request->validate([
            'type'=>'required',
            't_rate'=>'required',
            'v1_rate'=>'required',
            'v2_rate'=>'required',
            'bt_rate'=>'required',
            'btv_rate'=>'required',
            't_minimum_rate'=>'required',
            'v1_minimum_rate'=>'required',
            'v2_minimum_rate'=>'required',
            'bt_minimum_rate'=>'required',
            'btv_minimum_rate'=>'required'
        ],[
            'type.required'=>'Please select type.',
            't_rate.required'=>'Please select T Rate.',
            'v1_rate.required'=>'Please select V1 Rate.',
            'v2_rate.required'=>'Please select V2 Rate.',
            'bt_rate.required'=>'Please select BT Rate.',
            'btv_rate.required'=>'Please select BTV Rate.',
            't_minimum_rate.required'=>'Please select T Minimum Rate.',
            'v1_minimum_rate.required'=>'Please select V1 Minimum Rate.',
            'v2_minimum_rate.required'=>'Please select V2 Minimum Rate.',
            'bt_minimum_rate.required'=>'Please select BT Minimum Rate.',
            'btv_minimum_rate.required'=>'Please select BTV Minimum Rate.'
        ]);

        $ratecard = Ratecard::where('id',$ratecardId)->first();
        $ratecard->type=$request->type;
        $ratecard->t_rate=$request->t_rate;
        $ratecard->v1_rate=$request->v1_rate;
        $ratecard->v2_rate=$request->v2_rate;
        $ratecard->bt_rate=$request->bt_rate;
        $ratecard->btv_rate=$request->btv_rate;
        $ratecard->t_minimum_rate=$request->t_minimum_rate;
        $ratecard->v1_minimum_rate=$request->v1_minimum_rate;
        $ratecard->v2_minimum_rate=$request->v2_minimum_rate;
        $ratecard->bt_minimum_rate=$request->bt_minimum_rate;
        $ratecard->btv_minimum_rate=$request->btv_minimum_rate;
        $ratecard->save();
        return redirect(route('clientmanagement.redirectToRatecardList', $id))->with('message', 'Rate Card updated successfully.');
    }

    public function ratecardDelete($id,$ratecardId){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $ratecard = Ratecard::find($ratecardId);
        $ratecard->t_rate=$ratecard->t_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->v1_rate=$ratecard->v1_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->v2_rate=$ratecard->v2_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->bt_rate=$ratecard->bt_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->btv_rate=$ratecard->btv_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->minimum_rate=$ratecard->minimum_rate.'-deleted'.date('Y-m-d H:i:s');
        $ratecard->delete();
        return redirect(route('clientmanagement.redirectToRatecardList', $id));
    }
}
