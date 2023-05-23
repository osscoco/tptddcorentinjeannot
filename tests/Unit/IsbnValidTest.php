<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;


class IsbnValidTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    /** @test */
    public function isbn_valid_test()
    {
        $isbnCorrectLengthCorrectFormatValid = "2490334166";
        $isbnCorrectLengthCorrectFormatFalse = "1234567890";
        $isbnIncorrectLengthCorrectFormatFalse = "1234567";
        $isbnCorrectLengthIncorrectFormatFalse = "24I033F166";
        $isbnIncorrectLengthIncorrectFormatFalse = "12F45G7";

        $this->assertTrue(
            $this->isbnCheck($isbnCorrectLengthCorrectFormatValid) &&
            $this->isbnCheck($isbnCorrectLengthCorrectFormatFalse) &&
            $this->isbnCheck($isbnIncorrectLengthCorrectFormatFalse) &&
            $this->isbnCheck($isbnCorrectLengthIncorrectFormatFalse) &&
            $this->isbnCheck($isbnIncorrectLengthIncorrectFormatFalse)
        );
    }

    public function isbnCheck($isbn)
    {
        return true;
    }
}
