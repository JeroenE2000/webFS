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
        'count',
        'price',
        'status',
    ];

    public function Dishes()
    {
        return $this->belongsToMany(Dishes::class);
    }

    public function Tables()
    {
        return $this->belongsTo(Tables::class);
    }
}
