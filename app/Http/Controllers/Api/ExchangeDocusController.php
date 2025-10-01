<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\ExchangeDocu;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExchangeDocusResource;

class ExchangeDocusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $exchangedocus = ExchangeDocu::orderBy('date','desc')->paginate(10);
        $results = ExchangeDocu::query();

        $document_from_date     = $request->from_date;
        $document_to_date       = $request->to_date;

        if (!empty($document_from_date) || !empty($document_to_date)) {
            if($document_from_date === $document_to_date)
            {
                $results = $results->whereDate('date', $document_from_date);
            }
            else
            {

                if($document_from_date && $document_to_date){
                    $from_date = Carbon::parse($document_from_date);
                    $to_date = Carbon::parse($document_to_date)->endOfDay();
                    $results = $results->whereBetween('date', [$from_date , $to_date]);
                }
                if($document_from_date)
                {
                    $from_date = Carbon::parse($document_from_date);
                    $results = $results->whereDate('date', ">=",$from_date);
                }
                if($document_to_date)
                {
                    $to_date = Carbon::parse($document_to_date)->endOfDay();
                    $results = $results->whereDate('date',"<=", $to_date);
                }

            }
        }

        $exchangedocus = $results->orderBy('date','desc')->paginate(10);


        // return $this->sendRespond(ExchangeDocusResource::collection($exchangedocus),"Exchange Docus retrived successfully");
        return response()->json([
            "data" => ExchangeDocusResource::collection($exchangedocus),
            "meta" => [
                "current_page" => $exchangedocus->currentPage(),
                "last_page" => $exchangedocus->lastPage(),
                "per_page" => $exchangedocus->perPage(),
                "total" => $exchangedocus->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'form_id' => 'required|exists:forms,id',
        //     'questionanswers' => 'required|array',
        //     'branch_id' => 'required|exists:branches,id',
        // ], [
        //     'form_id.required' => 'Form ID is required.',
        //     'form_id.exists' => 'Invalid Form.',
        //     'questionanswers.required' => 'Answers are required.',
        //     'questionanswers.array' => 'Answers must be an array.',
        //     'branch_id.required' => 'From Branch is required.',
        //     'branch_id.exists' => 'Invalid Branch.',
        // ]);

        // if($validator->fails()){
        //     return response()->json(["errors"=>$validator->errors()],422);
        // }

         DB::beginTransaction();
        try{


            $date = $request->date;
            $exchangeratesData = $request->exchangerates;

            $exchangedocu = ExchangeDocu::create([
                'date' => $date,
                'remark' => '',
                'user_id' => $request->user()->id
            ]);

            foreach($exchangeratesData as $currencyId=>$currencyObj){
                $exchangerate = ExchangeRate::create([
                    'currency_id' => $currencyId,
                    'tt_buy' => $currencyObj["tt"]["buy"],
                    'tt_sell' => $currencyObj["tt"]["sell"],
                    'cash_buy' => $currencyObj["cash"]["buy"],
                    'cash_sell' => $currencyObj["cash"]["sell"],
                    'earn_buy' => $currencyObj["earn"]["buy"],
                    'earn_sell' => $currencyObj["earn"]["sell"],
                    'record_at' => Carbon::now(),
                    'description' => '',
                    'user_id' => $request->user()->id,
                    'exchange_docu_id' => $exchangedocu->id
                ]);
            }
            DB::commit();
            return $this->sendRespond($exchangedocu,"Exchange saved successfully");

        }catch (Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());

            return response()->json(["error"=>$e->getMessage()]);
        }


    }
     // foreach($exchangeratesData as $currencyId=>$currencyObj){
        //     foreach($currencyObj as $type=>$typeObj){
        //         foreach($typeObj as $side=>$value){

        //         }
        //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exchangedocu = ExchangeDocu::findOrFail($id);
        $currencies = Currency::where("status_id",3)->get();

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

        $exchangeObj = [
            'id' => $exchangedocu->id,
            'date' =>  Carbon::parse($exchangedocu->date)->format("Y-m-d"),
            'remark' => $exchangedocu->remark,
            'user_id' => $exchangedocu->user_id,

            // 'exchangerates' => $exchangedocu->exchangerates()->orderBy('currency_id','asc')->with('currency')->get()



            'exchangerates' => $exchangedocu->exchangerates()->orderBy('currency_id','asc')->with('currency')->get()
                                ->map(function ($exchangerate) use ($yesterdayRates) {
                                    $yesterdayrate = $yesterdayRates[$exchangerate->currency_id] ?? null;
                                    return [
                                        ...$exchangerate->toArray(),

                                        // yesterdayrates
                                        'yes_tt_buy' => $yesterdayrate ? $yesterdayrate->tt_buy : null,
                                        'yes_tt_sell' => $yesterdayrate ? $yesterdayrate->tt_sell : null,
                                        'yes_cash_buy' => $yesterdayrate ? $yesterdayrate->cash_buy : null,
                                        'yes_cash_sell' => $yesterdayrate ? $yesterdayrate->cash_sell : null,
                                        'yes_earn_buy' => $yesterdayrate ? $yesterdayrate->earn_buy : null,
                                        'yes_earn_sell' => $yesterdayrate ? $yesterdayrate->earn_sell : null,


                                        // change historires
                                        'changehistories'=> $exchangerate->changehistory()->orderBy('record_at','desc')->with('user')->get()
                                        ->map(function($changehistory){
                                            return [
                                                ...$changehistory->toArray()
                                            ];
                                        })
                                    ];
                                })
        ];

        return response()->json($exchangeObj);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        Log::info($request->user()->id);
        DB::beginTransaction();
        try{


            $exchangedocu = ExchangeDocu::findOrFail($id);

            $date = $request->date;
            $exchangedocu->update([
                'date' => $date,
                'remark' => '',
                'user_id' => $request->user()->id
            ]);

            $exchangerateDatas = $request->exchangerates;
            foreach($exchangerateDatas as $exchangerateData){
                // Log::info($exchangerateData);
                $exchangerate = ExchangeRate::findOrFail($exchangerateData['id']);
                $exchangerate->update([
                    'currency_id' => $exchangerateData['currency_id'],
                    'tt_buy' => $exchangerateData['tt_buy'],
                    'tt_sell' => $exchangerateData['tt_sell'],
                    'cash_buy' => $exchangerateData['cash_buy'],
                    'cash_sell' => $exchangerateData['cash_sell'],
                    'earn_buy' => $exchangerateData['earn_buy'],
                    'earn_sell' => $exchangerateData['earn_sell'],
                    // 'record_at' => Carbon::now(),
                    'description' => '',
                    'user_id' => $request->user()->id
                ]);
            }

            DB::commit();
            return $this->sendRespond($exchangedocu,"Exchange updated successfully");


         }catch (Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());

            return response()->json(["error"=>$e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function todayDashboard(){
        $exchangedocu = ExchangeDocu::orderBy('date', 'desc')->first();
        $currencies = Currency::where("status_id",3)->get();

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

        $exchangeObj = [
            'id' => $exchangedocu->id,
            'date' => Carbon::parse($exchangedocu->date)->format('D, M d, Y'),
            'remark' => $exchangedocu->remark,
            'user_id' => $exchangedocu->user_id,
            'created_at' => $exchangedocu->created_at->format('d-m-Y h:i:s A'),
            'updated_at' => $exchangedocu->updated_at->format('d-m-Y h:i:s A'),


            'exchangerates' => $exchangedocu->exchangerates()->orderBy('currency_id','asc')->with('currency')->get()
                                ->map(function ($exchangerate) use ($yesterdayRates) {
                                    $yesterdayrate = $yesterdayRates[$exchangerate->currency_id] ?? null;
                                    return [
                                        ...$exchangerate->toArray(),

                                        // diffs
                                        'diff_tt_buy'  => $yesterdayrate ? $exchangerate->tt_buy - $yesterdayrate->tt_buy : null,
                                        'diff_tt_sell' => $yesterdayrate ? $exchangerate->tt_sell - $yesterdayrate->tt_sell : null,
                                        'diff_cash_buy'  => $yesterdayrate ? $exchangerate->cash_buy - $yesterdayrate->cash_buy : null,
                                        'diff_cash_sell' => $yesterdayrate ? $exchangerate->cash_sell - $yesterdayrate->cash_sell : null,
                                        'diff_earn_buy'  => $yesterdayrate ? $exchangerate->earn_buy - $yesterdayrate->earn_buy : null,
                                        'diff_earn_sell' => $yesterdayrate ? $exchangerate->earn_sell - $yesterdayrate->earn_sell : null,
                                    ];
                                })
        ];

        return response()->json($exchangeObj);
    }


    public function weeklyDashboard(){
        $currencies = Currency::where('status_id',3)->orderBy('id','asc')->pluck('code','id');
        // dd($currencies);
        $fields = ['tt','cash','earn'];

        $exchangedocus = ExchangeDocu::orderBy('id','asc')
        ->limit(7)->get();

        $result = [];
        foreach($currencies as $id=>$currency){
            foreach($fields as $field){
                $rows = [];
                $rows[] = ["Date", $currency];
                foreach($exchangedocus as $exchangedocu){
                    $rate =$exchangedocu->exchangerates->firstWhere('currency_id', $id);
                    if ($rate) {
                        $rows[] = [
                            Carbon::parse($exchangedocu->date)->format('Y-m-d'),
                            (float) $rate["${field}_buy"] // or $rate->cash, $rate->earn
                        ];
                    }
                }
                $result[$currency][$field] = $rows;

            }

        }
        return response()->json($result);


    }
}
// const chartData = {
//   USD: [
//     ["Date", "USD"],
//     ["2025-09-17", 2100],
//     ["2025-09-18", 2120],
//     ["2025-09-19", 2110],
//     ["2025-09-20", 2130],
//     ["2025-09-21", 2140],
//     ["2025-09-22", 2135],
//     ["2025-09-23", 2125],
//   ],
//   THB: [
//     ["Date", "THB"],
//     ["2025-09-17", 60],
//     ["2025-09-18", 59.5],
//     ["2025-09-19", 59.8],
//     ["2025-09-20", 60.2],
//     ["2025-09-21", 61],
//     ["2025-09-22", 60.7],
//     ["2025-09-23", 60.4],
//   ],
