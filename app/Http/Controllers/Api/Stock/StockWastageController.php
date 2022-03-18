<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\StockWastage;

class StockWastageController extends Controller
{
    //
    public function create(Request $req) {
        
        $validator = Validator::make( $req->all(), [
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantity' => 'required|min:1|max:1000',
            'wastage_date' => 'required|date|after_or_equal:Jan-01-2022',
            'isExpire' => 'required|boolean',
            'remark' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $wastage_date = Carbon::parse($req->wastage_date);
        $isPast = $wastage_date->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"wastage date is in the future",null,201);
        }

        $data = StockWastage::create([
            'stock_item_id' => $req->stock_item_id,
            'quantity' => $req->quantity,
            'wastage_date' => $req->wastage_date,
            'remark' => $req->remark,
            'isExpire' => $req->isExpire
        ]);

        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function update(Request $req) {

        $validator = Validator::make( $req->all(), [
            'quantity' => 'required|min:1|max:1000',
            'wastage_date' => 'required|date|after_or_equal:Jan-01-2022',
            'isExpire' => 'required|boolean',
            'remark' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $wastage_date = Carbon::parse($req->wastage_date);
        $isPast = $wastage_date->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"wastage date is in the future",null,201);
        }

        $item = StockWastage::find($req->id);
        if(!($item)){
            return $this->jsonReponse(false,"No record with given id",null,201);
        }

        $item->update([
            'quantity' => $req->quantity,
            'wastage_date' => $req->wastage_date,
            'remark' => $req->remark,
            'isExpire' => $req->isExpire
        ]);


        return $this->jsonReponse(true,"success",$item,201);
    }

    public function getStockWastageAll(Request $req) {

        $data = StockWastage::orderBy('wastage_date')->get();

        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockWastageItem($id) {

        $data = StockWastage::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockWastageByStckID($stock_id) {

        $data = StockWastage::where('stock_item_id','=',$stock_id)->get();
        
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function deleteStockWastage($id) {
        $data = StockWastage::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }


}
