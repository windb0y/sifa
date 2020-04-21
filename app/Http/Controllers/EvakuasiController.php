<?php

namespace App\Http\Controllers;

use App\Evakuasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class EvakuasiController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/evakuasi",
     *     summary="list evakuasi ruangan",
     *     @OA\Response(response="200", description="Data seluruh evakuasi ruangan"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = Evakuasi::all();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/evakuasi/{ruangan_id}",
     *     summary="detail evakuasi ruangan tertentu",
     *     @OA\Response(response="200", description="Data evakuasi ruangan tertentu"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ),
     *     @OA\Parameter(
     *         name="ruangan_id",
     *         in="path",
     *         required=true,
     *     ), 
     * )
     */
    public function show($ruangan_id)
    {
        $model = Evakuasi::where('ruangan_id', $ruangan_id)->orderBy('langkah', 'asc')->get();
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/evakuasi",
     *     summary="save new evakuasi ruangan",
     *     @OA\Response(response="200", description="success add evakuasi ruangan"),
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
            'ruangan_id' => 'required',
            'langkah' => 'required',
            'pesan' => 'required'
        ], $messages);

        $model = new Evakuasi([
            'ruangan_id' => $request->input('ruangan_id'),
            'langkah' => $request->input('langkah'),
            'pesan' => $request->input('pesan')
        ]);

        if($model->save()){
            return response()->json(["success" => true, "message"=>"Success",'data'=>$model], 201);
        }else{
            return response()->json(["success" => false, "message" => $messages], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/evakuasi/{id}",
     *     summary="update evakuasi ruangan",
     *     @OA\Response(response="200", description="success update evakuasi ruangan"),
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
            'ruangan_id' => '',
            'langkah' => '',
            'pesan' => ''
        ], $messages);

        $model = Evakuasi::find($id);

        $model->ruangan_id = (!empty($request->input('ruangan_id')) ? $request->input('ruangan_id') : $model->ruangan_id);
        $model->langkah = (!empty($request->input('langkah')) ? $request->input('langkah') : $model->langkah);
        $model->pesan = (!empty($request->input('pesan')) ? $request->input('pesan') : $model->pesan);
        
        $model->save();

        return response()->json([
            'code' => '200',
            'message' => 'Success',
            'data' => $model,
        ]);
    }

}