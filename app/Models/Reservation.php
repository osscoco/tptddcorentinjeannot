<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'bookId',
        'label',
        'dateLimit'
    ];

    protected $casts = [
        'id' => 'int',
        'userId' => 'int',
        'bookId' => 'int',
        'dateLimit' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'bookId');
    }
}
