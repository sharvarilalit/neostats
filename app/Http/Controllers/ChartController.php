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
        $avgSize =0;
        return view('charts',compact('res','labels','data','avgSize'));
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
            //dd($response);
            $labels =[];
            $data=[];
            $res=[];
            $avgSize=0;
            $closetAstroid = '';
            if($response && !empty($response)){
                $res = (array)json_decode($response);
                 $res1 = (array)$res['near_earth_objects'];
                 $labels= array_keys($res1);
                 $typeTotals = array_map("count", $res1);

                 $totalNeos = array_values($res1);
                 $test =[];

                 foreach($totalNeos as $row){
                        $test=[...$test,...$row];
                 }
                 $clsatemp = $test[0]->close_approach_data[0]->epoch_date_close_approach;
                 $asteroid = $test[0];
                 $fastestAst =  $test[0]->close_approach_data[0]->relative_velocity->kilometers_per_hour;
                 $fastAsteroid = $test[0];

                 foreach ($test as $element) {
                    $avgSize +=$element->absolute_magnitude_h;
                    $cls = $element->close_approach_data[0]->epoch_date_close_approach;
                    $fas = $element->close_approach_data[0]->relative_velocity->kilometers_per_hour;

                    if($clsatemp> $cls){
                        $clsatemp= $cls;
                        $asteroid = $element;
                    }

                    if($fastestAst< $fas){
                        $fastestAst= $fas;
                        $fastAsteroid = $element;
                    }
                 }

                 $avgSize =$avgSize/count($test);
                 $closedAsteroid ='id='. $asteroid->id .',Distance='. $clsatemp;
                 $fastAsteroid ='id='. $fastAsteroid->id .',Speed='. $fastestAst;

                 //dd($asteroid->close_approach_data[0]->relative_velocity->kilometers_per_hour);
                 $data= array_values($typeTotals);
            }
            return view('charts',compact('res','labels','data','avgSize','closedAsteroid','fastAsteroid'));
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
