<?php

namespace App\Http\Controllers;

use App\Models\character;
use App\Models\data;
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

        $data = new data();
        $data->json =  json_encode($request-> input('json'));
        $data->idMarvelChar =  $request-> input('idMarvelChar');
        $data->idMarvelComic =  $request-> input('idMarvelComic');
        $data->idTmdb =  $request-> input('idTmdb');
        $data->platform =  $request-> input('platform');
        $data->name =  $request-> input('name');
        $data->originalTitle =  $request-> input('originalTitle');
        $data->image =  $request-> input('image');
        $data->imageBackground =  $request-> input('imageBackground');
        $data->description =  $request-> input('description');
        $data->urlLinks =  json_encode($request-> input('urlLinks'));
        $data->creators =  json_encode($request-> input('creators'));
        $data->charComics =  json_encode($request-> input('charComics'));
        $data->dateComics =  json_encode($request-> input('dateComics'));
        $data->diamondCode =  $request-> input('diamondCode');
        $data->vote_average =  $request-> input('vote_average');
        $data->vote_count =  $request-> input('vote_count');
        $data->release_date =  $request-> input('release_date');
        $data->charSeries =  json_encode($request-> input('charSeries'));
        $data->searchQuery =  $request-> input('searchQuery');
        $data->save();
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

