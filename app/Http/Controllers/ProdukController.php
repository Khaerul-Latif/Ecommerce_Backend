<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Resources\GambarCollection;
use App\Http\Resources\ProdukCollection;
use App\Http\Resources\ProdukResource;
use App\Http\Resources\VariantCollection;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/produk",
     *     summary="Retrieve a list of products",
     *     description="Retrieve a list of products with optional filters",
     *     operationId="getProduk",
     * 
     *     tags={"Produk"},
     *     @OA\Parameter(
     *         name="display",
     *         in="query",
     *         description="Filter products by display",
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *        name="kategori_id",
     *        in="query",
     *        description="Filter products by category",
     *        @OA\Schema(
     *          type="integer"
     *        )
     *     ),
     *      @OA\Parameter(
     *          name="nama",
     *          in="query",
     *          description="Filter products by name",
     *          @OA\Schema(
     *              type="string"
     *              )
     *        ),
     *      @OA\Parameter(
     *          name="sortName",
     *          in="query",
     *          description="Sort products by name",
     *          @OA\Schema(
     *              type="string",
     *              enum={"asc", "desc"}
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="sortCreatedAt",
     *          in="query",
     *          description="Sort products by created date",
     *          @OA\Schema(
     *             type="string",
     *            enum={"asc", "desc"}
     *          )
     *      ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="kategori_id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Product Name"),
     *                 @OA\Property(property="deskripsi", type="string", example="Product Description"),
     *                 @OA\Property(property="dimension", type="string", example="Product Dimension"),
     *                 @OA\Property(property="berat", type="number", format="float", example=1.5),
     *                 @OA\Property(property="material", type="string", example="Product Material"),
     *                 @OA\Property(property="display", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 @OA\Property(property="variant", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="produk_id", type="integer", example=1),
     *                          @OA\Property(property="warna", type="string", example="Red"),
     *                          @OA\Property(property="ukuran", type="string", example="Medium"),
     *                          @OA\Property(property="harga", type="number", format="float", example=10.99),
     *                          @OA\Property(property="stok", type="integer", example=100),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                          )
     *                  ),
     *                  @OA\Property(property="gambar", type="array",
     *                     @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="produk_id", type="integer", example=1),
     *                          @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                  )
     *                )
     *            )
     *        )
     *    ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", example={"display": {"The display field must be a boolean."}})
     *         )
     *     )
     * )
     */
    public function index(Request $request) : ProdukCollection
    {
        $produk = Produk::query()->where(function(Builder $query) use ($request) {
            $kategori_id = $request->input('kategori_id');
            if ($kategori_id) {
                $query->where('kategori_id', $kategori_id);
            }

            $nama = $request->input('nama');
            if ($nama) {
                $query->where('nama', 'like', "%$nama%");
            }


            $display = $request->input('display');
            if ($display) {
                $query->where('display', $display);
            }
        });

        $sort_name = $request->input('sortName');
        // dd($sort_name);
        if ($sort_name) {
            $produk->orderBy('nama', $sort_name);
        }

        $sort_created_at = $request->input('sortCreatedAt');
        if ($sort_created_at) {
            $produk->orderBy('created_at', $sort_created_at);
        }

        
        $produk = $produk->get();
        return new ProdukCollection($produk);
    }



        /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/produk",
     *     summary="Store a new product",
     *     description="Store a new product in the storage",
     *     operationId="storeProduct",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Produk"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"kategori_id", "nama", "deskripsi", "dimension", "berat", "material", "display"},
     *                 @OA\Property(property="kategori_id", type="integer", example=1, description="ID of the category"),
     *                 @OA\Property(property="nama", type="string", example="Product Name", description="Name of the product"),
     *                 @OA\Property(property="deskripsi", type="string", example="Product Description", description="Description of the product"),
     *                 @OA\Property(property="dimension", type="string", example="10x10x5", description="Dimensions of the product"),
     *                 @OA\Property(property="berat", type="number", format="float", example=2.5, description="Weight of the product"),
     *                 @OA\Property(property="material", type="string", example="Cotton", description="Material of the product"),
     *                 @OA\Property(property="display", type="boolean", example=true, description="Display status of the product"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="kategori_id", type="integer"),
     *                 @OA\Property(property="nama", type="string"),
     *                 @OA\Property(property="deskripsi", type="string"),
     *                 @OA\Property(property="dimension", type="string"),
     *                 @OA\Property(property="berat", type="number", format="float"),
     *                 @OA\Property(property="material", type="string"),
     *                 @OA\Property(property="display", type="boolean"),
     *                 @OA\Property(
     *                     property="variant",
     *                     type="array",
     *                     @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="produk_id", type="integer", example=1),
     *                          @OA\Property(property="warna", type="string", example="Red"),
     *                          @OA\Property(property="ukuran", type="string", example="Medium"),
     *                          @OA\Property(property="harga", type="number", format="float", example=10.99),
     *                          @OA\Property(property="stok", type="integer", example=100),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                      )
     *                  ),
     *                  @OA\Property(
     *                     property="gambar",
     *                     type="array",
     *                     @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="produk_id", type="integer", example=1),
     *                          @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                  )
     *                )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nama produk sudah ada")
     *         )
     *     )
     * )
     */
    public function store(StoreProdukRequest $request) : ProdukResource
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['nama']);
        $cek_same_name = Produk::where('slug', $validated['slug'])->first();
        if ($cek_same_name) {
            throw new HttpResponseException(response()->json([
                'message' => 'Nama produk sudah ada'
            ], 400));
        }
        $produk = Produk::create($validated);
        return new ProdukResource($produk);
    }

    /**
     * @OA\Get(
     *     path="/api/produk/{slug}",
     *     summary="Retrieve a product by slug",
     *     description="Retrieve a product by its slug from the storage",
     *     operationId="getProductBySlug",
     *     tags={"Produk"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug of the product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="kategori_id", type="integer", example=1),
     *             @OA\Property(property="nama", type="string", example="Product Name"),
     *             @OA\Property(property="deskripsi", type="string", example="Product Description"),
     *             @OA\Property(property="dimension", type="string", example="Product Dimension"),
     *             @OA\Property(property="berat", type="number", format="float", example=1.5),
     *             @OA\Property(property="material", type="string", example="Product Material"),
     *             @OA\Property(property="display", type="boolean", example=true),
     *             @OA\Property(
     *                 property="variant",
     *                 type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="produk_id", type="integer", example=1),
     *                      @OA\Property(property="warna", type="string", example="Red"),
     *                      @OA\Property(property="ukuran", type="string", example="Medium"),
     *                      @OA\Property(property="harga", type="number", format="float", example=10.99),
     *                      @OA\Property(property="stok", type="integer", example=100),
     *                      @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="gambar",
     *                 type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="produk_id", type="integer", example=1),
     *                      @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *                      @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(String $slug) : ProdukResource
    {
        $produk = Produk::where('slug', $slug)->first();

        if (!$produk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 400));
        }
        return new ProdukResource($produk);
    }


    /**
     * @OA\Put(
     *     path="/api/produk/{id}",
     *     summary="Update an existing product",
     *     description="Update an existing product in the storage",
     *     operationId="updateProduk",
     *     security={{ "bearerAuth": { }}},
     *     tags={"Produk"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"kategori_id", "nama", "deskripsi", "dimension", "berat", "material", "display"},
     *                 @OA\Property(property="kategori_id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", maxLength=255, example="Updated Product Name"),
     *                 @OA\Property(property="deskripsi", type="string", example="Updated Product Description"),
     *                 @OA\Property(property="dimension", type="string", example="Updated Product Dimension"),
     *                 @OA\Property(property="berat", type="number", format="float", example=2.0),
     *                 @OA\Property(property="material", type="string", example="Updated Product Material"),
     *                 @OA\Property(property="display", type="boolean", example=true),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="kategori_id", type="integer", example=1),
     *             @OA\Property(property="nama", type="string", example="Updated Product Name"),
     *             @OA\Property(property="deskripsi", type="string", example="Updated Product Description"),
     *             @OA\Property(property="dimension", type="string", example="Updated Product Dimension"),
     *             @OA\Property(property="berat", type="number", format="float", example=2.0),
     *             @OA\Property(property="material", type="string", example="Updated Product Material"),
     *             @OA\Property(property="display", type="boolean", example=true),
     *             @OA\Property(
     *                 property="variant",
     *                 type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="produk_id", type="integer", example=1),
     *                      @OA\Property(property="warna", type="string", example="Red"),
     *                      @OA\Property(property="ukuran", type="string", example="Medium"),
     *                      @OA\Property(property="harga", type="number", format="float", example=10.99),
     *                      @OA\Property(property="stok", type="integer", example=100),
     *                      @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="gambar",
     *                 type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="produk_id", type="integer", example=1),
     *                      @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *                      @OA\Property(property="created_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time", example="2021-08-01T00:00:00.000000Z"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nama produk sudah ada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function update(UpdateProdukRequest $request, Int $id) : ProdukResource
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['nama']);
        $cek_same_name = Produk::where('slug', $validated['slug'])->first();
        if ($cek_same_name && $cek_same_name->id != $id) {
            throw new HttpResponseException(response()->json([
                'message' => 'Nama produk sudah ada'
            ], 400));
        }
        $produk = Produk::where('id', $id)->first();
        if (!$produk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404));
        }

        $produk->update($validated);
        return new ProdukResource($produk);
    }

    /**
     * @OA\Delete(
     *     path="/api/produk/{id}",
     *     summary="Delete an existing product",
     *     description="Delete an existing product from the storage",
     *     operationId="deleteProduk",
     *     tags={"Produk"},
     *     security={{ "bearerAuth": { }}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to be deleted",
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
     *             @OA\Property(property="message", type="string", example="Produk berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function destroy(Int $id)
    {
        $produk = Produk::where('id', $id)->first();
        if (!$produk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404));
        }
        $produk->delete();
        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/produk/{id}/variant",
     *     summary="Get variants of a product",
     *     description="Retrieve variants of a specific product",
     *     operationId="getProductVariants",
     *     tags={"Produk"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product",
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function variant(Int $id) : VariantCollection
    {
        $produk = Produk::where('id', $id)->first();
        if (!$produk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404));
        }
        return new VariantCollection($produk->variant);
    }
    /**
     * @OA\Get(
     *     path="/api/produk/{id}/gambar",
     *     summary="Get images of a product",
     *     description="Retrieve images of a specific product",
     *     operationId="getProductImages",
     *     tags={"Produk"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product",
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
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produk tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function gambar(Int $id) : GambarCollection {
        $produk = Produk::where('id', $id)->first();
        if (!$produk) {
            throw new HttpResponseException(response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404));
        }
        return new GambarCollection($produk->gambar);
    }
}
