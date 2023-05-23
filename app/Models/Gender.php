<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'genders';
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
        return $this->hasMany(User::class, 'genderId');
    }
}
