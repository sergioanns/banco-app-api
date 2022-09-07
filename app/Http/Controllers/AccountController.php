<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Account::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $account = new Account($request->all());
        if(!Account::where('identification', '=', $request->identification)->exists()){
            $saved = $account->save();
            if($saved){
                return response()->json(['success' => 'Cuenta creada.'], 200);
            } else {
                return response()->json(['error' => 'Algo salio mal, intente nuevamente.'], 404);
            }
           
        } else{
            return response()->json(['error' => 'Esta cuenta ya existe.'], 404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }


    public function transference(Request $request){
        $origin = Account::Where('identification', '=', $request->id_origin)->first();
        $destination = Account::Where('identification', '=', $request->id_destination)->first();

        if($origin && $destination){
            if($origin->account_balance < $request->account_balance){
                return response()->json(['error' => 'La cuenta de origen no cuenta con fondos suficientes.'], 422);
            } else {
                $origin_new_balance = $origin->account_balance - $request->account_balance;
                $destination_new_balance = $destination->account_balance + $request->account_balance;
                
                $origin->update([
                    "account_balance" =>  $origin_new_balance
                ]);
                $destination->update([
                    "account_balance" => $destination_new_balance
                ]);
                return response()->json(['success' => 'Transferencia exitosa.'], 200);
            }
        } else {
            return response()->json(['error' => 'Una de las cuentas no existe.'], 404);
        }
    }
}
