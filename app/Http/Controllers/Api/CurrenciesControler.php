<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrenciesResource;

class CurrenciesControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Currency::where("status_id",3)->get();
        return  CurrenciesResource::collection($statuses);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|unique:currencies,name",
            "code" => "required",
            "status_id" => "required",
            "user_id" => "required"
         ]);

        $currency = new Currency();
            // $this->authorize('create',$currency);
        $currency->name = $request["name"];
        $currency->code = $request["code"];
        $currency->slug = Str::slug($request["name"]);
        $currency->status_id = $request["status_id"];
        $currency->user_id = $request["user_id"];

        $currency->save();

        return new CurrenciesResource($currency);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = Currency::findOrFail($id);
        return response()->json($currency);
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, string $id)
     {
         $this->validate($request,[
             "editname" => "required|unique:currencies,name,".$id,
             "editstatus_id" => "required",
             "user_id" => "required"
         ]);

        $currency = Currency::findOrFail($id);
            // $this->authorize('edit',$city);
        $currency->name = $request["editname"];
        $currency->code = $request["editcode"];
        $currency->slug = Str::slug($request["editname"]);
        $currency->status_id = $request["editstatus_id"];
        $currency->user_id = $request["user_id"];

        $currency->save();

        return new CurrenciesResource($currency);

     }
    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
     {
         $currency = Currency::findOrFail($id);
         $currency->delete();
         return new Currency($currency);
     }

    public function typestatus(Request $request){
        $currency = Currency::findOrFail($request["id"]);
        $currency->status_id = $request["status_id"];
        $currency->save();

        return new CurrenciesResource($currency);

    }


}
