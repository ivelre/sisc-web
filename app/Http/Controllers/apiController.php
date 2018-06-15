<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarioModel;
use App\Models\evidenciaModel;

class apiController extends Controller
{
    public function login(Request $req){
    	$response = new \stdClass;
    	$response -> status = false;
    	$response -> message = 'Tus credenciales no son las correctas para ingresar.';
    	$response -> usuario_id = null;
			$response -> step = 1;
    	$user = usuarioModel::where('email',$req -> casilla)->first();
    	if($user){
				if(password_verify($req -> password, $user -> contrasena)){
					$evidencias  = evidenciaModel::where('id_usuario',$user -> id)->where('id_tipo_evidencia',2)->first();
					if($evidencias){
						$response -> step = 2;
						$evidencias  = evidenciaModel::where('id_usuario',$user -> id)->where('id_tipo_evidencia',5)->first();
						if($evidencias)
							$response -> step = 3;
					}
		    	$response -> status = true;
		    	$response -> message = 'Haz iniciado sesion correctamente.';
		    	$response -> usuario_id = $user -> id;
		    	$response -> tipo_usuario_id = $user -> id_rol;
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
