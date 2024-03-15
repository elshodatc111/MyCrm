<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Talaba;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use App\Models\Guruh;
use App\Models\Tolov;
use App\Models\GuruhUser;
use App\Models\Eslatma;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MoliyaController extends Controller{
    public function index(){
        ## Naqt tulovlar Summasi
        $NaqtTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))->where('status', 'TulovNaqt')->where('type', 'false')->get();
        $Naqt = 0;
        foreach ($NaqtTulov as $key => $value) {$Naqt = $Naqt + $value->summa;}
        $Naqt1 = number_format(($Naqt), 0, '.', ' ');
        ## Plastik to'lovlar
        $PlastikTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))->where('status', 'TulovPlastik')->where('type', 'false')->get();
        $Plastik = 0;
        foreach ($PlastikTulov as $key => $value) {$Plastik = $Plastik + $value->summa;}
        $Plastik1 = number_format(($Plastik), 0, '.', ' ');
        return view('moliya.index', compact('Naqt1','Plastik1'));
    }
    public function naqtMoliya(){
        $Tulovlar = array();
        $NaqtTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))
        ->where('status', 'TulovNaqt')->where('type', 'false')->get();
        #dd($NaqtTulov->summa);
        foreach ($NaqtTulov as $key => $value) {
            $Tulovlar[$key]['summa'] = $value->summa;
            $Tulovlar[$key]['izoh'] = $value->izoh;
        }

        return view('moliya.naqt');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
