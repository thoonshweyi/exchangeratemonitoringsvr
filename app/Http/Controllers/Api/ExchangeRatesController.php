<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\ExchangeDocu;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Models\ChangeHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExchangeDocusResource;

class ExchangeRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request['record_at'] = Carbon::now();
        $exchangerate = ExchangeRate::findOrFail($id);

        $newChange = $request->newChange;
        $type = $request->selectedType;
        $past_record_at = $exchangerate->record_at;
        $past_buy = $exchangerate[$type."_buy"];
        $past_sell = $exchangerate[$type."_sell"];

        $exchangerate->update($request->all());

        $changehistory =  [];
        if($newChange == true){
            $type = $request->selectedType;

            $changehistory = ChangeHistory::create([
                'currency_id' => $exchangerate->currency_id,
                'type'=> $type,
                'buy'=> $past_buy,
                'sell'=> $past_sell,
                'record_at'=> $past_record_at,
                'description'=> $exchangerate->description,
                'user_id' => $request->user()->id,
                'exchange_docu_id'=> $exchangerate->exchange_docu_id,
                'refexchange_rate_id'=> $exchangerate->id
            ]);
            $changehistory->load('user');
        }

        return response()->json([
            "data"=>$exchangerate,
            "changehistory"=> $changehistory ,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function detail(Request $request,string $id){
        $exchangerate = ExchangeRate::findOrFail($id);
        $currency_id = $exchangerate->currency_id;

        $exchangedocus = ExchangeDocu::orderBy('date','desc')
        ->where('id',"!=",$id)
        ->limit(10)->get();


        $histories = $exchangedocus->map(function($exchangedocu,$idx) use($currency_id){
            $yesterdayDoc = ExchangeDocu::whereDate('date', Carbon::parse($exchangedocu->date)->subDay())
                        ->orderBy('id', 'desc')
                        ->first();
            $yesterdayRates = [];
            if ($yesterdayDoc) {
                $yesterdayRates = $yesterdayDoc->exchangerates()
                                ->with('currency')
                                ->get()
                                ->keyBy('currency_id'); // easy to find by currency_id
            }


            return [
                'id' => $exchangedocu->id,
                'date' => Carbon::parse($exchangedocu->date)->format('D, M d, Y'),
                'remark' => $exchangedocu->remark,
                'user_id' => $exchangedocu->user_id,
                'created_at' => $exchangedocu->created_at->format('d-m-Y h:i:s A'),
                'updated_at' => $exchangedocu->updated_at->format('d-m-Y h:i:s A'),


                'exchangerates' => $exchangedocu->exchangerates()->with('currency')
                                    ->where('currency_id',$currency_id)
                                    ->get()
                                    ->map(function ($exchangerate) use ($yesterdayRates,$currency_id) {
                                        $yesterdayrate = $yesterdayRates[$exchangerate->currency_id] ?? null;
                                        $changehistories = $exchangerate->changehistory()->orderBy('record_at','desc')->with('user')->get();


                                        $diffs = [
                                                // diffs
                                            'diff_tt_buy'  => $yesterdayrate ? $exchangerate->tt_buy - $yesterdayrate->tt_buy : null,
                                            'diff_tt_sell' => $yesterdayrate ? $exchangerate->tt_sell - $yesterdayrate->tt_sell : null,
                                            'diff_cash_buy'  => $yesterdayrate ? $exchangerate->cash_buy - $yesterdayrate->cash_buy : null,
                                            'diff_cash_sell' => $yesterdayrate ? $exchangerate->cash_sell - $yesterdayrate->cash_sell : null,
                                            'diff_earn_buy'  => $yesterdayrate ? $exchangerate->earn_buy - $yesterdayrate->earn_buy : null,
                                            'diff_earn_sell' => $yesterdayrate ? $exchangerate->earn_sell - $yesterdayrate->earn_sell : null,
                                        ];
                                        if($changehistories->count() > 0){

                                            $count = $changehistories->count();
                                            $lastchangehistory_tt = $changehistories->where("type",'tt')->first();
                                            $lastchangehistory_cash = $changehistories->where("type",'cash')->first();
                                            $lastchangehistory_earn = $changehistories->where("type",'earn')->first();
                                            // Log::info($lastchangehistory_tt);

                                            if($lastchangehistory_tt){
                                                $diffs['diff_tt_buy']  = $lastchangehistory_tt ? $exchangerate->tt_buy - $lastchangehistory_tt->buy : null;
                                                $diffs['diff_tt_sell'] = $lastchangehistory_tt ? $exchangerate->tt_sell - $lastchangehistory_tt->sell : null;
                                            }

                                            if($lastchangehistory_cash){
                                                $diffs['diff_cash_buy']  = $lastchangehistory_cash ? $exchangerate->tt_buy - $lastchangehistory_cash->buy : null;
                                                $diffs['diff_cash_buy'] = $lastchangehistory_cash ? $exchangerate->tt_sell - $lastchangehistory_cash->sell : null;
                                            }

                                            if($lastchangehistory_earn){
                                                $diffs['diff_earn_buy']  = $lastchangehistory_earn ? $exchangerate->tt_buy - $lastchangehistory_earn->buy : null;
                                                $diffs['diff_earn_buy'] = $lastchangehistory_earn ? $exchangerate->tt_sell - $lastchangehistory_earn->sell : null;
                                            }

                                        }
                                        return [
                                            ...$exchangerate->toArray(),
                                            ...$diffs,


                                            'updated_time' => $exchangerate->updated_at->format('h:i A'),

                                            // change historires
                                            'changehistories'=> $changehistories
                                                ->map(function($changehistory,$idx) use ($yesterdayrate,$changehistories){
                                                    // $prevchangehistory = $idx > 0 ? $changehistories[$idx - 1] : null; // order by asc

                                                    $prevchangehistory = $idx < $changehistories->count() - 1 ? $changehistories[$idx + 1] : null;
                                                    // Log::info($prevchangehistory);

                                                    if($prevchangehistory){
                                                        return [
                                                            ...$changehistory->toArray(),
                                                            'updated_time' => Carbon::parse($changehistory->record_at)->format('h:i A'),

                                                            "diff_".$changehistory->type."_buy"  => $prevchangehistory ? $changehistory->buy - $prevchangehistory->buy : null,
                                                            "diff_".$changehistory->type."_sell" => $prevchangehistory ? $changehistory->sell - $prevchangehistory->sell : null,
                                                        ];
                                                    }
                                                    return [
                                                        ...$changehistory->toArray(),
                                                        'updated_time' => Carbon::parse($changehistory->record_at)->format('h:i A'),

                                                        "diff_".$changehistory->type."_buy"  => $yesterdayrate ? $changehistory->buy - $yesterdayrate[$changehistory->type."_buy"] : null,
                                                        "diff_".$changehistory->type."_sell" => $yesterdayrate ? $changehistory->sell - $yesterdayrate[$changehistory->type."_sell"] : null,
                                                    ];
                                                })
                                        ];
                                    })
            ];
        });

        return response()->json($histories);
    }
}
