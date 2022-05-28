<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
    ];

    public function Dishes()
    {
        return $this->belongsToMany(Dishes::class);
    }
}
