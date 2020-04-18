<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class BuildingController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/gedung",
     *     summary="list gedung",
     *     @OA\Response(response="200", description="Data seluruh gedung"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = Building::all();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/gedung/{id}",
     *     summary="detail gedung",
     *     @OA\Response(response="200", description="Data gedung"),
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
        $model = Building::find($id);
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/gedung",
     *     summary="save new gedung",
     *     @OA\Response(response="200", description="success add gedung"),
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
            'nama_gedung' => 'required'
        ], $messages);

        $model = new Building([
            'nama_gedung' => $request->input('nama_gedung')
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/gedung/{id}",
     *     summary="update gedung",
     *     @OA\Response(response="200", description="success update gedung"),
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
            'nama_gedung' => ''
        ], $messages);

        $model = Building::find($id);

        $model->nama_gedung = (!empty($request->input('nama_gedung')) ? $request->input('nama_gedung') : $model->nama_gedung);
       
        
        $model->save();

        return response()->json([
            'code' => '200',
            'message' => 'Success',
            'data' => $model,
        ]);
    }

}