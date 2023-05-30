<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Format;
use App\Models\Gender;
use App\Models\Right;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Tests\TestCase;

class CreateBookWithAllFieldsTest extends TestCase
{
    /** @test */
    public function create_book_with_all_fields_test()
    {
        $this->assertTrue($this->create_book_with_all_fields_test_check());
    }

    public function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('formats')->truncate();
        DB::table('genders')->truncate();
        DB::table('rights')->truncate();
        DB::table('users')->truncate();
        DB::table('books')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function tableToInsertBefore()
    {
        $rightId = Right::create(
            array(
                'label' => "Admin"
            )
        )->id;

        $genderId = Gender::create(
            array(
                'label' => "Male"
            )
        )->id;

        Format::create(
            array(
                'label' => "Broché"
            )
        );

        User::create(
            array(
                'email' => "corentin.jeannot2a@gmail.com",
                'password' => Hash::make('Not24get'),
                'firstname' => "corentin",
                'lastname' => "jeannot",
                'dateOfBirth' => Carbon::now(),
                'genderId' => $genderId,
                'rightId' => $rightId
            )
        );
    }

    public function create_book_with_all_fields_test_check()
    {
        $this->truncate();

        $this->tableToInsertBefore();

        $bookIdValid = Book::create(
            array(
                'isbn' => '2490334166',
                'title' => 'titre 1',
                'author' => 'Auteur 1',
                'editor' => 'Editeur 1',
                'isAvailable' => 1,
                'formatId' => 1,
                'userId' => 1
            )
        )->id;

        if ($bookIdValid != 'undefined') {
            return true;
        }
        else {
            return false;
        }
    }
}

