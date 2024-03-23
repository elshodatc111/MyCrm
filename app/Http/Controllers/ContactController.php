<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller{
    public function index(){
        $User =User::where('filial',request()->cookie('filial_id'))->get();
        $Contact = array();
        $thisDate = date("Y-m-d",strtotime('-30 day',strtotime(date('Y-m-d'))))." 23:59:59";
        foreach ($User as $key => $value) {
            $id = Contact::where('user_id','LIKE',$value->id)->where('created_at','>=',$thisDate)->orderby('created_at','desc')->value('id');
            $user_id = Contact::where('user_id','LIKE',$value->id)->orderby('created_at','desc')->value('user_id');
            $Cont = Contact::where('id',$id)->get()->first();
            $comment = count(Contact::where('user_id',$user_id)
                ->where('status','user')
                ->where('admin_type','false')
                ->get());
            if(!empty($id)){
                $Contact[$key]['user_id'] = $user_id;
                $Contact[$key]['name'] = $value->name;
                $Contact[$key]['status'] = $Cont->status;
                $Contact[$key]['text'] = $Cont->text;
                $Contact[$key]['comment'] = $comment;
                $Contact[$key]['created_at'] = $Cont->created_at;
                if($Cont->status=='admin'){
                    if($Cont->user_type=='true'){
                        $Contact[$key]['user_type'] = 'true';
                    }else{
                        $Contact[$key]['user_type'] = 'false';
                    }
                }
            }
        }
        return view('contact.index',compact('Contact'));
    }
    public function AdminSendMurojat(Request $request){
        $validated = $request->validate([
            'user_id' => 'required',
            'text' => 'required'
        ]);
        $validated['filial_id'] = request()->cookie('filial_id');
        $validated['status'] = 'admin';
        $validated['admin_id'] = Auth::user()->id;
        $validated['user_type'] = 'false';
        $validated['admin_type'] = 'false';
        $Contact = Contact::create($validated);
        return back()->withInput()->with('success',"Xabar yuborildi.");
    }
    public function create()
    {
        //
    }

    ### Talaba kabinetidan sms yuborish ###
    public function store(Request $request){
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
    public function show(string $user_ids){
        $User =User::get();
        $Contact = array();
        $thisDate = date("Y-m-d",strtotime('-30 day',strtotime(date('Y-m-d'))))." 23:59:59";
        foreach ($User as $key => $value) {
            $id = Contact::where('user_id','LIKE',$value->id)->where('created_at','>=',$thisDate)->orderby('created_at','desc')->value('id');
            $user_id = Contact::where('user_id','LIKE',$value->id)->orderby('created_at','desc')->value('user_id');
            $Cont = Contact::where('id',$id)->get()->first();
            $comment = count(Contact::where('user_id',$user_id)->where('status','user')->where('admin_type','false')->get());
            if(!empty($id)){
                $Contact[$key]['user_id'] = $user_id;
                $Contact[$key]['name'] = $value->name;
                $Contact[$key]['status'] = $Cont->status;
                $Contact[$key]['text'] = $Cont->text;
                $Contact[$key]['comment'] = $comment;
                $Contact[$key]['created_at'] = $Cont->created_at;
                if($Cont->status=='admin'){
                    if($Cont->user_type=='true'){
                        $Contact[$key]['user_type'] = 'true';
                    }else{
                        $Contact[$key]['user_type'] = 'false';
                    }
                }
            }
        }
        $Typing = Contact::where('user_id',$user_ids)->where('admin_type','false')->get();
        foreach ($Typing as $key => $value) {
            $value->update(['admin_type'=>'true']);
        }
        $User = User::where('id',$user_ids)->get()->first();

        $Murojat = Contact::where('user_id',$user_ids)->get();
        $Muroratlar = array();
        foreach ($Murojat as $key => $value) {
            $Muroratlar[$key]['created_at']=$value->created_at;
            $Muroratlar[$key]['user_type']=$value->user_type;
            $Muroratlar[$key]['text']=$value->text;
            $Muroratlar[$key]['status']=$value->status;
            if($value->status=='admin'){
                $Muroratlar[$key]['admin'] = User::where('id', $value->admin_id)->get()->first()->name;
                $Muroratlar[$key]['user_type']=$value->user_type;
            }
        }
        #dd($Muroratlar);
        return view('contact.show',compact('Contact','User','Muroratlar'));
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
