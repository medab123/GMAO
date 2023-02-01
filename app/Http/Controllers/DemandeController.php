<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\demandeTechnicien;
use App\Models\Machin;
use App\Models\NiveauIntervontion;
use App\Models\suivi;
use App\Models\Technicien;
use App\Models\TypeIntervontion;
use Illuminate\Http\Request;

class DemandeController extends Controller
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
        $demandes = Demande::join("machins as m", "m.id", "demandes.machine_id")
            ->join("users as d", "d.id", "demandes.demandeur_id")
            ->join("niveau_intervontions as n", "n.id", "demandes.niveau_intervontion_id")
            ->join("type_intervontions as t", "t.id", "demandes.type_intervontion_id")
            ->select("demandes.*", "m.name as machine", "d.name as demondeur_name", "d.email as email", "n.name as niveau_intervontion", "t.name as type_intervontion")
            ->orderBy('id', 'DESC')->with("techniciens")->get();
        //dd($demandes);
        $typeIntervontions = TypeIntervontion::all();
        $machines = Machin::all();
        $niveaus = NiveauIntervontion::all();
        //dd($demandes);

        return view('Demandes.index', compact('demandes', "typeIntervontions", "machines", "niveaus"));
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
            //'affectation_id'=> 'required',
        ]);
        $demande = new Demande([
            'demandeur_id' => \Auth::user()->id,
            'niveau_intervontion_id' => $request->get('niveau_intervontion_id'),
            'machine_id' => $request->get('machine_id'),
            'type_intervontion_id' => $request->get('type_intervontion_id'),
            'description' => $request->get('description'),
            'status' => 0,
        ]);
        $demande->save();

        $suivi = new suivi();
        $suivi->demande_id = $demande->id;
        $suivi->sender_id = $demande->demandeur_id;
        $suivi->message = $request->get('description');
        $suivi->save();

        $technicien = @Technicien::where("niveau_intervontion_id", $demande->niveau_intervontion_id)->first()->user_id ?: null;
        if($technicien){
            $affectation = new demandeTechnicien();
            $affectation->user_id = $technicien;
            $affectation->demande_id = $demande->id;
            $affectation->save();
        }
        
        //return redirect('/demandes')->with('success',' la Sous Affectation a été ajouté avec succès');
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
        $techniciens = Technicien::with("user")->get();
        $suivis = suivi::where("demande_id",$id)->get();
        //dd($techniciens);
        $demandeur = Demande::with("demandeur")->find($id)->demandeur;
        $demande = Demande::with("techniciens", "machine", "niveau")->find($id);
        $modelTechnicien = new Technicien();
        return view("demandes.edit", compact("demande", "demandeur", "modelTechnicien","techniciens","suivis"));
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
        $demande = Demande::find($id);
        $demande->name = $request->input('name');
        // $demande->description = $request->input('description');
        $demande->update();
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
        $demande = Demande::find($id);
        $demande->delete();
        return response()->json(["status" => "success"]);
    }
    public function removeTechnicien(Request $request , $id)
    {
        $technicien_id = $request->get("technicien_id");
        $technicien_demande = demandeTechnicien::where("user_id",$technicien_id)->where("demande_id",$id)->first();
        $technicien_demande->delete();
        return response()->json(["status" => "success"]);
    }

    public function getdemandes()
    {
        // $affectation_id = $request->input("affectation_id");
        $demandes = Demande::select("name as text", "id as value")->get();
        return response()->json([

            'demandes' => $demandes,
        ]);
    }
    public function addTechnicien(Request $request, $id)
    {
        // $affectation_id = $request->input("affectation_id");
        $affectation = new demandeTechnicien();
        $affectation->user_id = $request->get("technicien_id");
        $affectation->demande_id = $id;
        $affectation->save();
        return back()->with(["status"=>"success","message"=>"Technicien ajouter avec success"]);
    }
    public function refreshTable()
    {
        $demandes = Demande::join("machins as m", "m.id", "demandes.machine_id")
            ->join("users as d", "d.id", "demandes.demandeur_id")
            ->join("niveau_intervontions as n", "n.id", "demandes.niveau_intervontion_id")
            ->join("type_intervontions as t", "t.id", "demandes.type_intervontion_id")
            ->select("demandes.*", "m.name as machine", "d.name as demondeur_name", "d.email as email", "n.name as niveau_intervontion", "t.name as type_intervontion")
            ->orderBy('id', 'DESC')->get();
        return view("Demandes.table", compact('demandes'));
    }
}
