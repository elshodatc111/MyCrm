<?php
namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class RoomController extends Controller{
    public function index(){
        $Rooms = Room::join('users', 'users.id','rooms.user_id')
        ->select('rooms.room_name','rooms.room_sigimi','rooms.id','rooms.room_max_sigimi','rooms.status','users.email')
        ->where('rooms.filial_id',request()->cookie('filial_id'))
        ->where('rooms.status','true')
        ->get();
        return view('room.index', compact('Rooms'));
    }

    public function create(){
        return view('room.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            "room_name" => ['required'],
            "room_sigimi" => ['required'],
            "room_max_sigimi" =>['required']
        ]);
        $validated['status'] = 'true';
        $validated['user_id'] = Auth::user()->id;
        $validated['filial_id'] = request()->cookie('filial_id');
        Room::create($validated);
        return redirect()->route('room.index')->with('success','Yangi xona qo\'shildi.');
    }

    public function show(Room $room){
        return view('room.show',compact('room'));
    }

    public function edit(Room $room){
        return view('room.edit',compact('room'));
    }

    public function update(Request $request, Room $room){
        $validated = $request->validate([
            "room_name" => ['required'],
            "room_sigimi" => ['required'],
            "room_max_sigimi" =>['required']
        ]);
        $room->update($validated);
        return redirect()->route('room.index')->with('success','Xona taxrirlandi.');
    }

    public function destroy(Room $room){
        $room->status = 'false';
        $room->update();
        return redirect()->route('room.index')->with('success','Xona o\'chirildi.');
    }
}
