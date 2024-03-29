<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Transaksi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Promo"
 * )
 */

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/promo",
     *     tags={"Promo"},
     *     summary="Get all Promos",
     *     description="Get details of all Promo items",
     *     operationId="getAllPromos",
     *   security={{ "bearerAuth": { }}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="kode", type="string", example="ABC123"),
     *                 @OA\Property(property="diskon", type="integer", example="10"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *                 @OA\Property(property="created-at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated-at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $promos = Promo::all();
        return response()->json($promos);
    }

    /**
     * @OA\Get(
     *     path="/api/check-promo",
     *     tags={"Promo"},
     *     operationId="checkPromo",
     *     security={{ "bearerAuth": { }}},
     *     summary="Process checkPromo",
     *     description="Process checkPromo for Transaksi",
     *     @OA\Parameter(
     *         name="kode",
     *         in="query",
     *         description="Check Kode Promo",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kode Promo Belum Terpakai"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="kode", type="string", example="KODE"),
     *                     @OA\Property(property="diskon", type="integer", example=10),
     *                     @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-20 20:09:01"),
     *                     @OA\Property(property="end_date", type="string", format="date-time",example="2024-03-29 20:09:01"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kode Promo Telah Terpakai")
     *         )
     *     ),
     *     @OA\Response(
     *         response=410,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kode Promo Tidak Tersedia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=411,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Promo terlewat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Promo belum berlaku")
     *         )
     *     ),
     * )
     */
    public function checkPromo(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);
        }

        $user_id = $user->id;

        $title = $request->query('kode');
        $promo = Promo::where('kode', $title)->first();

        if (!$promo) {
            return response()->json(['message' => 'Kode Promo Tidak Tersedia'], 410);
        }

        $tanggalPromoLewat = Carbon::parse($promo->end_date);
        $tanggalPromoMulai = Carbon::parse($promo->start_date); // Anda perlu mengganti 'tanggal' dengan kolom tanggal pada model Promo

        if ($tanggalPromoLewat->isPast()) {
            return response()->json(['message' => 'Promo terlewat'], 411);
        }elseif ($tanggalPromoMulai->isFuture()) {
            return response()->json(['message' => 'Promo belum berlaku'], 412);
        }

        $transaksi = Transaksi::where('kode_promo', $title)
            ->where('user_id', $user_id)
            ->first();

        if ($transaksi) {
            return response()->json(['message' => 'Kode Promo Telah Terpakai'], 409);
        } else {
            return response()->json([
                'message' => 'Kode Promo Belum Dipakai',
                'data' => Promo::where('kode', $title)->first()
            ], 200);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/api/promo",
     *     tags={"Promo"},
     *     summary="Create a new Promo",
     *     description="Create a new Promo item",
     *     operationId="createPromo",
     *    security={{ "bearerAuth": { }}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"kode", "diskon", "start_date", "end_date"},
     *             @OA\Property(property="kode", type="string", example="ABC123"),
     *             @OA\Property(property="diskon", type="integer", example="10"),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-16 20:09:01")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Promo created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promo created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="kode", type="string", example="ABC123"),
     *                 @OA\Property(property="diskon", type="integer", example="10"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-17T20:09:01.000000Z"),
     *                 @OA\Property(property="created-at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated-at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data supplied",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode' => 'required|string|unique:promo',
            'diskon' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // if ($request->fails()) {
        //     return response()->json([
        //         "errors" => "Nama Token Sudah di Gunakan"
        //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $promo = Promo::create($validate);

        return response()->json($promo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/promo/{id}",
     *     tags={"Promo"},
     *     summary="Get Promo by ID",
     *     description="Get details of a specific Promo item by its ID",
     *     operationId="getPromoById",
     *    security={{ "bearerAuth": { }}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Promo item to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sukses"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="kode", type="string", example="ABC123"),
     *                 @OA\Property(property="diskon", type="integer", example="10"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-17T20:09:01.000000Z"),
     *                 @OA\Property(property="created-at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated-at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promo item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item Promo tidak ditemukan"),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        $promo = Promo::findOrFail($id);
        if (!$promo) {
            response()->json([
                "error" => "Promo tidak ditemukan"
            ], 404);
        }
        return response()->json($promo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/api/promo/{id}",
     *     tags={"Promo"},
     *     summary="Update Promo item by ID",
     *     description="Update Promo item by its ID",
     *     operationId="updatePromo",
     *    security={{ "bearerAuth": { }}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Promo item to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *                 @OA\JsonContent(
     *             type="object",
     *                 @OA\Property(property="kode", type="string", example="ABC123"),
     *                 @OA\Property(property="diskon", type="integer", example="10"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-16 20:09:01")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *                      @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sukses"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="kode", type="string", example="ABC123"),
     *                 @OA\Property(property="diskon", type="integer", example="10"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-03-16 20:09:01"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promo item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promo tidak ditemukan"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid"),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode' => 'required|string|unique:promo,kode,' . $id,
            'diskon' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $promo = Promo::findOrFail($id);

        if (!$promo) {
            response()->json([
                "error" => "Promo tidak ditemukan"
            ], 404);
        }
        $promo->update($validatedData);

        return response()->json($promo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/promo/{id}",
     *     tags={"Promo"},
     *     summary="Delete Promo item by ID",
     *     description="Delete Promo item by its ID",
     *     operationId="deletePromo",
     *    security={{ "bearerAuth": { }}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Promo item to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful response",
     *      @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promo berhasil dihapus"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promo item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item Promo tidak ditemukan"),
     *         ),
     *     ),
     * )
     */
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return response()->json([
            "message" => "Promo berhasil dihapus"
        ], 204);
    }
}
