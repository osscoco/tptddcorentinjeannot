<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'formats';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'label'
    ];

    protected $casts = [
        'id' => 'int'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'bookId');
    }
}
