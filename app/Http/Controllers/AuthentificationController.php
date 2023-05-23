<?php

namespace App\Http\Controllers;

use App\Managers\UserManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"AUTHENTIFICATION"},
     *     summary="Généré un jeton d'authentification",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Mot de passe",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
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
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        //Essayer
        try {
            //Validations
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:5|max:255'
            ]);

            //Vérification des validations
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //Recherche d'un email d'utilisateur (envoyé dans la requête) dans la base de données
            $user = User::where('email', $request['email'])->first();

            //Si un utilisateur existe pour cet email
            if ($user) {

                //Déclaration d'un objet composé des informations de connexions (envoyées dans la requête)
                $requestCredentials = [
                    'email' => $request['email'],
                    'password' => $request['password']
                ];

                //Si l'utilisateur n'a pas fournis les bonnes informations de connexion
                if(!Auth::attempt($requestCredentials)){

                    //Message JSON retourné
                    return response()->json([
                        'status' => false,
                        'message' => 'Les identifiants sont invalides',
                    ], 401);
                }

                //Sinon, Message JSON retourné
                return response()->json([
                    'status' => true,
                    'message' => 'Vous êtes connecté',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }
            else {

                //Message JSON retourné
                return response()->json([
                    'status' => false,
                    'message' => 'Les identifiants sont invalides',
                ], 401);
            }
        }
        //Si erreur
        catch (Throwable $th) {

            //Message JSON retourné
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"AUTHENTIFICATION"},
     *     summary="Enregistrer un utilisateur",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email de l'utilisateur",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Mot de passe de l'utilisateur",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="firstname",
     *         in="query",
     *         description="Prénom de l'utilisateur",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="lastname",
     *         in="query",
     *         description="Nom de famille de l'utilisateur",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="dateOfBirth",
     *         in="query",
     *         description="Date de Naissance de l'utilisateur",
     *         required=true,
     *         @OA\Schema(
     *             type="date-time"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="genderId",
     *         in="query",
     *         description="Identifiant du genre de l'utilisateur",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="rightId",
     *         in="query",
     *         description="Identifiant du droit de l'utilisateur",
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
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        //Essayer
        try {
            //Validations
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:5|max:255',
                'firstname' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'dateOfBirth' => 'required|datetime',
                'genreId' => 'required|numeric',
                'rightId' => 'required|numeric'
            ]);

            //Vérification des validations
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //Verification que l'email (envoyé en requête) de l'utilisateur n'existe pas déjà
            $userVerify = User::where('email', $request['email'])->first();

            //S'il existe
            if ($userVerify !== null)
            {
                //Message JSON retourné
                return response()->json([
                    'message' => 'Un compte existe déjà avec cet email',
                    'status' => false,
                    'data' => null
                ], 200);
            }
            //Sinon
            else
            {
                //Création de l'utilisateur avec le droit minimum
                $user = $this->userManager->create($request->all());

                //Message JSON retourné
                return response()->json([
                    'message' => 'Compte créé avec succès',
                    'status' => true,
                    'data' => [
                        'user' => $user
                    ]
                ], 200);
            }
        }
        //Si erreur
        catch (Throwable $th) {

            //Message JSON retourné
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"AUTHENTIFICATION"},
     *     summary="Obtenir l'utilisateur en cours",
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
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        //Essayer
        try {
            //Message JSON retourné
            return response()->json([
                'message' => 'Utilisateur en cours : ',
                'status' => true,
                'data' => $request->user()
            ], 200);
        }
        //Si erreur
        catch (Throwable $th) {

            //Message JSON retourné
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/logout",
     *     tags={"AUTHENTIFICATION"},
     *     summary="Déconnexion de l'utilisateur en cours",
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
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        //Essayer
        try {
            //Suppression du token de l'utilisateur qui souhaite se déconnecter
            $request->user()->currentAccessToken()->delete();

            //Message JSON retourné
            return response()->json([
                'message' => 'Utilisateur déconnecté',
                'status' => true,
                'data' => null,
            ], 200);
        }
        //Si erreur
        catch (Throwable $th) {

            //Message JSON retourné
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
