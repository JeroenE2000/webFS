<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dishes extends Model
{
    use HasFactory, Searchable;
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


    public function toSearchableArray()
    {
        return [
            'dishnumber' => $this->dishnumber,
            'dish_addition'=> $this->dish_addition,
            'name' => $this->name,
            'price'=> $this->price,
            'description' => $this->description,
            'spicness_scale' => $this->spicness_scale,
            'categorie_Id' => $this->categorie_id,
        ];
    }

    public function Categories()
    {
        return $this->belongsTo(Categories::class , 'categorie_id');
    }

    public function Allergies()
    {
        return $this->belongsToMany(Allergies::class);
    }

    public function Orders()
    {
        return $this->belongsToMany(Orders::class , 'orders_dishes' , 'dish_id' , 'order_id');
    }

    public function Discounts()
    {
        return $this->belongsToMany(HistoryOfDiscounts::class);
    }
}
