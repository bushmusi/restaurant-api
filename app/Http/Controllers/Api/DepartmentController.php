<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;

class DepartmentController extends Controller
{
    //
    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'dep_name' => 'required|unique:departments|max:50',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'msg' => $validator->errors(),
                'data' => null
            ],201);
        }

        $dept = Department::create([
            'dep_name' => $request->dep_name
        ]);

        return response()->json([
            'success' => true,
            'msg' => "succsse",
            'data' => $dept
        ],201);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:departments,id',
            'dep_name' => 'required|unique:departments,dep_name|max:50',

        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'msg' => $validator->errors(),
                'data' => null
            ]);
        }

        $value = Department::find($request->id);

        if($value){
            $value->dep_name = $request->dep_name;
            $value->save();
            return response()->json([
                'success' => true,
                'msg' => "succsse",
                'data' => $value
            ],201);
        }
        
        return response()->json([
            'success' => false,
            'msg' => "No Department with this specfic ID",
            'data' => null
        ],201);
    }

    public function getAll(Request $request){

        $data = Department::orderBy('dep_name')->get();
        
        if(!($data)){
            return $this->jsonResponse(false,"No data",null,200);
        }

        return $this->jsonReponse(true,"Success",$data,200);
    }

    public function getById($id) {
        $data = Department::find($id);
        if(!($data)){
            return $this->jsonReponse(false,'No data',null,200);
        }
        return $this->jsonReponse(true,'success',$data,200);
    }

    public function delete($id) {
        $data = Department::find($id);

        if(!($data)) {
            return $this->jsonReponse(false,'No data with give id',null,200);
        }
        $old = $data;
        $data->delete();
        return $this->jsonReponse(true,'success',$old,200);
    }
}
