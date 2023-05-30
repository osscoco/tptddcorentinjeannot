<?php

namespace App\Managers;

use App\Models\Book;
use App\Models\Format;
use App\Models\User;
use Illuminate\Support\Str;

class BookManager
{
    public function create(array $data)
    {
        if ($data['isbn'])
        {
            if ($this->isbnValid($data['isbn']))
            {
                if ($data['userId'] !== "undefined")
                {
                    Format::findOrFail($data['formatId']);
                    User::findOrFail($data['userId']);

                    $book = Book::create([
                        'isbn' => $data['isbn'],
                        'title' => $data['title'],
                        'author' => $data['author'],
                        'editor' => $data['editor'],
                        'isAvailable' => $data['isAvailable'],
                        'formatId' => $data['formatId'],
                        'userId' => $data['userId']
                    ]);
                } else {

                    Format::findOrFail($data['formatId']);

                    $book = Book::create([
                        'isbn' => $data['isbn'],
                        'title' => $data['title'],
                        'author' => $data['author'],
                        'editor' => $data['editor'],
                        'isAvailable' => $data['isAvailable'],
                        'formatId' => $data['formatId'],
                        'userId' => NULL
                    ]);
                }

                $book->save();

                return $book;
            } else {
                return null;
            }
        }

    }

    public function update(Book $book, array $data)
    {
        if ($data['isbn'])
        {
            if ($this->isbnValid($data['isbn']))
            {
                Format::findOrFail($data['formatId']);
                User::findOrFail($data['userId']);

                $book->isbn = $data['isbn'];
                $book->title = $data['title'];
                $book->author = $data['author'];
                $book->editor = $data['editor'];
                $book->isAvailable = $data['isAvailable'];
                $book->formatId = $data['formatId'];
                $book->userId = $data['userId'];
                $book->save();

                return $book;
            } else {
                return null;
            }
        }
    }

    public function delete(Book $book)
    {
        return $book->delete();
    }

    public function isbnValid($isbn)
    {
        if (Str::length($isbn) != 10) {
            //throw new \Exception("ISBN must be composed of 10 numeric characters!");
            return false;
        }

        $arrayIsbn = Str::slug($isbn, "");
        $total = 0;

        for ($i = 0; $i < 10; $i++) {
            if (!is_numeric($arrayIsbn[$i])) {
                //throw new \Exception("ISBN must be numeric !");
                return false;
            }
            $total = $total + $arrayIsbn[$i] * (10-$i);
        }

        if ( !(($total % 11) == 0) ) {
            //throw new \Exception("ISBN must be valid !");
            return false;
        } else {
            return true;
        }
    }
}
