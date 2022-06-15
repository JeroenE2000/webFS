<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    use HasFactory;
    protected $table = 'tables';
    protected $primaryKey = 'id';

    public $fillable = [
        'guest_amount',
        'table_number',
    ];

    public function Orders()
    {
        return $this->belongsToMany(Orders::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'table_users' , 'table_id' , 'users_id')->withPivot('start_time', 'end_time');
    }

}
