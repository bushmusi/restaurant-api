<?php

namespace App\Http\Controllers\Api\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuCatagory;

class MenuController extends Controller
{
    //
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:menus,name_en|max:50',
            'name_am' => 'required|unique:menus,name_am|max:50',
            'price' => 'required|numeric|between:0,5000',
            'content' => 'required|max:500',
            'type_id' => 'required|exists:menu_types,id'
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = Menu::create([
            'name_en' => $request->name_en,
            'name_am' => $request->name_am,
            'price' => $request->price,
            'content' => $request->content,
            'type_id' => $request->type_id,
            'id' => $request->id
        ]);

        return $this->jsonReponse(true,'success',$value,201);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:menus,name_en|max:50',
            'name_am' => 'required|unique:menus,name_am|max:50',
            'price' => 'required|numeric|between:0,5000',
            'content' => 'required|max:500',
            'type_id' => 'required|exists:menu_types,id',
            'id' => 'required|exists:menus,id'

        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = Menu::find($request->id);

        if($value){

            $value->update([
                'name_en' => $request->name_en,
                'name_am' => $request->name_am,
                'price' => $request->price,
                'content' => $request->content,
                'type_id' => $request->type_id,
            ]);
            return $this->jsonReponse(true,'success',$value,201);
        }
    }

    public function getAll(Request $request){

        $data = Menu::orderBy('name_en')->get();

        return $this->jsonReponse(true,"Success",$data,200);
    }

    public function get($id) {
        $data = Menu::find($id);
        return $this->jsonReponse(true,'success',$data,200);
    }

    public function filter(Request $req) {
        $query = Menu::query();

        foreach($req->toArray() as $key=>$value) {
            $query->orWhere($key, 'like', '%'.$value.'%');
        }
        $data = $query->get();
        return $this->jsonReponse(true,'success',$data,202);
    }

    public function delete($id) {
        $data = Menu::find($id);
        $checkMenuCatagory = MenuCatagory::where('menus_id',$id)->get();
        if(count($checkMenuCatagory) != 0) {
            return $this->jsonReponse(false,'ID referenced Menu Catagory Table',null,200);
        }
        if(!($data)) {
            return $this->jsonReponse(false,'No data with give id',null,200);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,'success',$old,200);
    }
}
