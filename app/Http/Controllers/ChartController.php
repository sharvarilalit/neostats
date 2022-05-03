<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
class ChartController extends Controller
{
    public function index()
    {

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        // $response = $this->guzzleGet( $startDate,$endDate);
        // $res = (array)json_decode($response);
        
        // $labels =[];
        // $data=[];
        // if($res && !empty($res)){
        //      $res1 = (array)$res['near_earth_objects'];
        //      $labels= array_keys($res1);
        //      $typeTotals = array_map("count", $res1);
        //      $data= array_values($typeTotals);
        // }
        $res="";
        $labels=[];
        $data=[];
        return view('charts',compact('res','labels','data'));
    }

    public function filter(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
       
        if ($validator->fails()) {
            return redirect(route('chart.list'))->withInput()->withErrors($validator);
        }
        else{
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            
            $response = $this->guzzleGet( $startDate,$endDate);
            $res = (array)json_decode($response);
            
            $labels =[];
            $data=[];
            if($res && !empty($res)){
                 $res1 = (array)$res['near_earth_objects'];
                 $labels= array_keys($res1);
                 $typeTotals = array_map("count", $res1);
                 $data= array_values($typeTotals);
            }
            return view('charts',compact('res','labels','data'));
         }
           
    }

    // public function guzzleGet($start_date,$end_date){

    //     $res =Http::get('https://api.nasa.gov/neo/rest/v1/feed', [
    //         'start_date' => $start_date,
    //         'end_date' => $end_date,
    //         'detailed'=>'false',
    //         'api_key' => 'o4fHBcoxFPlqz4rkWOwJEMqge53NXhPpe4rTGskg'
    //     ]);

    //     return $res->getBody();
    // }

    public function guzzleGet($start_date,$end_date)
    {
        $client = new \GuzzleHttp\Client();
        try {
        $request = $client->request('GET','https://api.nasa.gov/neo/rest/v1/feed', [
            'query' => [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'detailed'=>'false',
                'api_key' => 'o4fHBcoxFPlqz4rkWOwJEMqge53NXhPpe4rTGskg'
            ]
        ]);
               return $request->getBody();

        } catch (ClientException $e) {
                //echo Psr7\Message::toString($e->getRequest());
                //echo Psr7\Message::toString($e->getResponse());
                return [];
        }
    }
}
