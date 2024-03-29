<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Transaksi;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\PathItem(path="/api")
 */
class BarangKeluarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/barang-keluar",
     *     summary="Get all barang-keluar",
     *     description="Get all barang-keluar data",
     *     operationId="getbarang-keluar",
     *     tags={"Barang Keluar"},
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
     *         description="No barang-keluar found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data barang keluar yang ditemukan"
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
        $barangkeluar = BarangKeluar::with('variant.produk', 'transaksi')->get();
        return response()->json(['message' => 'Sukses', 'data' => $barangkeluar]);
    }

    /**
     * @OA\Post(
     *     path="/api/barang-keluar",
     *     summary="Create a new barang keluar",
     *     description="Create a new barang keluar with specified title and year",
     *     operationId="createbarangkeluar",
     *     tags={"Barang Keluar"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="transaksi_id", type="string", example="1"),
     *             @OA\Property(property="variant_id", type="string", example="1"),
     *             @OA\Property(property="jumlah", type="string", example="1"),
     *             @OA\Property(property="harga", type="string", example="1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Barang Keluar created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Barang Keluar created successfully"),
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
     *         description="Barang Keluar not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Barang Keluar not found")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id'     => 'required',
            'variant_id'     => 'required',
            'jumlah'     => 'required',
            'harga'     => 'required',
        ], [
            'transaksi_id.required' => 'ID Transaksi Tidak Boleh Kosong',
            'variant_id.required' => 'ID Variant Tidak Boleh Kosong',
            'jumlah.required' => 'Jumlah Tidak Boleh Kosong',
            'harga.required' => 'Harga Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $transaksi = Transaksi::find($request->transaksi_id);
        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi Tidak Ditemukan',
            ], 422);
        }
        $variant = Variant::find($request->variant_id);
        if (!$variant) {
            return response()->json([
                'message' => 'Variant Tidak Ditemukan',
            ], 422);
        }

        $barangkeluar = BarangKeluar::create($request->all());

        if (!$barangkeluar) {

            return response()->json([
                'message' => 'Data Barang Keluar Gagal Ditambahkan',
            ], 422);
        }

        return response()->json([
            'message' => 'Data Barang Keluar Berhasil Ditambahkan',
            'data' => $barangkeluar,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/barang-keluar/{id}",
     *     summary="Get Barang Keluar by id",
     *     description="Get Barang Keluar by id data",
     *     operationId="getBarang KeluarById",
     *     tags={"Barang Keluar"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Barang Keluar to retrieve",
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
     *         description="No Barang Keluar found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tidak ada data Barang Keluar yang ditemukan"
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
        $barangkeluar = BarangKeluar::find($id);
        if (!$barangkeluar) {
            return response()->json(['message' => 'Data Barang Keluar Tidak Ditemukan']);
        }
        return response()->json(['message' => 'Sukses', 'data' => $barangkeluar]);
    }

    /**
     * @OA\Put(
     *     path="/api/barang-keluar/{id}",
     *     summary="update Barang Keluar",
     *     description="update Barang Keluar with specified title and year",
     *     operationId="updateBarang Keluar",
     *     tags={"Barang Keluar"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Barang Keluar to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="transaksi_id", type="string", example="1"),
     *             @OA\Property(property="variant_id", type="string", example="1"),
     *             @OA\Property(property="jumlah", type="string", example="1"),
     *             @OA\Property(property="harga", type="string", example="1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Barang Keluar updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Barang Keluar updated successfully"),
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
     *         description="Barang Keluar not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Barang Keluar not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $barangkeluar = BarangKeluar::find($id);
        if ($barangkeluar) {

            $validator = Validator::make($request->all(), [
                'transaksi_id'     => 'required',
                'variant_id'     => 'required',
                'jumlah'     => 'required',
                'harga'     => 'required',
            ], [
                'transaksi_id.required' => 'ID Transaksi Tidak Boleh Kosong',
                'variant_id.required' => 'ID Variant Tidak Boleh Kosong',
                'jumlah.required' => 'Jumlah Tidak Boleh Kosong',
                'harga.required' => 'Harga Tidak Boleh Kosong',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $transaksi = Transaksi::find($request->transaksi_id);
            if (!$transaksi) {
                return response()->json([
                    'message' => 'Transaksi Tidak Ditemukan',
                ], 422);
            }
            $variant = Variant::find($request->variant_id);
            if (!$variant) {
                return response()->json([
                    'message' => 'Variant Tidak Ditemukan',
                ], 422);
            }
            $jumlahbefore = $barangkeluar->jumlah;
            $hargavarian = $variant->harga;
            $hargaBefore = $hargavarian * $jumlahbefore;
            $totalhargabefore = $transaksi->total_harga - $hargaBefore;
            $hargaAfter = $hargavarian * $request->jumlah;
            $totalhargaAfter = $totalhargabefore + $hargaAfter;
            
            $transaksi->update(['total_harga' => $totalhargaAfter]);
            

            $aksi = $barangkeluar->update($request->all());

            if (!$aksi) {

                return response()->json([
                    'message' => 'Data Barang Keluar Gagal Diupdate',
                ], 422);
            }

            return response()->json([
                'message' => 'Data Barang Keluar Berhasil Diupdate',
                'data' => $barangkeluar,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Barang Keluar Gagal Ditemukan',
            ], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/barang-keluar/{id}",
     *     summary="Delete a Barang Keluar",
     *     description="Delete a Barang Keluar by ID",
     *     operationId="deleteBarang KeluarById",
     *     tags={"Barang Keluar"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Barang Keluar to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Barang Keluar deleted successfully",
     *     )
     * )
     */
    public function destroy($id)
    {
        $barangkeluar = BarangKeluar::find($id);
        if ($barangkeluar) {
            $aksi = $barangkeluar->delete();
            if (!$aksi) {

                return response()->json([
                    'message' => 'Data Barang Keluar Gagal Dihapus',
                ], 422);
            }

            return response()->json([
                'message' => 'Data Barang Keluar Berhasil Dihapus',
                'data' => $barangkeluar,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Barang Keluar Gagal Ditemukan',
            ], 422);
        }
    }
}
