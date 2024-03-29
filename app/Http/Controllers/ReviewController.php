<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/review",
     *     description="get all review data",
     *     summary="get all review",
     *     operationId="getreview",
     *     tags={"Review"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="bintang", type="integer", example=3),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla")
     *             )
     *         )
     *     )
     * )
     */
    public function index() {
        $data = Review::get();
        return response()->json($data);
    }
    
    /**
     * @OA\Get(
     *     path="/api/review/produk/{id}",
     *     description="get all review data by produk id",
     *     summary="get all review data by produk id",
     *     operationId="getreviewbyprodukid",
     *     tags={"Review"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="bintang", type="integer", example=3),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla")
     *             )
     *         )
     *     )
     * )
     */

    public function getbyProduct($id) {
        $data = Review::where('produk_id', $id)->get();
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/review/{id}",
     *     description="get a review data",
     *     summary="get a review",
     *     operationId="showreview",
     *     tags={"Review"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="bintang", type="integer", example=3),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla")
     *             )
     *         )
     *     )
     * )
     */


     public function getReviewByUserId()
    {

        $user = Auth::user();

        if ($user) {

            $user_id = $user->id;

        } else {

            return response()->json(['message' => 'Silahkan login terlebih dahulu'], 400);

        }

        $data = Review::with(['user', 'produk'])->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Sukses',
            'data' => $data
        ], 201);
    }


    public function show($id)
    {
        // Check data in database
        $review = Review::find($id);

        if(!$review) {
            return response()->json([
                'error' => 'Review not Found'
            ], 404);
        }

        return response()->json($review);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/review",
     *     description="create review data",
     *     summary="create review",
     *     operationId="createreview",
     *     tags={"Review"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Review data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "produk_id", "bintang", "comment"},
     *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="produk_id", type="integer", example=1 , description="ID of the produk"),
     *                 @OA\Property(property="bintang", type="integer", example=1 , description="Rate the product from buyyer"),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla", description="comment positive or negative by user")
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
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="bintang", type="integer", example=4),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla")
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
            'produk_id' => 'required',
            'comment' => 'required|string',
            'bintang' => 'required'
        ];

        // Check data in database
        $user = User::find($data['user_id']);

        if(!$user) {
            return response()->json([
                'error' => 'User not Found'
            ], 404);
        }

        // Check data in database
        $produk = Produk::find($data['produk_id']);

        if(!$produk) {
            return response()->json([
                'error' => 'Produk not Found'
            ], 404);
        }

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $review = Review::create($data);
        return response()->json($review);
    }

    /**
     * @OA\Put(
     *     path="/api/review/{id}",
     *     description="update a review data",
     *     summary="update review",
     *     operationId="updatereview",
     *     tags={"Review"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Review to be updated",
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
     *                 required={"user_id", "produk_id", "bintang", "comment"},
     *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="produk_id", type="integer", example=1 , description="ID of the produk"),
     *                 @OA\Property(property="bintang", type="integer", example=1 , description="Rate the product from buyyer"),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla", description="comment positive or negative by user")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="produk_id", type="integer", example=1),
     *                 @OA\Property(property="bintang", type="integer", example=4),
     *                 @OA\Property(property="comment", type="string", example="This Product is bla bla bla")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Review tidak ditemukan")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        // Check data in database
        $review = Review::find($id);

        if(!$review) {
            return response()->json([
                'error' => 'Review not Found'
            ], 404);
        }

        $data = $request->all();

        $rules = [
            'user_id' => 'required',
            'produk_id' => 'required',
            'comment' => 'required|string',
            'bintang' => 'required'
        ];

        // Check data in database
        $user = User::find($data['user_id']);

        if(!$user) {
            return response()->json([
                'error' => 'User not Found'
            ], 404);
        }

        // Check data in database
        $produk = Produk::find($data['produk_id']);

        if(!$produk) {
            return response()->json([
                'error' => 'Produk not Found'
            ], 404);
        }

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $review->fill($data);
        $review->save();
        return response()->json($review);
    }

    /**
     * @OA\Delete(
     *     path="/api/review/{id}",
     *     description="delete a review data",
     *     summary="delete review",
     *     operationId="deletereview",
     *     tags={"Review"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the review to be deleted",
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
     *             @OA\Property(property="message", type="string", example="Review berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Review tidak ditemukan")
     *         )
     *     )
     * )
     */
    
    public function destroy($id)
    {
        // Check data in database
        $review = Review::find($id);

        if(!$review) {
            return response()->json([
                'error' => 'Review not Found'
            ], 404);
        }

        $review->delete();
        return response()->json([
            'message' => 'Data Review succesfull deleted'
        ]);
    }
}
