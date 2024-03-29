<?php

namespace App\Http\Controllers;

use App\Models\GambarProduk;
use App\Models\Keranjang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/keranjang/",
     *     tags={"Keranjang"},
     *     summary="Get Keranjang",
     *     description="Get list of Keranjang data",
     *     operationId="getKeranjang",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sukses"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example="16"),
     *                     @OA\Property(property="user_id", type="integer", example="2"),
     *                     @OA\Property(property="variant_id", type="integer", example="1"),
     *                     @OA\Property(property="jumlah", type="integer", example="2"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example="2"),
     *                         @OA\Property(property="name", type="string", example="yuyun"),
     *                         @OA\Property(property="email", type="string", example="yuyun@gmail.com"),
     *                         @OA\Property(property="email_verified_at", type="string", format="date-time", example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example=null),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example=null),
     *                     ),
     *                     @OA\Property(property="variant", type="object",
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="produk_id", type="integer", example="1"),
     *                         @OA\Property(property="warna", type="string", example="Red"),
     *                         @OA\Property(property="ukuran", type="string", example="Medium"),
     *                         @OA\Property(property="harga", type="integer", example="10.00"),
     *                         @OA\Property(property="stok", type="integer", example="100"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */


    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);
        }

        $user_id = $user->id;

        $data = Keranjang::with(['user', 'variant.produk.gambar'])->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Sukses',
            'data' => $data
        ], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/keranjang/{id}",
     *     tags={"Keranjang"},
     *     summary="Get Keranjang by ID",
     *     description="Get details of a specific Keranjang item by its ID",
     *     operationId="getKeranjangById",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Keranjang item to retrieve",
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
     *                 @OA\Property(property="id", type="integer", example="16"),
     *                 @OA\Property(property="user_id", type="integer", example="2"),
     *                 @OA\Property(property="variant_id", type="integer", example="1"),
     *                 @OA\Property(property="jumlah", type="integer", example="2"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example="2"),
     *                     @OA\Property(property="name", type="string", example="yuyun"),
     *                     @OA\Property(property="email", type="string", example="yuyun@gmail.com"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example=null),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example=null),
     *                 ),
     *                 @OA\Property(property="variant", type="object",
     *                     @OA\Property(property="id", type="integer", example="1"),
     *                     @OA\Property(property="produk_id", type="integer", example="1"),
     *                     @OA\Property(property="warna", type="string", example="Red"),
     *                     @OA\Property(property="ukuran", type="string", example="Medium"),
     *                     @OA\Property(property="harga", type="integer", example="10.00"),
     *                     @OA\Property(property="stok", type="integer", example="100"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Keranjang item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item Keranjang tidak ditemukan"),
     *         ),
     *     ),
     * )
     */

    public function show($id)
    {
        try {
            $data = Keranjang::with(['user', 'variant.produk.gambar'])->findOrFail($id);

            return response()->json([
                'message' => 'Sukses',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        }
    }




    /**
     * @OA\Post(
     *     path="/api/keranjang/",
     *     tags={"Keranjang"},
     *     summary="Add Product to Keranjang",
     *     description="Add a product to the user's Keranjang",
     *     operationId="addProductToKeranjang",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product ID to be added to Keranjang",
     *         @OA\JsonContent(
     *             required={"variant_id"},
     *             @OA\Property(property="variant_id", type="integer", example="1"),
     *             @OA\Property(property="jumlah", type="integer", example="10"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Berhasil tambah data"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example="16"),
     *                 @OA\Property(property="user_id", type="integer", example="2"),
     *                 @OA\Property(property="variant_id", type="integer", example="1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="variant_id", type="array",
     *                     @OA\Items(type="string", example="The variant_id field is required."),
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */

    // store

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'variant_id' => 'required|exists:variant,id',
                'jumlah' => 'required',
            ],
            [
                'variant_id.exists' => 'Variant id sudah ada'
            ]
        );

        $user = Auth::user();

        if ($user) {

            $validatedData['user_id'] = $user->id;

        } else {

            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);

        }

        // pengecekan Keranjang
        $getKeranjangDB = Keranjang::where('variant_id', $validatedData['variant_id'])->where('user_id', $validatedData['user_id'])->first();

        if ($getKeranjangDB) {

            $validatedData['jumlah'] = $getKeranjangDB['jumlah'] + $request->jumlah;
            $data = Keranjang::findOrFail($getKeranjangDB['id']);
            $data->update($validatedData);

        } else {
            $validatedData['user_id'] = $user->id;

            $data = Keranjang::create($validatedData);
        }

        return response()->json([
            'message' => 'Berhasil tambah data',
            'data' => $data
        ], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/keranjang/{id}",
     *     tags={"Keranjang"},
     *     summary="Update Keranjang Item",
     *     description="Update a product quantity in the user's Keranjang",
     *     operationId="updateKeranjangItem",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Keranjang item to be updated",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="New quantity for the Keranjang item",
     *         @OA\JsonContent(
     *             required={"variant_id"},
     *             @OA\Property(property="variant_id", type="integer", example="5"),
     *               required={"jumlah"},
     *             @OA\Property(property="jumlah", type="integer", example="5"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Berhasil memperbarui data"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example="16"),
     *                 @OA\Property(property="user_id", type="integer", example="2"),
     *                 @OA\Property(property="variant_id", type="integer", example="1"),
     *                 @OA\Property(property="jumlah", type="integer", example="5"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Keranjang item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item Keranjang tidak ditemukan"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="jumlah", type="array",
     *                     @OA\Items(type="string", example="The jumlah field must be an integer."),
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate(
                [
                    'variant_id' => 'required|exists:variant,id',
                    'jumlah' => 'required',
                ],
                [
                    'variant_id.exists' => 'Variant id sudah ada'
                ]
            );

            $data = Keranjang::findOrFail($id);

            $data->update($validatedData);

            return response()->json([
                'message' => 'Berhasil update data',
                'data' => $data
            ], 201);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate data / ID variant tidak ditemukan'], 500);
        }



    }

    /**
     * @OA\Delete(
     *     path="/api/keranjang/{id}",
     *     tags={"Keranjang"},
     *     summary="Delete existing Keranjang",
     *     description="Delete an existing Keranjang data",
     *     operationId="deleteKeranjang",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Keranjang to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Keranjang deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil hapus data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="ID tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan saat menghapus data")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        try {
            $data = Keranjang::findOrFail($id);
            $data->delete();

            return response()->json(['message' => 'Berhasil hapus data'], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }

}
