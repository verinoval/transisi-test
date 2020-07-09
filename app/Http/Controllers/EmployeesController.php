<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\employees;

use Validator;

class EmployeesController extends Controller
{
    Public function index(Request $request){
        $keyword = $request->keyword;
        $status  = $request->status;
        $jabatan = $request->jabatan;

        $qry = employees::with('jabatan');

        if($keyword != ''){
            $qry->where('employee_name', 'LIKE', '%'. $keyword .'%')
                ->orWhere('employee_salary', '=', $keyword)
                ->orWhere('employee_age', '=', $keyword);
        }

        if($jabatan != ''){
            $qry->whereHas('jabatan', function($j) use($jabatan){
                $j->where('jabatan','=',$jabatan);
            });
        }


        $data = $qry->orderBy('created_at', 'DESC')->get();

        return response([
            'success'   => true,
            'data'      => $data
        ]);
    }

    public function employee_detail(Request $request){
        $data = employees::with('jabatan')->where('employee_id', $request->id)->first();

        return response([
            'success' => true,
            'data'    => $data
        ]);
    }

    Public function employee_add(Request $request){
        $inputs = $request->all();
        $rules = [
            'employee_name'     => 'required|string',
            'jabatan_id'        => 'required',
            'employee_salary'   => 'required|numeric|min:1000000|max:10000000',
            'employee_age'      => 'required|numeric'
        ];

        $messages = [
            'employee_name.required'    => 'Nama harus diisi!',
            'employee_name.string'      => 'Format nama salah!',
            'jabatan_id.required'       => 'Jabatan harus diisi!',
            'employee_salary.required'  => 'Upah harus diisi!',
            'employee_salary.numeric'   => 'Format upah salah!',
            'employee_salary.min'       => 'Upah minimal Rp. 1.000.000',
            'employee_salary.max'       => 'Upah maximal Rp. 10.000.000',
            'employee_age.required'     => 'Umur harus diisi!',
            'employee_age.numeric'      => 'Format umur salah!'
        ];
        
        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {
            $res['success'] = false;
            $res['message'] = $validator->errors()->all();
            return response($res);
        }

        $employee = new employees([
            'employee_name'     => $request->employee_name,
            'jabatan_id'        => $request->jabatan_id,
            'employee_salary'   => $request->employee_salary,
            'employee_age'      => $request->employee_age
        ]);

        $employee->save();

        return response()->json([
            'message' => 'Sukses insert pegawai!',
            'success' => true
        ], 201);
    }

    public function employee_update(Request $request){

        $inputs = $request->get('form');
        $rules = [];
        
        if (array_key_exists('employee_name', $inputs)) {
            $rules['employee_name'] = 'string';
        }

        if (array_key_exists('employee_salary', $inputs)) {
            $rules['employee_salary'] = 'numeric|min:1000000|max:10000000';
        }
        
        if (array_key_exists('employee_age', $inputs)) {
            $rules['employee_age'] = 'numeric';
        }

        $messages = [
            'employee_name.string'      => 'Format nama salah!',
            'employee_salary.numeric'   => 'Format upah salah!',
            'employee_salary.min'       => 'Upah minimal Rp. 1.000.000',
            'employee_salary.max'       => 'Upah maximal Rp. 10.000.000',
            'employee_age.numeric'      => 'Format umur salah!',
        ];
        
        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {
            $res['success'] = false;
            $res['message'] = $validator->errors()->all();
            return response($res);
        }

        foreach($request->get('form') as $key => $val) {
            employees::where('employee_id', '=', $request->id)
                ->update([$key => $val]);
        }

        return response([
            'success'       => true,
            'message'       => 'Berhasil Update',
        ]);
    }

    public function employee_delete(Request $request){
        $employee = employees::findOrFail($request->id);

        $employee->delete();

        return response()->json([
            'message' => 'Sukses delete pegawai!',
            'success' => true
        ], 201);
    }
}
