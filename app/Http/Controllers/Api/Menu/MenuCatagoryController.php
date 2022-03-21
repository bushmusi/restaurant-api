<?php

namespace App\Http\Controllers\Api\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Menu\MenuCatagory;

class MenuCatagoryController extends Controller
{
    //
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'menus_id' => 'required|exists:menus,id',
            'catagories_id' => 'required|exists:catagories,id',
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = MenuCatagory::create([
            'menus_id' => $request->menus_id,
            'catagories_id' => $request->catagories_id,
        ]);

        return $this->jsonReponse(true,'success',$value,201);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'menus_id' => 'required|exists:menus,id',
            'catagories_id' => 'required|exists:catagories,id',
            'id' => 'required|exists:menu_catagories,id'

        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = MenuCatagory::find($request->id);

        if($value){

            $value->update([
                'menus_id' => $request->menus_id,
                'catagories_id' => $request->catagories_id,
            ]);
            return $this->jsonReponse(true,'success',$value,201);
        }
    }

    public function getAll(Request $request){

        $data = MenuCatagory::orderBy('id')->get();

        return $this->jsonReponse(true,"Success",$data,200);
    }

    public function get($id) {
        $data = MenuCatagory::find($id);
        return $this->jsonReponse(true,'success',$data,200);
    }

    public function filter(Request $req) {
        $query = MenuCatagory::query();

        foreach($req->toArray() as $key=>$value) {
            $query->orWhere($key, 'like', '%'.$value.'%');
        }
        $data = $query->get();
        return $this->jsonReponse(true,'success',$data,202);
    }

    public function delete($id) {
        $data = MenuCatagory::find($id);
        
        if(!($data)) {
            return $this->jsonReponse(false,'No data with give id',null,200);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,'success',$old,200);
    }
}
