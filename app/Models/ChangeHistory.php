<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    use HasFactory;
    protected $table = "change_histories";
    protected $primaryKey = "id";
    protected $fillable = [
        'currency_id',
        'type',
        'buy',
        'sell',
        'record_at',
        'description',
        'user_id',
        'exchange_docu_id',
        'refexchange_rate_id'
    ];

}
