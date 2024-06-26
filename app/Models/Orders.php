<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $fillable = [
        'table_id',
        'have_payed',
        'order_time',
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dishes::class , 'orders_dishes' , 'order_nummer' , 'dish_id')->withPivot('amount' , 'price' , 'notation');
    }

    public function Tables()
    {
        return $this->belongsTo(Tables::class);
    }
}
