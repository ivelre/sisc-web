<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarioModel;

class apiController extends Controller
{
    public function login(Request $req){
    	$response = new \stdClass;
    	$response -> status = false;
    	$response -> message = 'Tus credenciales no son las correctas para ingresar.';
    	$user = usuarioModel::where('email',$req -> email)->first();
    	if($user){
				if(password_verify($req -> password, $user -> contrasena)){
		    	$response -> status = true;
		    	$response -> message = 'Haz iniciado sesión correctamente.';
					return response()->json($response);
				}
			}
    	return response()->json($response);
    }

    public function saveEvidence(Request $req) {
		$file = $req->file('img');
		$evidence = $file -> getClientOriginalName();
		$evidence = rand(0, 99999) . '_' . rand(0, 99999) . '_' . rand(0, 99999) . '_' . rand(0, 99999) . '.' . $file->getClientOriginalExtension();
		//dd(\File::get($file));
		\Storage::disk('evidences')->put($evidence, \File::get($file));

    	$response = new \stdClass;
    	$response -> status = true;
    	$response -> img = $evidence;

		return response()->json($response);
	}
}
