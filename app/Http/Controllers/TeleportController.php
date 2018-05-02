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

    public function autocomplete(Request $request) {
        $query = $request->city;
        if ($query) {
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

            if ($err || $response == false) {
                echo "cURL Error #:" . $err;
            } else {
                $result = json_decode($response, true);  
                $date = date('Y-m-d H:i:s');
                if(empty($result["_embedded"]["city:search-results"]))
                {
                } else {
                    $georesult = array();
                    foreach($result["_embedded"]["city:search-results"] as $key) {
                        array_push($georesult, $key["matching_full_name"]);
                    }
                    return $georesult;
                }
            }
        }
    }

    public function result(Request $request)
    {
        $query = $request->input('city-name');
        if ($query) {
            try {
                Teleport::create(['status' => 'pending', 'city_search' => $query]);
                $query = preg_replace('/\s+/', ' ', $query);
                $query = ltrim($query);
                $query = str_replace(' ', '%20', $query);
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

                if ($err || $response == false) {
                    echo "cURL Error #:" . $err;
                    $date = date('Y-m-d H:i:s');
                    DB::update('update teleports set updated_at = ?, status = "failed" where id = ?',[$date, $id]);
                    Session::flash('error', 'API nie odpowiada! Spróbuj ponownie za moment.');
                    return Redirect::to('teleport')->withErrors('API nie odpowiada! Spróbuj ponownie za moment.');
                } else {
                    $result = json_decode($response, true);  
                    $date = date('Y-m-d H:i:s');
                    if(empty($result["_embedded"]["city:search-results"]))
                    {
                        DB::update('update teleports set query_result = ?, updated_at = ?, status = "failed" where id = ?',[$response, $date, $id]);
                        Session::flash('error', 'Brak wyników!');
                        return Redirect::to('teleport')->withErrors('Brak wyników!');
                    } else {
                        $geohash = array();
                        $georesult = array();
                        foreach($result["_embedded"]["city:search-results"] as $key) {
                            array_push($geohash, $key["_links"]["city:item"]["href"]);
                        }
                        $count = count($geohash);
                        $i = 0;
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

                            if ($err || $response2 == false) {
                                $date = date('Y-m-d H:i:s');
                                DB::update('update teleports set updated_at = ?, status = "failed" where id = ?',[$date, $id2]);
                                $i++;
                            } else {
                                $date = date('Y-m-d H:i:s');
                                $result2 = json_decode($response2, true);
                                $geonameId = $result2["geoname_id"];
                                DB::update('update teleports set city_search = ?, query_result = ?, updated_at = ?, status = "success" where id = ?',[$geonameId, $response2, $date, $id2]);
                                array_push($georesult, $result2);
                            }
                            if($i == $count) {
                                $date = date('Y-m-d H:i:s');
                                DB::update('update teleports set updated_at = ?, status = "failed" where id = ?',[$date, $id]);
                                Session::flash('error', 'API nie odpowiada! Spróbuj ponownie za moment.');
                                return Redirect::to('teleport')->withErrors('API nie odpowiada! Spróbuj ponownie za moment.');
                            }
                        }
                        
                        DB::update('update teleports set query_result = ?, updated_at = ?, status = "success" where id = ?',[$response, $date, $id]);
                        return view('result')->withGeoresult($georesult);
                    }
                }
            } catch (\PDOException $e) {
                if ((int)$e->getCode() == 22001) {
                    Session::flash('error', 'Wprowadzona nazwa jest za długa! Maksymalna długość to 25 znaków.');
                    return Redirect::to('teleport')->withErrors('Wprowadzona nazwa jest za długa! Maksymalna dlługość to 25 znaków.');
                } else {
                    Session::flash('error', 'Baza danych nie odpowiada! Spróbuj ponownie za moment.<br>Kod błędu: ' .(int)$e->getCode());
                    return Redirect::to('teleport')->withErrors('Baza danych nie odpowiada! Spróbuj ponownie za moment. Kod błędu: ' .(int)$e->getCode());
                }
            }
        } else {
            Session::flash('error', 'Podaj nazwe miasta!');
            return Redirect::to('teleport')->withErrors('Podaj nazwe miasta!');
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
