<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = "currencies";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'slug',
        'code',
        'status_id',
        'user_id',
    ];


}
