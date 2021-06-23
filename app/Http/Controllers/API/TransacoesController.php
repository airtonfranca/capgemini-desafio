<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Transacoes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacoesController extends Controller
{

    public function get($id)
    {
        return Transacoes::select('id', 'valor', 'tipo', 'created_at')->where('user_id', $id)->orderBy('created_at', 'asc')->get();
    }

    public function depositar(Request $request)
    {
        $this->insereTransacao($request);

        $user = User::where('id', $request->user_id)->first();
        $user->saldo = $user->saldo + $request->valor;
        $user->save();
    }

    public function sacar(Request $request)
    {
        $this->insereTransacao($request);

        $user = User::where('id', $request->user_id)->first();
        if($request->valor <= $user->saldo){
            $user->saldo = $user->saldo - $request->valor;
            $user->save();
        }
    }

    protected function insereTransacao(Request $request) {

        DB::table('transacoes')->insert([
            'user_id' => $request->user_id,
            'tipo' => $request->tipo,
            'valor' => $request->valor,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

}
