<?php

namespace App\Http\Controllers;

use App\Models\character;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;


class DataController extends Controller
{
    function postCharacter(Request $request){
        //var_dump($request); exit;

        Log::info($request->input('json'));

        $character = new character();
        $character->json =  json_encode($request-> input('json'));
        $character->idMarvel =  $request-> input('idMarvel');
        $character->platform =  $request-> input('platform');
        $character->charName =  $request-> input('charName');
        $character->charImage =  $request-> input('charImage');
        $character->searchQuery =  $request-> input('searchQuery');
        $character->urlLinks =  json_encode($request-> input('urlLinks'));
        $character->creators =  json_encode($request-> input('creators'));
        $character->comics =  json_encode($request-> input('comics'));
        $character->series =  json_encode($request-> input('series'));
        $character->charDescription =  $request-> input('charDescription');
        $character->save();
    }


    function checkCharacter($query){

        $resultados = DB::select('select json from characters where searchQuery = "'.$query.'"');

        if(count($resultados)>0){
            return $resultados;
        }else{
            return false;
        }
    }
}

