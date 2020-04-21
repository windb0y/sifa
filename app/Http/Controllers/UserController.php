<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     summary="list user",
     *     @OA\Response(response="200", description="Data seluruh user"),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request",
     *     ), 
     * )
     */
    public function index()
    {     
       $data = User::select('name', 'email')->get();
       return response()->json([
        'code' => '200',
        'message' => 'success',
        'data' => $data,
        ]);
    }

     /**
     * @OA\Get(
     *     path="/user/{id}",
     *     summary="detail ruangan",
     *     @OA\Response(response="200", description="Data user"),
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
        $model = User::find($id);
        return response()->json([
            'code' => '200',
            'message' => 'success',
            'data' => $model->name,
        ], 200);
    }

    
    

}