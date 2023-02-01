<?php

namespace App\Http\Controllers;

use App\Models\NiveauIntervontion;
use App\Models\Technicien;
use App\Models\User;
use Illuminate\Http\Request;

class TechnicienController extends Controller
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
        $niveaus = NiveauIntervontion::all();
        $users = User::all();
        $techniciens = Technicien::join("niveau_intervontions", "niveau_intervontions.id", "techniciens.niveau_intervontion_id")
            ->join("users", "users.id", "techniciens.user_id")
            ->select("techniciens.id","users.name as username", "niveau_intervontions.name as niveau")
            ->orderBy('id', 'DESC')->get();
        //dd($techniciens);

        return view('techniciens.index', compact('techniciens', "users", "niveaus"));
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
            'niveau_intervontion_id' => 'required',
            'user_id' => 'required',
            //'affectation_id'=> 'required',
        ]);
        $machin = new Technicien([
            'niveau_intervontion_id' => $request->get('niveau_intervontion_id'),
            'user_id' => $request->get('user_id'),
        ]);
        $machin->save();
        //return redirect('/techniciens')->with('success',' la Sous Affectation a été ajouté avec succès');
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
        $machin = Technicien::find($id);
        return response()->json(["data" => $machin]);
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
        
        $machin = Technicien::find($id);
        $machin->niveau_intervontion_id = $request->input('niveau_intervontion_id');
        $machin->user_id = $request->input('user_id');
        // $machin->description = $request->input('description');
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
        $machin = Technicien::find($id);
        $machin->delete();
        return response()->json(["status" => "success"]);
    }

    public function gettechniciens()
    {
        // $affectation_id = $request->input("affectation_id");
        $techniciens = Technicien::select("name as text", "id as value")->get();
        return response()->json([

            'techniciens' => $techniciens,
        ]);
    }
    public function refreshTable()
    {
        $techniciens = Technicien::join("niveau_intervontions", "niveau_intervontions.id", "techniciens.niveau_intervontion_id")
            ->join("users", "users.id", "techniciens.user_id")
            ->select("techniciens.id","users.name as username", "niveau_intervontions.name as niveau")
            ->orderBy('id', 'DESC')->get();
        return view("techniciens.table", compact('techniciens'));
    }
}
