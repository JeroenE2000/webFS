<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationItems extends Model
{
    use HasFactory;
    protected $table = 'navigation_items';
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'url',
    ];
}
