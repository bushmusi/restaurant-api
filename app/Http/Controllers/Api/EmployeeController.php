<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function validateErrMsg() {
        return [
            'empID.required' => "Employee ID is required",
            'empID.max' => "Employee ID Maximum string length should be 50",
            'empID.unique' => "Employee ID should be unique"
        ];
    }
    public function create(Request $req) {
        
        $validator = Validator::make( $req->all(), [
            'name' => 'required|unique:employees,name|max:50',
            'position' => 'required|max:50',
            'empID' => 'required|max:50|unique:employees,empID'
        ],$this->validateErrMsg());

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
        }

        $data = Employee::create([
            'name' => $req->name,
            'position' => $req->position,
            'empID' => $req->empID
        ]);

        return $this->jsonReponse(true,"Created successfully",$data,201);
    }

    public function update(Request $req) {

        $validator = Validator::make( $req->all(), [
            'id' => 'required',
            'name' => 'required|unique:employees,id,'.$req->id.'|max:50',
            'position' => 'required|max:50',
            'empID' => 'required|max:50|unique:employees,empID,'.$req->id.''
        ],$this->validateErrMsg());

        if($validator->fails()){
            foreach($validator->errors()->toArray() as $k => $v) {
                return $this->jsonReponse(false,$v[0],null,201);
            }
        }

        $item = Employee::find($req->id);
        if(!($item)){
            return $this->jsonReponse(false,"No record with given id",null,201);
        }

        $item->update([
            'name' => $req->name,
            'position' => $req->position,
            'empID' => $req->empID
        ]);


        return $this->jsonReponse(true,"success",$item,201);
    }

    public function getAll(Request $req) {

        $data = Employee::orderBy('empID')->get();

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function getByID($id) {

        $data = Employee::find($id);

        return $this->jsonReponse(true,"Success",$data,202);
    }

    public function delete($id) {
        $data = Employee::find($id);
        if(!($data)) {
            return $this->jsonReponse(false,"No data",null,202);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,"Success",$old,202);
    }

}
