<?php

namespace Modules\EmployeeManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee=User::where('email','!=','developer@kesen.com')->where('id','!=',Auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('employeemanagement::index')->with('employee',$employee);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employeemanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_no' => 'required|numeric|unique:users,phone',
            'address' => 'nullable',
            'code' => 'nullable|unique:users',
            'landline' => 'nullable|numeric|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8',
            'role' => 'required',
            'language' => 'required',
        ]);

        

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone_no;
        $user->address = $request->address;
        $user->code = $request->code;
        $user->landline = $request->landline;
        $user->password = bcrypt($request->password);
        $user->plain_password = $request->password;
        $user->language_id = $request->language;
        $user->created_by = Auth()->user()->id;
        $user->updated_by = Auth()->user()->id;
        $user->status = 1;
        $user->save();
        $user->assignRole($request->role);
        return redirect('/employee-management')->with('message', 'Employee created successfully.');;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user=User::find($id);
        return view('employeemanagement::show')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user=User::find($id);
        return view('employeemanagement::edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email'=>'required|email|unique:users,email,' . $id . ',id',
            'phone_no'=>'nullable|numeric|unique:users,phone,' . $id . ',id',
            'landline'=>'nullable|numeric|unique:users,landline,' . $id . ',id',
            'address' => 'nullable',
            'code' => 'nullable|unique:users,code,' . $id . ',id',
            'password' => 'required|min:8',
            'role' => 'required',
            'language' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone_no;
        $user->address = $request->address;
        $user->code = $request->code;
        $user->landline = $request->landline;
        if(isset($request->password)){
            $user->password = bcrypt($request->password);
            $user->plain_password = $request->password;
        }
        $user->language_id = $request->language;
        $user->updated_by = Auth()->user()->id;
        $user->save();
        $user->syncRoles($request->role);

        return redirect('/employee-management')->with('message', 'Employee updated successfully.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function disableEnableClient($id){
        $client=User::find($id);
        if($client->status==1){
            $client->status=0;
        }else{
            $client->status=1;
        }
        $client->save();
        return redirect('/employee-management');
    }
}
