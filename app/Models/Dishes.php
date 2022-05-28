<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;
    protected $table = 'dishes';
    protected $primaryKey = 'id';

    public $fillable = [
        'categorie_id',
        'dishnumber',
        'dish_addition',
        'name',
        'price',
        'description',
        'spicness_scale',
    ];

    public function Categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function Allergies()
    {
        return $this->belongsToMany(Allergies::class);
    }

    public function Orders()
    {
        return $this->belongsToMany(Orders::class);
    }

    public function Discounts()
    {
        return $this->belongsToMany(HistoryOfDiscounts::class);
    }
}
