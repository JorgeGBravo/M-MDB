<?php

namespace App\Http\Controllers;

use App\Models\character;
use App\Models\data;
use App\Models\Searchquery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;
use App\Models\QueryData;

class DataController extends Controller
{
    function postCharacter(Request $request)
    {
        $consultIdPlatform = DB::select('select IdPlatform from data where IdPlatform = "'.$request->input('idPlatform').'"');

        $idQuerySearchQuery = DB::select('select idQueries from searchqueries where searchQuery = "'.$request->input('searchQuery').'"');

        $querySearch = $request->input('searchQuery');


        if (count($idQuerySearchQuery) == 0){
            $query = new searchquery();
            $query->searchQuery = $querySearch;
            $query->save();
        }

        if (count($consultIdPlatform) > 0){
            //Actualizacion json.

            $jsonEncode = json_encode($request->input('json'));
            $jsonEncode = str_replace("'", "\'", $jsonEncode);
            DB::select('update data set json = \''.$jsonEncode.'\' where IdPlatform = "'.$request->input('idPlatform').'"');

        }else{

            $data = new data();
            $data->json = json_encode($request->input('json'));
            $data->idPlatform = $request->input('idPlatform');
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
            $data->save();

            $idQuery = DB::select('select idQueries from searchqueries where searchQuery = "'.$request->input('searchQuery').'"');

            $datId = DB::select('select idData from data where idPlatform =  "'.$data->idPlatform.'"');
            $queryData = new QueryData();
            $queryData->idData = $datId[0]->idData;
            $queryData->idQueries = $idQuery[0]->idQueries;
            $queryData->save();

        }
    }


    function checkCharacter($query)
    {


        $resultados = DB::select('select json from data INNER JOIN querydata ON data.idData = querydata.idData INNER JOIN searchqueries ON searchqueries.idQueries = querydata.idQueries
                        where searchqueries.searchQuery = "'. $query .'" AND platform = "Marvel-Char" AND data.created_at  BETWEEN  "'.Carbon::now()->subDays(10).'" AND "'.Carbon::now().'"');


        if (count($resultados) > 0)
        {
            return $resultados;
        } else
        {
            return false;
        }
    }
}



