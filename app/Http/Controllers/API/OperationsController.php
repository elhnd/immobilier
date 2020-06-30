<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Biens;
use App\Divers;
use App\Clients;
use App\Lieuxes;
use App\Paiements;
use App\Operations;
use App\Equipements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OperationsController extends Controller
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
    public function listebiens()
    {

        return DB::table('biens')
            ->where('louer', false)
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->Join('typeetats', 'biens.etat', '=', 'typeetats.id')
            ->select('biens.*', 'typebiens.*', 'typeetats.*')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revoque()
    {

        return DB::table('operations')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('typeetats', 'typeetats.id', '=', 'biens.etat')
            ->select('operations.*', 'clients.*', 'biens.*', 'typeetats.libelleE')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paiementactif()
    {

        return DB::table('operations')
            ->where('statut', 'louer')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('typeetats', 'typeetats.id', '=', 'biens.etat')
            ->select('operations.*', 'clients.*', 'biens.*', 'typeetats.libelleE')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function divers()
    {
        //->leftJoin('operations', 'divers.operations', '=', 'operations.operation_id')

        return DB::table('operations')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('divers', 'operations.operation_id', '=', 'divers.divers_id')
            ->select('operations.montantPaye', 'operations.ref', 'operations.operation_id', 'clients.nom', 'clients.prenom', 'clients.tel', 'biens.*', 'divers.commentaire', 'divers.fichier', 'divers.divers_id')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function louer(Request $request)
    {

        $this->validate($request, [
            'details' => 'required|string|max:191',
            'caution' => 'required|string|max:191',
            'montantPaye' => 'required|string|max:191',
            'dateEntre' => 'required|string|max:191',
            'client' => 'required|string|max:191',
            'numero' => 'required|string|max:191',
            'commission' => 'required',
            //'taxes' => 'required',
            'durée' => 'required',


        ]);



        $client =  DB::table('clients')->where('tel', $request['numero'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();

        $caution = $bien->prix * 5;

        if ($request['caution'] > $caution) {
            return Response()->json([
                "status" => 500,
                'message' => "La caution ne doit être supérieur 5 fois au prix de la location"
            ]);
        }
        if ($request['montantPaye'] > $caution) {
            return Response()->json([
                "status" => 500,
                'message' => "Le montant payé ne doit être supérieur 5 fois au prix de la location"
            ]);
        }



        $Operation = new Operations();

        if ($request->dernierelevé != []) {
            $dernierelevé = $this->upload($request->dernierelevé);
            $Operation->dernierelevé = $dernierelevé;
        }
        if ($request->piece != []) {
            $piece = $this->upload($request->piece);
            $Operation->piece = $piece;
        }

        $Operation->dateEntre = date("H:i:s", strtotime(request('dateEntre')));
        $Operation->durée = $request['durée'];
        $Operation->dateEntre = $request['dateEntre'];
        $Operation->commentaire = $request['commentaire'];

        $montant =    $request['montantPaye'];

        $Operation->caution = $request['caution'];

        $Operation->charge = $request['charge'];

        $Operation->commission = $request['commission'];

        $charge =  $request['charge'] + $request['montantPaye'];

        if ($request['tva'] == "true") {
            $Operation->tva =  $request['montantPaye'] * 0.18;
        } else {
            $Operation->tva = 0;
        }
        if ($request['teom'] == "true") {
            $Operation->teom =  $request['montantPaye'] * 0.036;
        } else {
            $Operation->teom =  0;
        }
        if ($request['de'] == "true") {
            $Operation->de =  $request['montantPaye'] * 0.02;
        } else {
            $Operation->de = 0;
        }

        $Operation->taxes =  $Operation->tva +  $Operation->teom + $Operation->de;

        $sup = $Operation->taxes + $charge;

        $Operation->montantPaye = $sup + $Operation->caution;

        $Operation->clients = $client->client_id;
        $Operation->biens = $bien->bien_id;
        $Operation->ref = rand(0, 1000000);

        //update bien
        $soleBien = $bien->solde + $request['montantPaye'];

        // dd($Operation);
        DB::table('biens')
            ->where('bien_id', $bien->bien_id)
            ->update(['louer' => true, 'solde' => $soleBien]);
        //update client
        $soldeCli = $request['montantPaye'] + $client->solde;
        DB::table('clients')
            ->where('client_id', $client->client_id)
            ->update(['solde' => $soldeCli]);
        if ($bien->bailleur == 1) {
            //update propriétaire
            $prop = User::findOrFail(1);
            $soldeP = $prop->solde + $montant;
            DB::table('users')
                ->where('id',  1)
                ->update(['solde' => $soldeP]);
        } else {
            //update bailleur
            $bailleur = User::findOrFail($bien->bailleur);
            $solde = $bailleur->solde + $Operation->montantPaye;
            DB::table('users')
                ->where('id', $bien->bailleur)
                ->update(['solde' => $solde]);
            //update propriétaire
            $prop = User::findOrFail(1);
            $commission = $prop->commission + $request['commission'];
            $soldeTVA = $prop->tva + $Operation->tva;
            $soldeTEOM =  $prop->teom + $Operation->teom;
            $soldeDE = $prop->de + $Operation->de;
            $soldeP = $prop->solde + $commission;
            DB::table('users')
                ->where('id',  1)
                ->update(['solde' => $soldeP, 'commission' => $commission,'tva' => $soldeTVA, 'teom' => $soldeTEOM, 'de' => $soldeDE]);
        }


        $Operation->save();

        return Response()->json(['Operation' => $Operation, 'bien' => $bien, 'client' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRevoque(Request $request)
    {

        $Operation = DB::table('operations')
            ->where('operation_id', $request['operation_id'])
            ->update(['statut' => 'revoquer']);

        DB::table('biens')
            ->where('bien_id', $request['bien_id'])
            ->update(['louer' => false]);
        return Response()->json(['operation' => $Operation]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paiement(Request $request)
    {


        $this->validate($request, [

            'montant' => 'required',
            'date' => 'required',

        ]);
        $paie = DB::table('paiements')->where([
            ['operations', '=', $request['operation_id']],
            ['date', '=', $request['date']],
        ])->first();

        if ($paie) {
            return Response()->json([
                "status" => 500,
                'message' => "Paiement déjà enregistré"
            ]);
        }

        $client =  DB::table('clients')->where('tel', $request['tel'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();

        $prix = $request['prix'];
        $montant = $request['montant'];
        $soleBien = $bien->solde + $montant;
        $Operation = DB::table('operations')
            ->where('operation_id', $request['operation_id'])->first();


        $paiement = new Paiements();
        $paiement->date = $request['date'];
        $paiement->commission = $Operation->commission;
        $paiement->ref = rand(0, 1000000);
        $paiement->operations = $Operation->operation_id;


        if ($request['charge'] &&  $request['charge'] > 0) {
            $paiement->charge = $request['charge'];
        } else {
            $paiement->charge = 0;
        }

        $charge =  $paiement->charge + $request['montant'];

        if ($request['tva'] == "true") {
            $paiement->tva =  $request['montant'] * 0.18;
        } else {
            $paiement->tva = 0;
        }
        if ($request['teom'] == "true") {
            $paiement->teom =  $request['montant'] * 0.036;
        } else {
            $paiement->teom =  0;
        }
        if ($request['de'] == "true") {
            $paiement->de =  $request['montant'] * 0.02;
        } else {
            $paiement->de = 0;
        }

        $paiement->taxes =  $paiement->tva +  $paiement->teom + $paiement->de;

        $sup = $paiement->taxes + $charge;

        $paiement->montant = $sup;


        if ($montant < $prix) {
            return Response()->json([
                "status" => 500,
                'message' => "Le montant payé ne doit être inférieur  au prix de la location"
            ]);
        } else
            if ($montant > $prix) {
            return Response()->json([
                "status" => 500,
                'message' => "Le montant payé ne doit être supérieur  au prix de la location"
            ]);
        } else {
            DB::table('biens')
                ->where('bien_id', $bien->bien_id)
                ->update(['louer' => true, 'solde' => $soleBien]);
            //update client

            $soldeCli = $montant + $client->solde;
            DB::table('clients')
                ->where('client_id', $client->client_id)
                ->update(['solde' => $soldeCli]);
            if ($bien->bailleur == 1) {
                //update propriétaire
                $prop = User::findOrFail(1);
                $soldeP = $prop->solde + $montant;
                DB::table('users')
                    ->where('id',  1)
                    ->update(['solde' => $soldeP]);
            } else {
                //update bailleur
                $bailleur = User::findOrFail($bien->bailleur);
                $solde = $bailleur->solde + $montant;
                DB::table('users')
                    ->where('id', $bien->bailleur)
                    ->update(['solde' => $solde]);
                //update propriétaire
                $prop = User::findOrFail(1);
                $commission = $prop->commission + $request['commission'];
                $soldeTVA = $prop->tva + $paiement->tva;
                $soldeTEOM =  $prop->teom + $paiement->teom;
                $soldeDE = $prop->de + $paiement->de;
                $soldeP = $prop->solde + $commission;
                DB::table('users')
                    ->where('id',  1)
                    ->update(['solde' => $soldeP, 'commission' => $commission,'tva' => $soldeTVA, 'teom' => $soldeTEOM, 'de' => $soldeDE]);
            }

            $paiement->save();

            return Response()->json(["status" => 200, 'message' => "Paiement effectué avec succès"]);
        }
    }

    public function findclient(Request $request)
    {
        return Clients::where('tel', $request['numero'])->first();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findoperation(Request $request)
    {
        return DB::table('operations')
            ->where('ref', $request['ref'])
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->select('operations.montantPaye', 'operations.operation_id', 'clients.nom', 'clients.prenom', 'biens.details')->paginate(1);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDivers(Request $request)
    {

        $this->validate($request, [

            //'fichier'  => 'required|mimes:doc,docx,pdf,txt|max:2048',
            'commentaire' => 'required',


        ]);
        $fichier = $this->upload($request->fichier);

        $divers = new Divers();

        $divers->commentaire = $request['commentaire'];
        $divers->operations = $request['operations'];
        $divers->fichier = $fichier;
        $divers->save();

        return Response()->json(["status" => 200, 'message' => "succes"]);
    }

    public function upload($var)
    {


        $file = $var;



        //Display File Name
        echo 'File Name: ' . $file->getClientOriginalName();
        echo '';
        //Display File Extension
        echo 'File Extension: ' . $file->getClientOriginalExtension();
        echo '';
        //Display File Real Path
        echo 'File Real Path: ' . $file->getRealPath();
        echo '
        ';
        //Display File Size
        echo 'File Size: ' . $file->getSize();
        echo '
        ';
        //Display File Mime Type
        echo 'File Mime Type: ' . $file->getMimeType();
        //Move Uploaded File
        $destinationPath = 'img/profile/';
        $file->move($destinationPath, $file->getClientOriginalName());
        return $file->getClientOriginalName();
    }
}
