<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;


class IsbnValidTest extends TestCase
{
    /** @test */
    public function isbn_valid_test()
    {
        $isbnCorrectLengthCorrectFormatValid = "2490334166";
        $isbnCorrectLengthCorrectFormatFalse = "1234567890";
        $isbnIncorrectLengthCorrectFormatFalse = "1234567";
        $isbnCorrectLengthIncorrectFormatFalse = "24I033F166";
        $isbnIncorrectLengthIncorrectFormatFalse = "12F45G7";

        $this->assertTrue($this->isbnCheck($isbnCorrectLengthCorrectFormatValid));
        $this->assertTrue(!$this->isbnCheck($isbnCorrectLengthCorrectFormatFalse));
        $this->assertTrue(!$this->isbnCheck($isbnIncorrectLengthCorrectFormatFalse));
        $this->assertTrue(!$this->isbnCheck($isbnCorrectLengthIncorrectFormatFalse));
        $this->assertTrue(!$this->isbnCheck($isbnIncorrectLengthIncorrectFormatFalse));
    }

    public function isbnCheck($isbn)
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
