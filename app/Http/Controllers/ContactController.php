<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller{
    public function index(){
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        echo Auth::user()->id;
        echo request()->cookie('filial_id');
        echo $request->message;
        $validated = $request->validate([
            'text' => 'required'
        ]);
        $validated['filial_id'] = request()->cookie('filial_id');
        $validated['user_id'] = Auth::user()->id;
        $validated['user_type'] = 'false';
        $validated['admin_type'] = 'false';
        $validated['status'] = 'user';
        $validated['admin_id'] = 'NULL';
        $Contact = Contact::create($validated);
        return redirect()->route('home','#contact')->with('success','Murojat yuborildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
