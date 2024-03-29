<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/wishlist/",
     *     tags={"Wishlist"},
     *     summary="Get Wishlist",
     *     description="Get list of Wishlist data",
     *     operationId="getWishlist",
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
     *                     @OA\Property(property="produk_id", type="integer", example="2"),
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
     *                     @OA\Property(property="produk", type="object",
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nama", type="string", example="baju"),
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

        if ($user) {

            $user_id = $user->id;

        } else {

            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);

        }

        $data = Wishlist::with(['user', 'produk.gambar'])->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Sukses',
            'data' => $data
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/wishlist/{id}",
     *     tags={"Wishlist"},
     *     summary="Get Wishlist by ID",
     *     description="Get details of a specific wishlist item by its ID",
     *     operationId="getWishlistById",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the wishlist item to retrieve",
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
     *                 @OA\Property(property="produk_id", type="integer", example="1"),
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
     *                 @OA\Property(property="produk", type="object",
     *                     @OA\Property(property="id", type="integer", example="1"),
     *                     @OA\Property(property="nama", type="string", example="baju"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-17T02:36:12.000000Z"),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Wishlist item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item wishlist tidak ditemukan"),
     *         ),
     *     ),
     * )
     */

    public function show($id)
    {
        try {
            $data = Wishlist::with(['user', 'produk.gambar'])->findOrFail($id);

            return response()->json([
                'message' => 'Sukses',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/wishlist/",
     *     tags={"Wishlist"},
     *     summary="Add Product to Wishlist",
     *     description="Add a product to the user's wishlist",
     *     operationId="addProductToWishlist",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product ID to be added to wishlist",
     *         @OA\JsonContent(
     *             required={"produk_id"},
     *             @OA\Property(property="produk_id", type="integer", example="1")
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
     *                 @OA\Property(property="produk_id", type="integer", example="1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="produk_id", type="array",
     *                     @OA\Items(type="string", example="The produk_id field is required."),
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */

    // store

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ], [
            'produk_id.exists' => 'Produk id tidak ditemukan'
        ]);

        // pnegecekan user
        $user = Auth::user();

        if ($user) {
            $validatedData['user_id'] = $user->id;
        } else {
            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);
        }

        // pengecekan wishlist 
        $getWishlistDB = Wishlist::where('produk_id', $validatedData['produk_id'])->where('user_id', $validatedData['user_id'])->first();


        if ($getWishlistDB) {
            return response()->json(['message' => 'Wishlist sudah ada'], 400);

        } else {
            $validatedData['user_id'] = $user->id;

            $data = Wishlist::create($validatedData);
        }


        return response()->json([
            'message' => 'Berhasil tambah data',
            'data' => $data
        ], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/wishlist/{id}",
     *     tags={"Wishlist"},
     *     summary="Update Wishlist Item",
     *     description="Update a product quantity in the user's wishlist",
     *     operationId="updateWishlistItem",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the wishlist item to be updated",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="New quantity for the wishlist item",
     *         @OA\JsonContent(
     *             required={"produk_id"},
     *             @OA\Property(property="produk_id", type="integer", example="5")
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
     *                 @OA\Property(property="produk_id", type="integer", example="1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-16T20:09:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-16T20:20:28.000000Z"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Wishlist item not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Item wishlist tidak ditemukan"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="produk_id", type="array",
     *                     @OA\Items(type="string", example="The produk_id field must be an integer."),
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'produk_id' => 'required|exists:produk,id'
            ], [
                'produk_id.exists' => 'Produk id tidak ditemukan'
            ]);



            // pnegecekan user
            $user = Auth::user();

            if ($user) {
                $validatedData['user_id'] = $user->id;
            } else {
                return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);
            }

            // pengecekan wishlist 
            $getWishlistDB = Wishlist::where('produk_id', $validatedData['produk_id'])->where('user_id', $validatedData['user_id'])->first();


            if ($getWishlistDB) {
                return response()->json(['message' => 'Wishlist sudah ada'], 400);

            } else {
                $validatedData['user_id'] = $user->id;
                $data = Wishlist::findOrFail($id);
                $data->update($validatedData);
            }


            return response()->json([
                'message' => 'Berhasil update data',
                'data' => $data
            ], 201);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate data / Produk id tidak ditemukan'], 500);
        }



    }

    /** 
     * @OA\Delete(
     *     path="/api/wishlist/{id}",
     *     tags={"Wishlist"},
     *     summary="Delete existing Wishlist",
     *     description="Delete an existing Wishlist data",
     *     operationId="deleteWishlist",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Wishlist to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Wishlist deleted successfully",
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
            $data = Wishlist::findOrFail($id);
            $data->delete();

            return response()->json(['message' => 'Berhasil hapus data'], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }

}
