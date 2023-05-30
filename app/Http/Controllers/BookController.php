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

    /**
    * @OA\Get(
    *     path="/api/books",
    *     tags={"BOOK"},
    *     summary="Obtenir les livres",
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
    *
    * @return JsonResponse
    */
    public function index()
    {
        return response()->json(['books' => Book::all()], 200);
    }

    /**
    * @OA\Get(
    *     path="/api/book/show/{id}",
    *     tags={"BOOK"},
    *     summary="Afficher un livre",
    *     security={{"bearer_token":{}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Identifiant",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
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
    *
    * @param int $id
    * @return JsonResponse
    */
    public function show(int $id)
    {
        return response()->json(['book' => Book::findOrFail($id)], 200);
    }

    /**
    * @OA\Put(
    *     path="/api/book/update/{id}",
    *     tags={"BOOK"},
    *     summary="Mise à jour d'un livre",
    *     security={{"bearer_token":{}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Identifiant",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
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
    *         required=false,
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
    * @param int $id
    * @return JsonResponse
    */
    public function update(BookRequest $request, int $id)
    {
        $data = $this->bookManager->update(Book::findOrFail($id), $request->all());

        if ($data) {
            //Message JSON retourné
            return response()->json([
                'message' => 'Livre mis à jour',
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

    /**
    * @OA\Delete(
    *     path="/api/book/delete/{id}",
    *     tags={"BOOK"},
    *     summary="Suppression d'un livre",
    *     security={{"bearer_token":{}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Identifiant",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
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
    * @param int $id
    * @return JsonResponse
    */
    public function destroy(int $id)
    {
        return response()->json([
            'book' => $this->bookManager->delete(Book::findOrFail($id)),
            'message' => 'Livre supprimé'
        ], 200);
    }
}
