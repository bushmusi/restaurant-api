<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\StockItem;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockWastage;

class StockItemController extends Controller
{
    //
    public function errMsg() {
        return [
            'name_en.required' => 'Name In English is required',
            'name_am.required' => 'Name In Amharic is required',
            'name_en.unique' => 'Name in English must be unique',
            'name_am.unique' => 'Name in Amharic must be unique',
            'name_en.max' => 'Name in English should not be more 50 character',
            'name_am.max' => 'Name in Amharic should not be more 50 character',
            'si_unit_id.exists' => 'SI Unit  doesn\'t exist',
            'si_unit_id.required' => 'SI Unit is required',
            'department_id.exists' => 'Department doesn\'t exist',
            'department_id.required' => 'Department is required',
        ];
    }
    
    public function createStockItem(Request $req) {

        $validator = Validator::make( $req->all(), [
            'name_en' => 'required|unique:stock_items,name_en|max:50',
            'name_am' => 'required|unique:stock_items,name_am|max:50',
            'si_unit_id' => 'required|exists:si_units,id',
            'department_id' => 'required|exists:departments,id',
            'type' => [ 
                'required', 
                Rule::in(['Consumable','Not-consumable']) ],
        ],$this->errMsg());

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
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
            'id' => 'required',
            'name_en' => 'required|unique:stock_items,name_en,'.$req->id.'|max:50',
            'name_am' => 'required|unique:stock_items,name_am,'.$req->id.'|max:50',
            'si_unit_id' => 'required|exists:si_units,id',
            'department_id' => 'required|exists:departments,id',
            'type' => [ 
                'required', 
                Rule::in(['Consumable','Not-consumable']) ],
        ],$this->errMsg());

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
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


        return $this->jsonReponse(true,"Updated successfully",$item,201);
    }

    public function getStockItemAll(Request $req) {

        $data = StockItem::orderBy('name_en')->get();

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getStockItem($id) {

        $data = StockItem::find($id);

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
        $stockItemIn = StockIn::where('stock_item_id',$id)->get();
        $stockItemOut = StockOut::where('stock_item_id',$id)->get();
        $stockItemWastage = StockWastage::where('stock_item_id',$id)->get();
        if (count($stockItemIn) != '0') {
            return $this->jsonReponse(false,"Stock Item referenced in Stock In",null,202);
        }
        if (count($stockItemOut) != '0') {
            return $this->jsonReponse(false,"Stock Item referenced in Stock Out",null,202);
        }
        if (count($stockItemWastage) != '0') {
            return $this->jsonReponse(false,"Stock Item referenced in Stock Wastage",null,202);
        }

        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }

}
