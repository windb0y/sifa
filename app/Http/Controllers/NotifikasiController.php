<?php

namespace App\Http\Controllers;

use App\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Validator;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/notifikasi",
     *     summary="recent notifikasi",
     *     @OA\Response(response="200", description="Data 3 notifikasi terbaru"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = Notifikasi::orderBy('created_at', 'desc')->take(3)->get();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/notifikasi/{id}",
     *     summary="detail notifikasi",
     *     @OA\Response(response="200", description="Data notifikasi"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ), 
     * )
     */
    public function show($id)
    {
        $model = Notifikasi::find($id);
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/notifikasi",
     *     summary="save new notifikasi",
     *     @OA\Response(response="201", description="success add notifikasi"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ' :attribute harus diisi.',
        ];
        $this->validate($request, [
            'sensor_id' => 'required',
            'pesan' => 'required'
        ], $messages);

        $model = new Notifikasi([
            'sensor_id' => $request->input('sensor_id'),
            'pesan' => $request->input('pesan')
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/notifikasi/insert",
     *     summary="add notifikasi auto cek",
     *     @OA\Response(response="200", description="success add auto notifikasi"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ),
     *     
     * )
     */
    public function insert(){
        $sensor_id = 'XfZ0hBZdAqqANiK6jUMIw0CBq0JNTQJD';
        //$jsonsuhu = file_get_contents('http://blynk-cloud.com/'.$sensor_id.'/get/V5');
        $jsonsuhu = Http::get('http://blynk-cloud.com/'.$sensor_id.'/get/V5');
        //$objsuhu = json_decode($jsonsuhu);
        $objsuhu = $jsonsuhu->json();
        $suhu = $objsuhu['0'];
        //dd($suhu);

        $jsonasap = Http::get('http://blynk-cloud.com/'.$sensor_id.'/get/V4');
        $objasap = $jsonasap->json();
        $asap = $objasap['0'];

        $jsonthreshold = Http::get('http://blynk-cloud.com/'.$sensor_id.'/get/V2');
        $objhold = $jsonthreshold->json();
        $threshold = $objhold['0'];
        $suhuthreshold = ($threshold/399.960)+50;

        if(($suhu > $suhuthreshold) && ($asap == 1) ){
            $model = new Notifikasi([
                'sensor_id' => $sensor_id,
                'pesan' => 'sensor mendeteksi asap dan suhu diatas batas threshold'
            ]);
        }elseif ($suhu > $suhuthreshold) {
            $model = new Notifikasi([
                'sensor_id' => $sensor_id,
                'pesan' => 'sensor mendeteksi suhu diatas batas threshold'
            ]);
        }elseif ($asap == 1) {
            $model = new Notifikasi([
                'sensor_id' => $sensor_id,
                'pesan' => 'sensor mendeteksi asap'
            ]);
        }else {
            return response()->json(["success" => false, "message" => "no insert"], 400);
        }

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => "no insert"], 400);
        }

        

        
        //dd($suhuthreshold);

    }

}