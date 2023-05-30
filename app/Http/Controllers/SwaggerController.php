<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/swagger/generate",
     *     tags={"SWAGGERS"},
     *     summary="Generation de la documentation swagger",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Succès"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Pas d'autorisé",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entité non traitable"
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request)
    {
        Artisan::call('vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"');
        Artisan::call('l5-swagger:generate');
        return response()->json(['message' => 'Documentation Swagger générée avec succès']);
    }
}
