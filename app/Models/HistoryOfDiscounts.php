<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOfDiscounts extends Model
{
    use HasFactory;
    protected $table = 'history_of_discounts';
    protected $primaryKey = 'id';

    public $fillable = [
        'start_time',
        'end_time',
        'discount',
    ];

    public function Dishes()
    {
        return $this->belongsToMany(Dishes::class , 'dishes_history_of_discounts', 'history_of_discounts_id', 'dishes_id');
    }

}
