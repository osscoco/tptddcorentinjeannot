<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Managers\BookManager;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    protected $bookManager;

    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @OA\Post(
     *     path="/api/book/store",
     *     tags={"BOOK"},
     *     summary="Création d'un livre",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="isbn",
     *         in="query",
     *         description="ISBN du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Titre du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Auteur du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="editor",
     *         in="query",
     *         description="Editeur du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="isAvailable",
     *         in="query",
     *         description="Disponibilité du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="formatId",
     *         in="query",
     *         description="Format du livre",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="query",
     *         description="Utilisateur ayant le livre",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
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
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request)
    {
        $data = $this->bookManager->create($request->validated());

        if ($data) {
            //Message JSON retourné
            return response()->json([
                'message' => 'Livre créé',
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            //Message JSON retourné
            return response()->json([
                'message' => 'ISBN non valide',
                'status' => false,
                'data' => null
            ], 200);
        }

    }
}
