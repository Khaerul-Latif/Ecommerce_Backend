<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/kategori",
     *     summary="Menampilkan semua kategori",
     *     tags={"Kategori"},
     *     @OA\Response(
     *         response=200,
     *         description="OK. Daftar kategori berhasil ditemukan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sukses"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="Kategori 1"),
     *                     @OA\Property(property="slug", type="string", example="kategori-1"),
     *                     @OA\Property(property="display", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori tidak ditemukan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kategori tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Kategori::all();

        return response()->json([
            'message' => 'Sukses',
            'data' => $data
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/kategori",
     *     summary="Menambahkan kategori baru",
     *     tags={"Kategori"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data kategori yang akan ditambahkan",
     *         @OA\JsonContent(
     *             required={"nama"},
     *             @OA\Property(property="nama", type="string", example="Kategori Baru")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil menambahkan kategori baru",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil tambah data"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Kategori Baru"),
     *                 @OA\Property(property="slug", type="string", example="kategori-baru"),
     *                 @OA\Property(property="display", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreKategoriRequest $request)
    {
        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        $kategori->slug = Str::slug($request->nama);
        $kategori->display = true;
        $kategori->save();

        return response()->json([
            'message' => 'Berhasil tambah data',
            'data' => $kategori
        ], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/kategori/{id}",
     *     summary="Menampilkan detail kategori",
     *     tags={"Kategori"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID kategori yang akan ditampilkan",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sukses menampilkan detail kategori",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sukses"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Nama Kategori"),
     *                 @OA\Property(property="slug", type="string", example="nama-kategori"),
     *                 @OA\Property(property="display", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID kategori tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="ID tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $data = Kategori::findOrFail($id);

            return response()->json([
                'message' => 'Sukses',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/kategori/{id}",
     *     summary="Memperbarui kategori",
     *     tags={"Kategori"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID kategori yang akan diperbarui",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data kategori yang akan diperbarui",
     *         @OA\JsonContent(
     *             required={"nama"},
     *             @OA\Property(property="nama", type="string", example="Kategori Baru")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil memperbarui data kategori",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil update data"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Kategori Baru"),
     *                 @OA\Property(property="slug", type="string", example="kategori-baru"),
     *                 @OA\Property(property="display", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="ID tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function update(UpdateKategoriRequest $request, $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->nama = $request->nama;
            $kategori->slug = Str::slug($request->nama);
            $kategori->update();

            return response()->json([
                'message' => 'Berhasil update data',
                'data' => $kategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/kategori/{id}",
     *     summary="Menghapus kategori",
     *     tags={"Kategori"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID kategori yang akan dihapus",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil menghapus data kategori",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Berhasil hapus data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="ID tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan saat menghapus data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan saat menghapus data")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $data = Kategori::findOrFail($id);
            $data->delete();

            return response()->json(['message' => 'Berhasil hapus data'], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'ID tidak ditemukan'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }

}
