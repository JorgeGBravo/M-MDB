<?php

namespace App\Http\Controllers;

use App\Models\character;
use App\Models\data;
use App\Models\searchQuerys;
use App\Models\User;
use Couchbase\SearchQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;


class DataController extends Controller
{
    function postCharacter(Request $request)
    {
        //var_dump($request); exit;
        Log::info($request->input('urlLinks'));


        $data = new data();
        $data->json = json_encode($request->input('json'));
        $data->platform = $request->input('platform');
        $data->name = $request->input('name');
        $data->originalTitle = $request->input('originalTitle');
        $data->image = $request->input('image');
        $data->imageBackground = $request->input('imageBackground');
        $data->description = $request->input('description');
        $data->urlLinks = json_encode($request->input('urlLinks'));
        $data->creators = json_encode($request->input('creators'));
        $data->charComics = json_encode($request->input('charComics'));
        $data->dateComics = json_encode($request->input('dateComics'));
        $data->diamondCode = $request->input('diamondCode');
        $data->vote_average = $request->input('vote_average');
        $data->vote_count = $request->input('vote_count');
        $data->release_date = $request->input('release_date');
        $data->charSeries = json_encode($request->input('charSeries'));
        $data->idMarvelChar = $request->input('idMarvelChar');
        $data->idMarvelComic = $request->input('idMarvelComic');
        $data->idTmdb = $request->input('idTmdb');
        $data->save();

        $query = new searchQuerys();
        $query->searchQuery = $request->input('searchQuery');
        $query->save();
    }


    function checkCharacter($query){

           // $resultados = DB::select('select json from data where searchQuery = "' . $query . '" AND platform = "Marvel-Char"');
            //$resultados = DB::select('select json from data where platform = "Marvel-Char"' );
            $resultados = new SearchQuerys();
            $resultados = $query->querysSearchData();
            var_dump($resultados);

            if (count($resultados) > 0) {
                return $resultados;

            } else {
                return false;
            }
    }


    function insertSearchQuery($request){

        Log::info($request);

        $dataQuery = DB::select('select searchQuery from Search_querys where searchQuery = "' . $request->input('searchQuery') . '"');


        foreach ($dataQuery as &$value) {
            if ($value = $request->input('searchQuery')) {

                DB::select('insert into Search_querys (searchQuery) where  VALUE ("' . $request->input('searchQuery') . '")');


            }else{
            }
        }

    }

}


/*$dataQuery = DB::select('select searchQuery from data where searchQuery = "'.$query.'"');

foreach ($dataQuery as &$value){
    if ($value = $query){
        DB::select('insert into data (searchQuery) where  VALUE ("'.$query.'")');
        return $resultados;
    }else{
        return false;
    }*/


