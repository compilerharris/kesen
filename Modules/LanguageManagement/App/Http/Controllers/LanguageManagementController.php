<?php

namespace Modules\LanguageManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\LanguageManagement\App\Models\Language;

class LanguageManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $language=Language::orderBy('created_at', 'desc')->get();
        return view('languagemanagement::index')->with('languages',$language);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        return view('languagemanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|max:3|min:2',
        ]);
        $language=new Language();
        $language->name=$request->name;
        $language->code=$request->code;
        $language->created_by=auth()->user()->id;
        $language->updated_by=auth()->user()->id;
        $language->save();
        return redirect('/language-management')->with('message', 'Language created successfully.');;

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $language=Language::find($id);
        return view('languagemanagement::show')->with('language',$language);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back(); 
        }
        $language=Language::find($id);
        return view('languagemanagement::edit')->with('language',$language);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|max:3|min:2',
        ]);
        $language=Language::find($id);
        $language->name=$request->name;
        $language->code=$request->code;
        $language->updated_by=auth()->user()->id;
        $language->save();
        return redirect('/language-management')->with('message', 'Language updated successfully.');;
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
        $language=Language::find($id);
        $language->status=$language->status==1?0:1;
        $language->save();
        return redirect()->back();
    }
}
