<?php

namespace App\Http\Controllers;

use App\User;
use App\Pokemon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function create(Request $request){
        $result = array('status' => 0,'message' => '','error' => '');

        $validator = Validator::make($request->all(), [
            'nickname' => 'required|min:5|max:200',
            "listPokemon"    => "required|array|min:6|max:6",
        ]);

        if($validator->fails()){
            $result['status'] = 2;
            $result['message'] = $validator->messages();
            return response()->json($result,400);
        }

        $nickname = $request->nickname;
        $listPokemon = $request->listPokemon;
        
        $user = User::where('name',$nickname)->first();
        
        if (is_null($user)) {
            try{
                $userObj = User::create([
                    'name' => $nickname,
                ]);
                $user_id = $userObj->id;

                foreach ($listPokemon as $pokemon) {
                    Pokemon::create([
                        'user_id' => $user_id,
                        'pokemon_id' => $pokemon,
                    ]);
                }
                $result['status'] = 1;
                return response()->json($result,200);
            }
            catch (\Exception $e) {
                $result['message'] = "Lo sentimos, ocurrio un error.";
                $result['error'] = $e->getMessage();
                return response()->json($result);
            }
           
        }
        else{
            $result['message'] = "El nickname ya se encuentra registrado.";
            return response()->json($result,400);
        }
    }
}
