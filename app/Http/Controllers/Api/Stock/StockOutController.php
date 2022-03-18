<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StockOut;
use Carbon\Carbon;

class StockOutController extends Controller
{
    //
    public function create(Request $req) {
        
        $validator = Validator::make( $req->all(), [
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantity' => 'required|min:1|max:1000',
            'outdate' => 'required|date|after_or_equal:Jan-01-2022',
            'remark' => 'required|max:255',
            'employee_id' => 'required|exists:employees,id'
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $outdate = Carbon::parse($req->outdate);
        $isPast = $outdate->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"outdate is in the future",null,201);
        }

        $data = StockOut::create([
            'stock_item_id' => $req->stock_item_id,
            'quantity' => $req->quantity,
            'outdate' => $req->outdate,
            'remark' => $req->remark,
            'employee_id' => $req->employee_id
        ]);

        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function update(Request $req) {
        $validator = Validator::make( $req->all(), [
            'quantity' => 'required|min:1|max:1000',
            'outdate' => 'required|date|after_or_equal:Jan-01-2022',
            'remark' => 'required|max:255',
            'employee_id' => 'required|exists:employees,id'
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $outdate = Carbon::parse($req->outdate);
        $isPast = $outdate->isPast();
        if(!($isPast)) {
            return $this->jsonReponse(false,"outdate is in the future",null,201);
        }

        $item = StockOut::find($req->id);
        if(!($item)){
            return $this->jsonReponse(false,"No record with given id",null,201);
        }

        $item->update([
            'quantity' => $req->quantity,
            'outdate' => $req->outdate,
            'remark' => $req->remark,
            'employee_id' => $req->employee_id
        ]);


        return $this->jsonReponse(true,"success",$item,201);
    }

    public function getStockOutAll(Request $req) {

        $data = StockOut::orderBy('outdate')->get();

        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockOutItem($id) {

        $data = StockOut::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockOutByStckID($stock_id) {

        $data = StockOut::where('stock_item_id','=',$stock_id)->get();
        
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function deleteStockOut($id) {
        $data = StockOut::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }
}
