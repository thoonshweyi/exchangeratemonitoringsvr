<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeDocu extends Model
{
    use HasFactory;
    protected $table = "exchange_docus";
    protected $primaryKey = "id";
    protected $fillable = [
        'date',
        'remark',
        'user_id'
    ];
}
