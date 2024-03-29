<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Resources\TransaksiCollection;
use App\Models\Alamat;
use App\Models\BarangKeluar;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transaksi",
     *     description="get all transaksi data",
     *     summary="get all transaksi",
     *     operationId="gettransaksi",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_harga", type="integer", example=200000),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1)
     *             )
     *         )
     *     )
     * )
     */

    public function index() {
        $data = Transaksi::with(['user', 'alamat'])->get();
        return response()->json($data);
    }
    
    /**
     * @OA\Get(
     *     path="/api/transaksi/user/personal",
     *     description="get Transaksi by user",
     *     summary="get Transaksi by user",
     *     operationId="getTransaksiByUser",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": { }}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_harga", type="integer", example=200000),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1),
     *                 @OA\Property(property="barang_keluar", type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="transaksi_id", type="integer", example=1),
     *                          @OA\Property(property="variant_id", type="integer", example=1),
     *                          @OA\Property(property="jumlah", type="integer", example=1),
     *                          @OA\Property(property="harga", type="integer", example=1000)
     *                      )
     *                 )
     *             )
     *         )
     *     )
     * )
     */


    public function getByUser()  {
        $user = auth()->user();

        if(!$user){
            return response()->json([
                'error' => 'unauthorized'
            ], 404);
        }


        $data = Transaksi::where('user_id', $user->id)->get();

        // dd($user->id);
        // return response()->json($data);
        return new TransaksiCollection($data);
    }

    public function getBarang($id) {
        $data = BarangKeluar::where('transaksi_id', $id)->get();
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/transaksi/{id}",
     *     description="get a transaksi data",
     *     summary="get a transaksi",
     *     operationId="showtransaksi",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_harga", type="integer", example=200000),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1)
     *             )
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        // Check data in database
        $transaksi = Transaksi::find($id);

        if(!$transaksi) {
            return response()->json([
                'error' => 'Transaksi not Found'
            ], 404);
        }

        return response()->json($transaksi);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/transaksi",
     *     description="create transaksi data",
     *     summary="create transaksi",
     *     operationId="createtransaksi",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Transaksi data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "total_harga", "tanggal", "kode_promo", "status_pembayaran", "status_pengiriman", "bukti_pembayaran", "alamat_id"},
     *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="total_harga", type="integer", example=200000, description="Total payment"),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00", description="date transaksi"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS", description="use kode promo"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0, description="status pembayaran (0)"),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim", description="inform status pengiriman"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo", description="upload bukti pembayaran"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1, description="ID of the alamat")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_harga", type="integer", example=200000),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1)
     *             )
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'user_id' => 'required',
            'total_harga' => 'required',
            'tanggal' => 'required',
            'kode_promo' => 'required',
            'status_pembayaran' => 'required',
            'status_pengiriman' => 'required',
            'alamat_id' => 'required'
        ];

        $user = User::find($data['user_id']);

        if(!$user) {
            return response()->json([
                'error' => 'User not Found'
            ], 404);
        }

        $alamat = Alamat::find($data['alamat_id']);

        if(!$alamat) {
            return response()->json([
                'error' => 'Alamat not Found'
            ], 404);
        }

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $transaksi = Transaksi::create($data);
        return response()->json($transaksi);
    }

    /**
     * @OA\Put(
     *     path="/api/transaksi/{id}",
     *     description="update a transaksi data",
     *     summary="update transaksi",
     *     operationId="updatetransaksi",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the transaksi to be updated",
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
     *                 type="object",
     *                 required={"user_id", "total_harga", "tanggal", "kode_promo", "status_pembayaran", "status_pengiriman", "bukti_pembayaran", "alamat_id"},
     *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="total_harga", type="integer", example=200000, description="Total payment"),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00", description="date transaksi"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS", description="use kode promo"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0, description="status pembayaran (0)"),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim", description="inform status pengiriman"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo", description="upload bukti pembayaran"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1, description="ID of the alamat")
     *             )
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
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_harga", type="integer", example=200000),
     *                 @OA\Property(property="tanggal", type="dateTime", example="2024-03-06 07:30:00"),
     *                 @OA\Property(property="kode_promo", type="string", example="MAJUTERUS"),
     *                 @OA\Property(property="status_pembayaran", type="boolean", example=0),
     *                 @OA\Property(property="status_pengiriman", type="string", example="belum dikirim"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", example="link photo"),
     *                 @OA\Property(property="alamat_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaksi not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Transaksi tidak ditemukan")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);

        if(!$transaksi) {
            return response()->json([
                'error' => 'Transaksi not Found'
            ], 404);
        }

        $data = $request->all();

        $rules = [
            'user_id' => 'required',
            'total_harga' => 'required',
            'tanggal' => 'required',
            'kode_promo' => 'nullable',
            'status_pembayaran' => 'required',
            'status_pengiriman' => 'required',
            'bukti_pembayaran' => 'required',
            'alamat_id' => 'required'
        ];

        $user = User::find($data['user_id']);

        if(!$user) {
            return response()->json([
                'error' => 'User not Found'
            ], 404);
        }

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $transaksi->fill($data);
        $transaksi->save();
        return response()->json($transaksi);
    }

    /**
     * @OA\Delete(
     *     path="/api/transaksi/{id}",
     *     description="delete transaksi data",
     *     summary="delete transaksi",
     *     operationId="deletetransaksi",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the transaksi to be deleted",
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
     *             @OA\Property(property="message", type="string", example="transaksi berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="transaksi not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="transaksi tidak ditemukan")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        // Check data in database
        $transaksi = Transaksi::find($id);

        if(!$transaksi) {
            return response()->json([
                'error' => 'Transaksi not Found'
            ], 404);
        }

        $transaksi->delete();
        return response()->json([
            'message' => 'Data Transaksi succesfull deleted'
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/checkout",
     *     operationId="checkout",
     *     tags={"Transaksi"},
     *     security={{ "bearerAuth": { }}},
     *     summary="Process checkout",
     *     description="Process checkout for a user",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Checkout data",
     *         @OA\JsonContent(
     *             required={"total_harga", "alamat_id", "barang_keluar"},
     *             @OA\Property(property="total_harga", type="number", format="float", example=200),
     *             @OA\Property(property="kode_promo", type="string", nullable=true),
     *             @OA\Property(property="alamat_id", type="integer", example=1),
     *             @OA\Property(
     *                 property="barang_keluar",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="variant_id", type="integer", example=1),
     *                     @OA\Property(property="jumlah", type="integer", example=1),
     *                     @OA\Property(property="harga", type="number", format="float", example=1000),
     *                 )
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Transaksi berhasil dibuat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     * )
     */
    public function checkout(StoreCheckoutRequest $request){
        $validated = $request->validated();
        $user = auth()->user();
        if(!$user){
            return response()->json([
                'error' => 'unauthorized'
            ], 404);
        }

        $alamat = Alamat::where('id', $validated['alamat_id'])->first();
        if(!$alamat){
            return response()->json([
                'error' => 'Alamat not Found'
            ], 404);
        }

        // check barang keluar
        $barang_keluar = $validated['barang_keluar'];
        foreach($barang_keluar as $item){
            $variant = Variant::where('id', $item['variant_id'])->first();
            if(!$variant){
                return response()->json([
                    'error' => 'Barang not Found'
                ], 404);
            }

            if($variant->stok < $item['jumlah']){
                return response()->json([
                    'error' => 'Stok barang ' + $variant->nama +  ' tidak cukup'
                ], 400);
            }

            $variant->stok = $variant->stok - $item['jumlah'];
            $variant->save();
        }
        $kode_promo = $request->input('kode_promo');

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'total_harga' => $validated['total_harga'],
            'tanggal' => now(),
            'kode_promo' => $kode_promo,
            'status_pembayaran' => 0,
            'status_pengiriman' => 'belum dikirim',
            'bukti_pembayaran' => '',
            'alamat_id' => $alamat->id
        ]);

        foreach($barang_keluar as $item){
            BarangKeluar::create([
                'transaksi_id' => $transaksi->id,
                'variant_id' => $item['variant_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga']
            ]);
        }

        foreach($barang_keluar as $item) {
            $keranjang = Keranjang::where('user_id', $user->id)->where('variant_id', $item['variant_id'])->first();
            if($keranjang){
                $keranjang->delete();
            }
        }

        return response()->json([
            'message' => 'Transaksi berhasil dibuat'
        ]);
    }
}
