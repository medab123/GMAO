<?php

namespace App\Http\Controllers;

use App\Models\NiveauIntervontion;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
       /* $this->middleware('permission:resource-list|resource-create|resource-edit|resource-delete|resource-search', ['only' => ['index', 'show']]);
        $this->middleware('permission:resource-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:resource-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:resource-delete', ['only' => ['destroy']]);*/
    }
    public function index()
    {
        $niveauintervontions = NiveauIntervontion::orderBy('id', 'DESC')->get();;
        //dd($niveauintervontions);
        
        return view('NiveauIntervontions.index',compact('niveauintervontions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|max:255',
        //'affectation_id'=> 'required',
        ]);
        $machin = new NiveauIntervontion([
        'name' => $request->get('name'),
        'description'=>$request->get('description'),

        ]);
        $machin->save();
        //return redirect('/niveauintervontions')->with('success',' la Sous Affectation a été ajouté avec succès');
        return response()->json(["status" => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machin = NiveauIntervontion::find($id);
        return response()->json(["data"=>$machin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $machin = NiveauIntervontion::find($id);
        $machin->name = $request->input('name');
        $machin->description = $request->input('description');
        $machin->update();
        return response()->json(["status" => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $machin = NiveauIntervontion::find($id);
        $machin->delete();
        return response()->json(["status" => "success"]);
    }

    public function getniveauintervontions(){
       // $affectation_id = $request->input("affectation_id");
        $niveauintervontions = NiveauIntervontion::select("name as text","id as value")->get();
        return response()->json([

            'niveauintervontions'=>$niveauintervontions,
        ]);
    }
    public function refreshTable()
    {
        $niveauintervontions = NiveauIntervontion::orderBy('id', 'DESC')->get();
        return view("NiveauIntervontions.table", compact('niveauintervontions'));
    }
}
