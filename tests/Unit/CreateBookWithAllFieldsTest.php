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
                'label' => Str::random(10)
            )
        )->id;

        $genderId = Gender::create(
            array(
                'label' => Str::random(10)
            )
        )->id;

        Format::create(
            array(
                'label' => Str::random(10)
            )
        );

        User::create(
            array(
                'email' => Str::random(10) . "@gmail.com",
                'password' => Hash::make('password'),
                'firstname' => Str::random(10),
                'lastname' => Str::random(10),
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
                'isbn' => Str::random(10),
                'title' => Str::random(10),
                'author' => Str::random(10),
                'editor' => Str::random(10),
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

