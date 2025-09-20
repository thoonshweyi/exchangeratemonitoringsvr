<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;
    protected $table = "exchange_rates";
    protected $primaryKey = "id";
    protected $fillable = [
        'currency_id',
        'tt_buy',
        'tt_sell',
        'cash_buy',
        'cash_sell',
        'earn_buy',
        'earn_sell',
        'record_at',
        'description',
        'user_id'
    ];
}
