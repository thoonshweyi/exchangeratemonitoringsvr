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
    public function index()
    {
        $exchangedocus = ExchangeDocu::paginate(10);


        return $this->sendRespond(ExchangeDocusResource::collection($exchangedocus),"Exchange Docus retrived successfully");

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
                'user_id' => 1
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
                    'user_id' => 1
                ]);
            }
            DB::commit();
            return $this->sendRespond(NULL,"Exchange saved successfully");

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

        $exchangeObj = [
            'id' => $exchangedocu->id,
            'date' =>  $exchangedocu->date,
            'remark' => $exchangedocu->remark,
            'user_id' => $exchangedocu->user_id,

            // 'exchangerates' => $exchangedocu->exchangerates()->orderBy("id",'asc')->get()->map(function ($question) {

            // })

            'exchangerates' => ExchangeRate::all()
        ];

        return response()->json($exchangeObj);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
