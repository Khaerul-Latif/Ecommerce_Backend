<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Http\Resources\VariantCollection;
use App\Http\Resources\VariantResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\In;

class VariantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/variant",
     *     summary="Get a list of variants",
     *     description="Retrieve a list of all variants",
     *     operationId="getVariants",
     *     tags={"Variant"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="warna", type="string", example="Red"),
     *                 @OA\Property(property="ukuran", type="string", example="Medium"),
     *                 @OA\Property(property="harga", type="number", format="float", example=10.99),
     *                 @OA\Property(property="stok", type="integer", example=100),
     *             )
     *         )
     *     )
     * )
     */
    public function index() : VariantCollection
    {
        $variant = Variant::all();
        return new VariantCollection($variant);
    }


    /**
     * Store a newly created variant in storage.
     *
     * @OA\Post(
     *     path="/api/variant",
     *     summary="Store a newly created variant",
     *     description="Store a newly created variant in the storage",
     *     operationId="storeVariant",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Variant"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Variant data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"produk_id", "warna", "ukuran", "harga", "stok"},
     *                 @OA\Property(property="produk_id", type="integer", description="ID of the product"),
     *                 @OA\Property(property="warna", type="string", description="Color of the variant"),
     *                 @OA\Property(property="ukuran", type="string", description="Size of the variant"),
     *                 @OA\Property(property="harga", type="number", format="float", description="Price of the variant"),
     *                 @OA\Property(property="stok", type="integer", description="Stock of the variant"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Variant created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="produk_id", type="integer"),
     *                 @OA\Property(property="warna", type="string"),
     *                 @OA\Property(property="ukuran", type="string"),
     *                 @OA\Property(property="harga", type="number", format="float"),
     *                 @OA\Property(property="stok", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant dengan warna dan ukuran yang sama sudah ada")
     *         )
     *     )
     * )
     */
    public function store(StoreVariantRequest $request) : VariantResource
    {
        $validated = $request->validated();
        $check_same_color_and_size = Variant::where('produk_id', $validated['produk_id'])
            ->where('warna', $validated['warna'])
            ->where('ukuran', $validated['ukuran'])
            ->first();
        if ($check_same_color_and_size) {
            throw new HttpResponseException(response()->json([
                'message' => 'Variant dengan warna dan ukuran yang sama sudah ada'
            ], 400));
        }
        $variant = Variant::create($validated);
        return new VariantResource($variant);
    }

    /**
     * @OA\Get(
     *     path="/api/variant/{id}",
     *     summary="Display a specified variant",
     *     description="Retrieve a specified variant by its ID",
     *     operationId="getVariant",
     *     tags={"Variant"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the variant to be retrieved",
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
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="produk_id", type="integer"),
     *             @OA\Property(property="warna", type="string"),
     *             @OA\Property(property="ukuran", type="string"),
     *             @OA\Property(property="harga", type="number", format="float"),
     *             @OA\Property(property="stok", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(Int $id) : VariantResource
    {
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            throw new HttpResponseException(response()->json([
                'message' => 'Variant tidak ditemukan'
            ], 404));
        }
        return new VariantResource($variant);
    }


    /**
     * Update the specified variant in storage.
     *
     * @OA\Put(
     *     path="/api/variant/{id}",
     *     summary="Update a variant",
     *     description="Update a variant in the storage",
     *     operationId="updateVariant",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Variant"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the variant to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated variant data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"produk_id", "warna", "ukuran", "harga", "stok"},
     *                 @OA\Property(property="produk_id", type="integer", example=1, description="ID of the product"),
     *                 @OA\Property(property="warna", type="string", example="Red", description="Color of the variant"),
     *                 @OA\Property(property="ukuran", type="string", example="Large", description="Size of the variant"),
     *                 @OA\Property(property="harga", type="number", format="float", example=19.99, description="Price of the variant"),
     *                 @OA\Property(property="stok", type="integer", example=100, description="Stock of the variant"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Variant updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="produk_id", type="integer"),
     *                 @OA\Property(property="warna", type="string"),
     *                 @OA\Property(property="ukuran", type="string"),
     *                 @OA\Property(property="harga", type="number", format="float"),
     *                 @OA\Property(property="stok", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant dengan warna dan ukuran yang sama sudah ada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function update(UpdateVariantRequest $request, Int $id) : VariantResource
    {
        $validated = $request->validated();
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            throw new HttpResponseException(response()->json([
                'message' => 'Variant tidak ditemukan'
            ], 404));
        }

        $check_same_color_and_size = Variant::where('produk_id', $validated['produk_id'])
            ->where('warna', $validated['warna'])
            ->where('ukuran', $validated['ukuran'])
            ->first();

        if ($check_same_color_and_size && $check_same_color_and_size->id != $id) {
            throw new HttpResponseException(response()->json([
                'message' => 'Variant dengan warna dan ukuran yang sama sudah ada'
            ], 400));
        }
        $variant->update($validated);
        return new VariantResource($variant);
    }

    /**
     * @OA\Delete(
     *     path="/api/variant/{id}",
     *     summary="Delete an existing variant",
     *     description="Delete an existing variant from the storage",
     *     operationId="deleteVariant",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Variant"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the variant to be deleted",
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
     *             @OA\Property(property="message", type="string", example="Variant berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function destroy(Int $id)
    {
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            throw new HttpResponseException(response()->json([
                'message' => 'Variant tidak ditemukan'
            ], 404));
        }
        $variant->delete();
        return response()->json([
            'message' => 'Variant berhasil dihapus'
        ], 200);
    }
}
