<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\ExchangeDocu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RateCarry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:carry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copied Yesterday Rate and Prepare you user to readily update!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try{


            // Log::info(Carbon::parse($exchangedocu->date)->subDay()); // [2025-09-29 11:22:24] local.INFO: 2025-09-28 11:22:24

            // $yesterdayDoc = ExchangeDocu::whereDate('date', Carbon::parse($exchangedocu->date)->subDay())
            //                 ->orderBy('id', 'desc')
            //                 ->first();

            $yesterdayDoc = ExchangeDocu::orderBy('date','desc')->first();

            $date = Carbon::now();
            $exchangedocu = ExchangeDocu::create([
                'date' => $date,
                'remark' => '',
                'user_id' => 3
            ]);
            Log::info($yesterdayDoc);
            $yesterdayRates = [];
            if ($yesterdayDoc) {
                $yesterdayRates = $yesterdayDoc->exchangerates()
                                ->orderBy('currency_id','asc')
                                ->with('currency')
                                ->get()
                                ->keyBy('currency_id'); // easy to find by currency_id

                foreach ($yesterdayRates as $rate) {
                    $newRate = $rate->replicate();
                    $newRate->exchange_docu_id = $exchangedocu->id;
                    $newRate->record_at = Carbon::now();
                    $newRate->save();
                }
            }

            DB::commit();

        }catch (Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());

            return response()->json(["error"=>$e->getMessage()]);
        }
    }
}
