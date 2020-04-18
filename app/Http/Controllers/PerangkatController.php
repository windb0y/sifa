<?php

namespace App\Http\Controllers;

use App\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PerangkatController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/perangkat",
     *     summary="list perangkat",
     *     @OA\Response(response="200", description="Data seluruh ruangan"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = Perangkat::all();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/perangkat/{id}",
     *     summary="detail perangkat",
     *     @OA\Response(response="200", description="Data perangkat"),
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
        $model = Perangkat::find($id);
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/perangkat",
     *     summary="save new perangkat",
     *     @OA\Response(response="201", description="success add perangkat"),
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
            'control' => 'required',
            'threshold' => 'required',
            'ruangan_id' => 'required'
        ], $messages);

        $model = new Perangkat([
            'sensor_id' => $request->input('sensor_id'),
            'control' => $request->input('control'),
            'threshold' => $request->input('threshold'),
            'ruangan_id' => $request->input('ruangan_id')
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/perangkat/{id}",
     *     summary="update perangkat",
     *     @OA\Response(response="200", description="success update perangkat"),
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
    public function update(Request $request, $id){
        $messages = [
            'required' => ' :attribute harus diisi.',
        ];

        $this->validate($request, [
            'sensor_id' => 'required',
            'control' => 'required',
            'threshold' => 'required',
            'ruangan_id' => 'required'
        ], $messages);

        $model = Perangkat::find($id);

        $model->sensor_id = (!empty($request->input('sensor_id')) ? $request->input('sensor_id') : $model->sensor_id);
        $model->control = (!empty($request->input('control')) ? $request->input('control') : $model->control);
        $model->threshold = (!empty($request->input('threshold')) ? $request->input('threshold') : $model->threshold);
        $model->ruangan_id = (!empty($request->input('ruangan_id')) ? $request->input('ruangan_id') : $model->ruangan_id);
        
        $model->save();

        $sensor_id = $model->sensor_id;
        $threshold = $model->threshold;

        $jsonthreshold = file_get_contents('http://blynk-cloud.com/'.$sensor_id.'/update/V2?value='.$threshold);


        return response()->json([
            'code' => '200',
            'message' => 'Success',
            'data' => $model,
        ]);
    }

}