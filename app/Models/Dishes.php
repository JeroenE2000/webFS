<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dishes extends Model
{
    use HasFactory;
    protected $table = 'dishes';
    protected $primaryKey = 'id';

    public $fillable = [
        'categories_id',
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
        return $this->belongsToMany(Orders::class , 'orders_dishes' , 'dish_id' , 'order_nummer');
    }

    public function Discounts()
    {
        return $this->belongsToMany(HistoryOfDiscounts::class , 'dishes_history_of_discounts' , 'dishes_id' , 'history_of_discounts_id');
    }
}
