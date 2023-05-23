<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'editor',
        'isAvailable',
        'formatId',
        'userId'
    ];

    protected $casts = [
        'id' => 'int',
        'isAvailable' => 'boolean',
        'formatId' => 'int',
        'userId' => 'int'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function format()
    {
        return $this->belongsTo(Format::class, 'formatId');
    }
}
