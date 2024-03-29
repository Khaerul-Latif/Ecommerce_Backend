<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\PathItem(path="/api")
 */
class AlamatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/alamat",
     *     summary="Get all alamat",
     *     description="Get all alamat data",
     *     operationId="getalamat",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No alamat found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data Alamat yang ditemukan"
     *             )
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         type="http",
     *         scheme="bearer"
     *     )
     * )
     */
    public function index()
    {
        $alamat = Alamat::with('user')->get();
        return response()->json(['message' => 'Sukses', 'data' => $alamat]);
    }

    /**
     * @OA\Post(
     *     path="/api/alamat",
     *     summary="Create a new alamat",
     *     description="Create a new alamat with specified title and year",
     *     operationId="createalamat",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="alamat_lengkap", type="string", example="nama Alamat lengkap"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="alamat created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="alamat created successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="alamat not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="alamat not found")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat_lengkap'     => 'required',
        ], [
            'alamat_lengkap.required' => 'Alamat Lengkap Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $alamat = Alamat::create(array_merge($request->all(), [
            'user_id' => auth()->user()->id
        ]));

        if (!$alamat) {

            return response()->json([
                'message' => 'Data Alamat Gagal Ditambahkan',
            ], 422);
        }

        return response()->json([
            'message' => 'Data Alamat Berhasil Ditambahkan',
            'data' => $alamat,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/alamat/{id}",
     *     summary="Get alamat by id",
     *     description="Get alamat by id data",
     *     operationId="getalamatById",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the alamat to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No alamat found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data alamat yang ditemukan"
     *             )
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         type="http",
     *         scheme="bearer"
     *     )
     * )
     */
    public function show($id)
    {
        $alamat = Alamat::find($id);
        if (!$alamat) {
            return response()->json(['message' => 'Data Alamat Tidak Ditemukan']);
        }
        return response()->json(['message' => 'Sukses', 'data' => $alamat]);
    }

    /**
     * @OA\Put(
     *     path="/api/alamat/{id}",
     *     summary="update alamat",
     *     description="update alamat with specified title and year",
     *     operationId="updatealamat",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the alamat to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="alamat_lengkap", type="string", example="alamat"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="alamat updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="alamat updated successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="alamat not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="alamat not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $alamat = Alamat::find($id);
        if ($alamat) {

            $validator = Validator::make($request->all(), [
                'alamat_lengkap'     => 'required',
            ], [
                'alamat_lengkap.required' => 'Alamat Lengkap Tidak Boleh Kosong',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $aksi = $alamat->update(array_merge($request->all(), [
                'user_id' => auth()->user()->id
            ]));

            if (!$aksi) {

                return response()->json([
                    'message' => 'Data Alamat Gagal Diupdate',
                ], 422);
            }

            return response()->json([
                'message' => 'Data Alamat Berhasil Diupdate',
                'data' => $alamat,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Alamat Gagal Ditemukan',
            ], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/alamat/{id}",
     *     summary="Delete a alamat",
     *     description="Delete a alamat by ID",
     *     operationId="deletealamatById",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of alamat to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="alamat deleted successfully",
     *     )
     * )
     */
    public function destroy($id)
    {
        $alamat = Alamat::find($id);
        if ($alamat) {
            $aksi = $alamat->delete();
            if (!$aksi) {

                return response()->json([
                    'message' => 'Data Alamat Gagal Dihapus',
                ], 422);
            }

            return response()->json([
                'message' => 'Data Alamat Berhasil Dihapus',
                'data' => $alamat,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Alamat Gagal Ditemukan',
            ], 422);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/alamat/user/personal",
     *     summary="Get all alamat by user login",
     *     description="Get all alamat by user login data",
     *     operationId="getalamat by user login",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No alamat found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data Alamat yang ditemukan"
     *             )
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         type="http",
     *         scheme="bearer"
     *     )
     * )
     */
    public function getPersonal(){
        $user = auth()->user()->id;
        
        $alamat = Alamat::where('user_id', $user)->get();
        return response()->json([
                'message' => 'Berhasil Diakses',
                'data' => $alamat
            ], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/alamat/{id}/user",
     *     summary="Get alamat by user id",
     *     description="Get alamat by user id data",
     *     operationId="getalamatByUserId",
     *     tags={"Alamat"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the alamat to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No alamat found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data alamat yang ditemukan"
     *             )
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         type="http",
     *         scheme="bearer"
     *     )
     * )
     */
    public function getByUser($id)
    {
        $alamat = Alamat::where('user_id', $id)->get();
        return response()->json([
            'message' => 'Berhasil Diakses',
            'data' => $alamat
        ], 200);
    }
}
