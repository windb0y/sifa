<?php

namespace App\Http\Controllers;

use App\Cekdata;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;

class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/cekdatas",
     *     summary="list data perangkats",
     *     @OA\Response(response="200", description="Data dari perangkats"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */

    public function index()
    {     
       $data = Cekdata::all();
       return response()->json([
        'code' => '200',
        'message' => 'Success',
        'data' => $data,
        ]);
    }

    public function store(Request $request)
    {

       
       $data = new Cekdata();
       $data->sensor_id= $request->sensor_id;
       $data->room_temperature = $request->room_temperature;
       $data->room_smoke= $request->room_smoke;
       
       $data->save();
       return response()->json($data, 200);
       
       
       /*
       $sensor_id= $request->sensor_id;
       $room_temperature = $request->room_temperature;
       $room_smoke= $request->room_smoke;


       $data = [
           'sensor_id' => $sensor_id,
           'room_temperature' => $room_temperature,
           'room_smoke' => $room_smoke,
       ]
       
       $insert = Cekdata::create($data);

       if ($insert) {
        $out  = [
            "message" => "success_insert_data",
            "results" => $data,
            "code"  => 200
        ];
       } else {
        $out  = [
            "message" => "vailed_insert_data",
            "results" => $data,
            "code"   => 404,
        ];
       }

        return response()->json($out, $out['code']);
        */
    }

    public function insert()
    {
        $sensor_id = 'XfZ0hBZdAqqANiK6jUMIw0CBq0JNTQJD';

        $jsonsuhu = file_get_contents('http://blynk-cloud.com/'.$sensor_id.'/get/V5');
        $objsuhu = json_decode($jsonsuhu);
        $suhu = $objsuhu['0'];

        $jsonasap = file_get_contents('http://blynk-cloud.com/'.$sensor_id.'/get/V4');
        $objasap = json_decode($jsonasap);
        $asap = $objasap['0'];


        $model = new Cekdata([
            'sensor_id' => $sensor_id,
            'room_temperature' => $suhu,
            'room_smoke' => $asap
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }


    }

    


    
}
