<?php

namespace App\Http\Controllers;

use App\Teleport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;

class TeleportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('teleport');
    }

    public function result(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            Teleport::create(['status' => 'pending', 'city_search' => $query]);
            $id = DB::getPdo()->lastInsertId();
            $url = "https://api.teleport.org/api/cities/?search=" . $query;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 5,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    // Set Here Your Requesred Headers
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
                Session::flash('error', 'API nie odpowiada! Sprobuj ponownie za moment.');
                return Redirect::to('teleport')->withErrors('API nie odpowiada! Sprobuj ponownie za moment.')->withInput();
            } else {
                $result = json_decode($response, true);  
                $date = date('Y-m-d H:i:s');
                if(empty($result["_embedded"]["city:search-results"]))
                {
                    DB::update('update teleports set query_result = ?, updated_at = ?, status = "failed" where id = ?',[$response, $date, $id]);
                    Session::flash('error', 'Brak wynikow!');
                    return Redirect::to('teleport')->withErrors('Brak wynikow!')->withInput();
                } else {
                    $geohash = array();
                    $georesult = array();
                    foreach($result["_embedded"]["city:search-results"] as $key) {
                        array_push($geohash, $key["_links"]["city:item"]["href"]);
                    }
                    foreach($geohash as $url) {
                        $geoId = substr($url, strpos($url, ":") + 1);
                        if (($pos = strpos($url, ":")) !== FALSE) { 
                            $geoId = substr($geoId, strpos($geoId, ":") + 1);
                            $geoId = substr($geoId, 0, -1);
                        }
                        Teleport::create(['status' => 'pending', 'city_search' => $geoId]);
                        $id2 = DB::getPdo()->lastInsertId();

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_TIMEOUT => 5,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                // Set Here Your Requesred Headers
                                'Content-Type: application/json',
                            ),
                        ));
                        $response2 = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);

                        if ($err) {
                            echo "cURL Error #:" . $err;
                            Session::flash('error', 'API nie odpowiada! Sprobuj ponownie za moment.');
                            return Redirect::to('teleport')->withErrors('API nie odpowiada! Sprobuj ponownie za moment.')->withInput();
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $result2 = json_decode($response2, true);
                            $geonameId = $result2["geoname_id"];
                            DB::update('update teleports set city_search = ?, query_result = ?, updated_at = ?, status = "success" where id = ?',[$geonameId, $response2, $date, $id2]);
                            array_push($georesult, $result2);
                        }
                    }
                    DB::update('update teleports set query_result = ?, updated_at = ?, status = "success" where id = ?',[$response, $date, $id]);
                    // dd($georesult);
                    return view('result')->withGeoresult($georesult);
                }
            }
        } else {
            Session::flash('error', 'Podaj nazwe miasta!');
            return Redirect::to('teleport')->withErrors('Podaj nazwe miasta!')->withInput();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teleport  $teleport
     * @return \Illuminate\Http\Response
     */
    public function show(Teleport $teleport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teleport  $teleport
     * @return \Illuminate\Http\Response
     */
    public function edit(Teleport $teleport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teleport  $teleport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teleport $teleport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teleport  $teleport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teleport $teleport)
    {
        //
    }
}
