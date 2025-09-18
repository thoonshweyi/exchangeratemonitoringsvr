<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function index()
    {
            // $this->authorize('view',City::class);
        $currencies = Currency::where(function($query){
            if($getname = request("filtername")){
                $query->where("name","LIKE","%".$getname."%");
            }
        })->get();
        // dd($currencies);

        $statuses = Status::whereIn("id",[3,4])->get();
        return view("currencies.index",compact("currencies","statuses"));
    }
}
