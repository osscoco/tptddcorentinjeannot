<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Format;
use App\Models\Gender;
use App\Models\Right;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;


class UngenerateDataController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ungenerate-data",
     *     tags={"GENERATIONS"},
     *     summary="Dégénération des données redondantes",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Succès"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Pas autorisé",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entité non traitable"
     *     )
     * )
     * @return JsonResponse
     */
    public function index()
    {
        Schema::disableForeignKeyConstraints();
        Book::truncate();
        User::truncate();
        Format::truncate();
        Gender::truncate();
        Right::truncate();
        Schema::enableForeignKeyConstraints();

        return response()->json([
            'message' => 'Données supprimées'
        ], 200);
    }
}
