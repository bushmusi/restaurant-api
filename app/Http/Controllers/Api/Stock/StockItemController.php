<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\StockItem;
use App\Models\StockIn;
use App\Models\StockOut;

class StockItemController extends Controller
{
    //
    public function createStockItem(Request $req) {

        $validator = Validator::make( $req->all(), [
            'name_en' => 'required|unique:stock_items,name_en|max:50',
            'name_am' => 'required|unique:stock_items,name_am|max:50',
            'si_unit_id' => 'required|exists:si_units,id',
            'department_id' => 'required|exists:departments,id',
            'type' => [ 
                'required', 
                Rule::in(['Consumable','Not-consumable']) ],
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $data = StockItem::create([
            'name_en' => $req->name_en,
            'name_am' => $req->name_am,
            'si_unit_id' => $req->si_unit_id,
            'type' => $req->type,
            'department_id' => $req->department_id
        ]);

        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function updateStockItem(Request $req) {

        $validator = Validator::make( $req->all(), [
            'name_en' => 'required|unique:stock_items,name_en|max:50',
            'name_am' => 'required|unique:stock_items,name_am|max:50',
            'si_unit_id' => 'required|exists:si_units,id',
            'department_id' => 'required|exists:departments,id',
            'type' => [ 
                'required', 
                Rule::in(['Consumable','Not-consumable']) ],
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }
        
        $item = StockItem::find($req->id);
        if(!($item)){
            return $this->jsonReponse(false,"No record with given id",null,201);
        }

        $data = $item->update([
            'name_en' => $req->name_en,
            'name_am' => $req->name_am,
            'si_unit_id' => $req->si_unit_id,
            'type' => $req->type,
            'department_id' => $req->department_id
        ]);


        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function getStockItemAll(Request $req) {

        $data = StockItem::orderBy('name_en')->get();

        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockItem($id) {

        $data = StockItem::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function filterData(Request $req) {

        $query = StockItem::query();

        foreach ($req->toArray() as $key=>$value) {
            $query->orWhere($key, 'like', '%'.$value.'%');
        }

        $data = $query->get();
        return $this->jsonReponse(true,"Fetched successfully",$data,202);
    }

    public function deleteStockItem($id) {
        $data = StockItem::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }

}
