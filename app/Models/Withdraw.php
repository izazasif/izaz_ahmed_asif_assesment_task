<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $table = 'withdraws';
    protected $fillable = [
     'user_id','balance','charge'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
