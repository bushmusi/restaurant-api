<?php

namespace App\Http\Controllers\Api\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\Catagory;
use App\Models\Menu\MenuCatagory;
use Illuminate\Support\Facades\Validator;

class CatagoryController extends Controller
{
    //
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
                'cat_name' => 'required|unique:catagories,cat_name|max:50',
            ],
             [
                 'cat_name.required' => 'Catagory name is required',
             ]   
        );

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $key => $value){
                return $this->jsonReponse(false,$value[0],null,201);
            }
        }
        
        $catagory = Catagory::create([
            'cat_name' => $request->cat_name
        ]);

        return $this->jsonReponse(true,'success',$catagory,201);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:catagories,id',
            'cat_name' => 'required|unique:catagories,cat_name,'. $request->id.'|max:50',

        ]);

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $key => $value){
                return $this->jsonReponse(false,$value[0],null,201);
            }
        }

        $value = Catagory::find($request->id);

        if($value){

            $value->cat_name = $request->cat_name;
            $value->save();
            return $this->jsonReponse(true,'success',$value,201);
        }
    }

    public function getAll(Request $request){

        $data = Catagory::orderBy('cat_name')->get();

        return $this->jsonReponse(true,"Success",$data,200);
    }

    public function get($id) {
        $data = Catagory::find($id);
        return $this->jsonReponse(true,'success',$data,200);
    }

    public function delete($id) {
        $data = Catagory::find($id);
        $checkMenuCatagory = MenuCatagory::where('catagories_id',$id)->get();
        if(count($checkMenuCatagory) != '0') {
            return $this->jsonReponse(false,'Can not be deleted id is referenced Menu Catagory Table',null,200);
        }

        if(!($data)) {
            return $this->jsonReponse(false,'No data with give id',null,200);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,'success',$old,200);
    }
}
