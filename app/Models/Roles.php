<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
    ];

    public function Users()
    {
        return $this->belongsToMany(Users::class);
    }
}
