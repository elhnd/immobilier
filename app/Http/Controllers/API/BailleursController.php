<?php

namespace App\Http\Controllers\API;

use App\Biens;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Operations;
use App\Paiements;
use Illuminate\Support\Facades\Hash;


class BailleursController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::latest()->paginate(10);
        return DB::table('users')
            ->where('type', 'bailleurs')
            ->leftJoin('typebailleurs', 'typebailleurs.typebailleurs_id', '=', 'users.typebailleur')
            ->select('users.*', 'typebailleurs.*')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,',
            'password' => 'sometimes|required|min:6',
            'email' => 'sometimes|min:6',
            'profession' => 'required|string|max:191',
            'nationalite' => 'required|string|max:191',
            'typebailleurs_id' => 'required',


        ]);
        $bailleur = User::where('email', $request->email)->first();

        if (isset($bailleur->id)) {
            return response()->json(["error" => "L'email existe déjà"], 401);
        }

        $date = (154263);
        $min_epoch = strtotime($date);
        $var = rand($min_epoch, 1000);
        $strval = 'FR_401';
        $items = ($strval . $var);
        $bailleur = new User();
        $bailleur->name = $request['name'];
        $bailleur->adresse = $request['adresse'];
        $bailleur->telephone = $request['telephone'];
        $bailleur->email = $request['email'];
        $bailleur->type = $request['type'];
        $bailleur->numero = $items;
        $bailleur->solde = 0;
        $bailleur->profession = $request['profession'];
        $bailleur->bp = $request['bp'];
        $bailleur->typebailleur = $request['typebailleurs_id'];
        $bailleur->nationalite = $request['nationalite'];
        $bailleur->password = Hash::make($request['password']);
        $bailleur->save();
        return $bailleur;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bailleur = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $bailleur->id,
            'email' => 'sometimes|min:6',
            'profession' => 'required|string|max:191',
            'nationalite' => 'required|string|max:191',
        ]);
        $bailleur->update($request->all());
        return ['message' => 'Les données du bailleur modifiées avec succès'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bailleur = User::findOrFail($id);
        $bailleur->delete();
        return ['message' => 'Bailleur supprimé avec succès'];
    }
    public function countbailleurs()
    {
        return User::where('type', 'bailleurs')->count();
    }
    public function countbiensbailleurs(Request $request)
    {
        $id = strval($request['id']);
        return Biens::where('bailleur', $id)->count();
    }

    public function rapportBailleur(Request $request, $id)
    {
        $bailleur = User::findOrFail($id);

        if ($bailleur->type !== 'bailleurs') {

            return response()->json(["error" => "Cet utilisateur n'est pas un bailleur"], 401);
        }

        $operations =  DB::table('biens')
            ->where('bailleur', $id)
            ->leftJoin('operations', 'operations.biens', '=', 'biens.bien_id')
            ->leftJoin('paiements', 'operations.operation_id', '=', 'paiements.operations')
            ->select('biens.details', 'biens.solde', 'biens.louer', 'biens.prix', 'operations.*')->get();
        $paiements =  DB::table('biens')
            ->where('bailleur', $id)
            ->leftJoin('operations', 'operations.biens', '=', 'biens.bien_id')
            ->leftJoin('paiements', 'operations.operation_id', '=', 'paiements.operations')
            ->select('biens.details', 'biens.solde', 'biens.louer', 'biens.prix', 'paiements.*')->get();
        $newPaiement = [];
        foreach ($paiements as $paiement) {
            if ($paiement->operations !== null) {
                array_push($newPaiement, $paiement);
            }
        }
        $data = [
            'bailleur' => $bailleur,
            'operations' => $operations,
            'paiements' => $newPaiement
        ];

        return response()->json($data);
    }
}
