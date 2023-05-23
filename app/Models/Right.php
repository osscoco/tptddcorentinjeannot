<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    protected $table = 'rights';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'label'
    ];

    protected $casts = [
        'id' => 'int'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'righId');
    }
}
