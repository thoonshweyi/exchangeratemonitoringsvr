<?php

namespace App\Imports;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExchangeRateImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate data
        $validator = Validator::make($row, [
            'currency' => 'required|string|exists:currencies,code',
            'tt_buy' => 'required|numeric',
            'tt_sell' => 'required|numeric',
            'cash_buy' => 'required|numeric',
            'cash_sell' => 'required|numeric', 
            'earn_buy' => 'required|numeric',
            'earn_sell' => 'required|numeric',
            'record_at' => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

        }

        // $user = $request->user();
        // $user_id = $user->id;
        // Log::info($user_id);

        // $row['currency_id'] = ExchangeRate::where('code',$row['currency'])->first()->id,
        // return new ExchangeRate([
        //     'currency_id' => $row['currency_id'],
        //     'tt_buy' => $row['tt_buy'],
        //     'tt_sell' => $row['tt_sell'],
        //     'cash_buy' => $row['cash_buy'],
        //     'cash_sell' => $row['cash_sell'],
        //     'earn_buy' => $row['earn_buy'],
        //     'earn_sell' => $row['earn_sell'],
        //     'record_at' => $row['record_at'],
        //     'user_id',
        //     'exchange_docu_id',
        //     'tt_updated_datetime',
        //     'cash_updated_datetime',
        //     'earn_updated_datetime',
        // ]);
    }
}
