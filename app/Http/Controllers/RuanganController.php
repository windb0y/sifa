<?php

namespace App\Http\Controllers;

use App\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class RuanganController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/ruangan",
     *     summary="list ruangan",
     *     @OA\Response(response="200", description="Data seluruh ruangan"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = Ruangan::all();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/ruangan/{id}",
     *     summary="detail ruangan",
     *     @OA\Response(response="200", description="Data ruangan"),
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
        $model = Ruangan::find($id);
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/ruangan",
     *     summary="save new ruangan",
     *     @OA\Response(response="200", description="success add ruangan"),
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
            'nama_ruangan' => 'required',
            'building_id' => 'required'
        ], $messages);

        $model = new Ruangan([
            'nama_ruangan' => $request->input('nama_ruangan'),
            'building_id' => $request->input('building_id')
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/ruangan/{id}",
     *     summary="update ruangan",
     *     @OA\Response(response="200", description="success update ruangan"),
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
            'nama_ruangan' => '',
            'building_id' => ''
        ], $messages);

        $model = Ruangan::find($id);

        $model->nama_ruangan = (!empty($request->input('nama_ruangan')) ? $request->input('nama_ruangan') : $model->nama_ruangan);
        $model->building_id = (!empty($request->input('building_id')) ? $request->input('building_id') : $model->building_id);
        
        $model->save();

        return response()->json([
            'code' => '200',
            'message' => 'Success',
            'data' => $model,
        ]);
    }

}