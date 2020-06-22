<?php

namespace App\Http\Controllers\API;

use App\Typebiens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TypebiensController extends Controller
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
       // if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Typebiens::latest()->paginate(10);
       // }
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
            'libelle' => 'required|string|max:191'

        ]);

        return Typebiens::create([
            'libelle' => $request['libelle']
        ]);
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
        $Typebiens = DB::table('typebiens')->where('typebien_id', $id);
        $this->validate($request, [
            'libelle' => 'required|string|max:191',
        ]);
        $Typebiens->update($request->all());
        return ['message' => 'Type de bien modifié avec succès'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Typebiens = DB::table('typebiens')->where('typebien_id', $id);
        $Typebiens->delete();
        return ['message' => 'Type de bien supprimé avec succès'];
    }
}
