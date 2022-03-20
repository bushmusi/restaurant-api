<?php

namespace App\Http\Controllers\Api\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Menu\MenuType;
use App\Models\Menu\Menu;

class MenuTypeController extends Controller
{
    //
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'type' => 'required|unique:menu_types,type|max:50',
        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = MenuType::create([
            'type' => $request->type
        ]);

        return $this->jsonReponse(true,'success',$value,201);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:menu_types,id',
            'type' => 'required|unique:menu_types,type|max:50',

        ]);

        if($validator->fails()){
            return $this->jsonReponse(false,$validator->errors(),null,201);
        }

        $value = MenuType::find($request->id);

        if($value){

            $value->type = $request->type;
            $value->save();
            return $this->jsonReponse(true,'success',$value,201);
        }
    }

    public function getAll(Request $request){

        $data = MenuType::orderBy('type')->get();

        return $this->jsonReponse(true,"Success",$data,200);
    }

    public function get($id) {
        $data = MenuType::find($id);
        return $this->jsonReponse(true,'success',$data,200);
    }

    public function delete($id) {
        $data = MenuType::find($id);
        $checkMenu = Menu::where('type_id',$id)->get();
        if(count($checkMenu) != 0) {
            return $this->jsonReponse(false,'ID referenced in Menu table',null,200);
        }
        if(!($data)) {
            return $this->jsonReponse(false,'No data with give id',null,200);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,'success',$old,200);
    }
}
