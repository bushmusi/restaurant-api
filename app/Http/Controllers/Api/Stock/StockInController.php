<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StockIn;
use Carbon\Carbon;

class StockInController extends Controller
{
    //
    public function create(Request $req) {
        
        $validator = Validator::make( $req->all(), [
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantity' => 'required|min:1|max:1000',
            'indate' => 'required|date|after_or_equal:Jan-01-2022',
            'remark' => 'required|max:255'
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $inDate = Carbon::parse($req->indate);
        $isPast = $inDate->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"InDate is in the future",null,201);
        }

        $data = StockIn::create([
            'stock_item_id' => $req->stock_item_id,
            'quantity' => $req->quantity,
            'indate' => $req->indate,
            'remark' => $req->remark
        ]);

        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function update(Request $req) {
        $validator = Validator::make( $req->all(), [
            'quantity' => 'required|min:1|max:1000',
            'indate' => 'required|date|after_or_equal:Jan-01-2022',
            'remark' => 'required|max:255'
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $inDate = Carbon::parse($req->indate);
        $isPast = $inDate->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"InDate is in the future",null,201);
        }

        $item = StockIn::find($req->id);
        if(!($item)){
            return $this->jsonReponse(false,"No record with given id",null,201);
        }

        $item->update([
            'quantity' => $req->quantity,
            'indate' => $req->indate,
            'remark' => $req->remark
        ]);


        return $this->jsonReponse(true,"success",$item,201);
    }

    public function getStockInAll(Request $req) {

        $data = StockIn::orderBy('indate')->get();

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockInItem($id) {

        $data = StockIn::find($id);

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockInByStckID($stock_id) {

        $data = StockIn::where('stock_item_id','=',$stock_id)->get();

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function deleteStockIn($id) {
        $data = StockIn::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }
}
