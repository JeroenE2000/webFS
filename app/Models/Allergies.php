<?php

namespace App\Models;

use App\Models\Dishes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Allergies extends Model
{
    use HasFactory;
    protected $table = 'Allergies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function Dishes()
    {
        return $this->belongsToMany(Dishes::class);
    }
}
