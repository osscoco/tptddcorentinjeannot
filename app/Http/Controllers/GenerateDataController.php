<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Format;
use App\Models\Gender;
use App\Models\Right;
use App\Models\User;
use App\Managers\BookManager;


class GenerateDataController extends Controller
{
    protected $bookManager;

    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @OA\Get(
     *     path="/api/generate-data",
     *     tags={"GENERATIONS"},
     *     summary="Génération des données",
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
        $gender1 = Gender::create(
            array(
                'label' => 'Male'
            )
        );

        $gender1->save();

        $gender2 = Gender::create(
            array(
                'label' => 'Female'
            )
        );

        $gender2->save();

        $format1 = Format::create(
            array(
                'label' => 'Poche'
            )
        );

        $format1->save();

        $format2 = Format::create(
            array(
                'label' => 'Broché'
            )
        );

        $format2->save();

        $format3 = Format::create(
            array(
                'label' => 'Grand Format'
            )
        );

        $format3->save();

        $right1 = Right::create(
            array(
                'label' => 'User'
            )
        );

        $right1->save();

        $right2 = Right::create(
            array(
                'label' => 'Admin'
            )
        );

        $right2->save();

        $user1 = User::create(
            array(
                'email' => 'corentin.jeannot2a@gmail.com',
                'password' => Hash::make('Not24get'),
                'firstname' => 'Corentin',
                'lastname' => 'JEANNOT',
                'dateOfBirth' => Carbon::create(1999, 11, 21, 23, 12, 15, "Europe/London"),
                'genderId' => 1,
                'rightId' => 2
            )
        );

        $user1->save();

        $book1 = $this->bookManager->create([
            'isbn' => '2490334166',
            'title' => 'Livre de recette Harry Potter - Pour les moldus',
            'author' => 'Cassandra Bouclé',
            'editor' => 'Cassandra Bouclé',
            'isAvailable' => 1,
            'formatId' => 1,
            'userId' => 1
        ]);

        if ($book1 != null)
        {
            return response()->json([
                'message' => 'Données générées'
            ], 200);
        } else {
            return response()->json([
                'message' => 'ISBN Invalide, seul le livre n\'a pas été généré ...'
            ], 205);
        }


    }
}
