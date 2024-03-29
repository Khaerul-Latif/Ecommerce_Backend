<?php

namespace App\Http\Controllers;

use App\Models\GambarProduk;
use App\Http\Requests\StoreGambarProdukRequest;
use App\Http\Requests\UpdateGambarProdukRequest;
use App\Http\Resources\GambarCollection;
use App\Http\Resources\GambarResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class GambarProdukController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/gambar",
     *     summary="Get a list of images",
     *     description="Retrieve a list of all images",
     *     operationId="getImages",
     *     tags={"Gambar"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *             )
     *         )
     *     )
     * )
     */
    public function index() : GambarCollection
    {
        $gambarProduk = GambarProduk::all();
        return new GambarCollection($gambarProduk);
    }


    /**
     * @OA\Post(
     *     path="/api/gambar",
     *     summary="Store a newly created image",
     *     description="Store a newly created image in the storage",
     *     operationId="storeImage",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Gambar"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="produk_id", type="integer", description="ID of the product", example=1),
     *                 @OA\Property(property="url", type="string", description="URL of the image", example="https://example.com/image.jpg"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID of the created image", example=1),
     *             @OA\Property(property="produk_id", type="integer", description="ID of the product", example=1),
     *             @OA\Property(property="url", type="string", description="URL of the image", example="https://example.com/image.jpg"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"produk_id": {"The produk id field is required."}})
     *         )
     *     )
     * )
     */
    public function store(StoreGambarProdukRequest $request)
    {
        $validated = $request->validated();
        $gambarProduk = GambarProduk::create($validated);
        return new GambarResource($gambarProduk);
    }

    /**
     * @OA\Get(
     *     path="/api/gambar/{id}",
     *     summary="Display a specified image",
     *     description="Retrieve a specified image by its ID",
     *     operationId="getImage",
     *     tags={"Gambar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to be retrieved",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID of the image"),
     *             @OA\Property(property="produk_id", type="integer", description="ID of the product"),
     *             @OA\Property(property="url", type="string", description="URL of the image"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gambar produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(Int $id) : GambarResource
    {
        $gambarProduk = GambarProduk::where('id', $id)->first();
        if (!$gambarProduk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Gambar produk tidak ditemukan'
            ], 400));
        }
        return new GambarResource($gambarProduk);
    }

    /**
     * @OA\Put(
     *     path="/api/gambar/{id}",
     *     summary="Update an existing image",
     *     description="Update an existing image in the storage",
     *     operationId="updateImage",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Gambar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="produk_id", type="integer", description="ID of the product"),
     *                 @OA\Property(property="url", type="string", description="URL of the image"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID of the updated image"),
     *             @OA\Property(property="produk_id", type="integer", description="ID of the product"),
     *             @OA\Property(property="url", type="string", description="URL of the updated image"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gambar produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function update(UpdateGambarProdukRequest $request, Int $id) : GambarResource
    {

        $validated = $request->validated();
        $gambarProduk = GambarProduk::where('id', $id)->first();
        if (!$gambarProduk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Gambar produk tidak ditemukan'
            ], 400));
        }
        $gambarProduk->update($validated);
        return new GambarResource($gambarProduk);
    }

    /**
     * @OA\Delete(
     *     path="/api/gambar/{id}",
     *     summary="Delete an existing image",
     *     description="Delete an existing image from the storage",
     *     operationId="deleteImage",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Gambar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gambar produk berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gambar produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $gambarProduk = GambarProduk::where('id', $id)->first();
        if (!$gambarProduk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Gambar produk tidak ditemukan'
            ], 404));
        }

        $gambarProduk->delete();
        return response()->json([
            'message' => 'Gambar produk berhasil dihapus'
        ], 200);
    }
}
