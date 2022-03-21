<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SiUnit;

class SiUnitController extends Controller
{
    //
    public function errMsg() {
        return [
            'siunit.required' => 'SI Unit is required',
            'siunit.max' => 'SI Unit string length shold not be more thatn 50',
            'siunit.unique' => 'SI Unit should be unique'
        ];
    }
    public function add(Request $req) {
        
        $validator = Validator::make($req->all(),[
            'siunit' => 'required|max:50|unique:si_units,siunit'
        ],$this->errMsg());

        if($validator->fails()) {
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
        }

        $data = SiUnit::create([
            'siunit' => $req->siunit
        ]);

        return $this->jsonReponse(true,"Successfully created",$data,201);
    }

    public function update(Request $req) {

        $validator = Validator::make($req->all(),[
            'id' => 'required|exists:si_units,id',
            'siunit' => 'required|max:50|unique:si_units,siunit,'.$req->id
        ],$this->errMsg());

        if($validator->fails()) {
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
        }

        $data = SiUnit::find($req->id);
        $data->siunit = $req->siunit;
        $data->save();

        return $this->jsonReponse(false,"Successfully updated",$data,201);
    }

    public function getAll() {

        $data = SiUnit::orderBy('siunit')->get();

        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,200);
        }

        return $this->jsonReponse(true,"Successfully fetched",$data,200);
    }

    public function getById($id) {

        $data = SiUnit::find($id);

        return $this->jsonReponse(false,"Successfully fetched",$data,200);
    }

    public function deleteItem($id) {
        $data = SiUnit::find($id);

        if(!($data)) {
            return $this->jsonReponse(false,"No data with give id",null,202);
        }

        $old = $data;
        $data->delete();

        return $this->jsonReponse(true,"Delete Successfully",$old,202);
    }
}
