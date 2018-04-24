<?php

namespace App\Http\Controllers;

use App\Teleport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

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
            $url = "https://api.teleport.org/api/cities/?search=" . $query;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
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
                return view('result');
            } else {
                // print_r(json_decode($response));
                dd(json_decode($response, true));
                // return view('result')->withResult(json_decode($response, true));
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
        //
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
