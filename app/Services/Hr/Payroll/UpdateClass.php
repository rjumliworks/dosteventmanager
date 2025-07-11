<?php

namespace App\Services\Hr\Payroll;

use App\Models\Payroll;
use App\Models\PayrollCutoff;
use App\Models\PayrollDeduction;
use App\Http\Resources\Hr\CutoffResource;
use App\Http\Resources\Hr\CycleResource;
use App\Http\Resources\Hr\PayrollResource;

class UpdateClass
{
    public function payroll($request){
        $data = PayrollCutoff::where('id',$request->id)->first();
        $data->status_id = $request->status_id;
        $data->save();

        $data = new CutoffResource(
            PayrollCutoff::query()
            ->with('cycle','status')
            ->with('user:id,username','user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.deductions.deduction')
            ->with('payrolls.user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.user:id,username','payrolls.user.organization:id,user_id,position_id,salary_id,type_id','payrolls.user.organization.type:id,name','payrolls.user.organization.position:id,name','payrolls.user.organization.salary:id,grade,amount')
            ->withSum('payrolls as total', 'netpay')
            ->withCount('payrolls as count')
            ->where('id',$request->id)->first()
        );
        return [
            'data' => $data,
            'message' => 'Cutoff updated successfully!', 
            'info' => "You've successfully updated the cutoff."
        ];
    }

    public function deduction($request){
        $data = PayrollDeduction::where('id',$request->id)->first();
        $data->amount = $request->amount;
        $data->save();
        return [
            'data' => new CycleResource($data),
            'message' => 'Cycle creation was successful!', 
            'info' => "You've successfully created a new cycle."
        ];
    }

    public function delete($request){
        $deduction = PayrollDeduction::where('id',$request->id)->first();
        $amount = $deduction->amount;
        if($deduction->delete()){
            $data = Payroll::where('id',$request->payroll_id)->first();
            $data->deduction = floatval(str_replace(['₱', ','], '', $data->deduction)) - floatval(str_replace(['₱', ','], '', $amount));
            $data->netpay = floatval(str_replace(['₱', ','], '',$data->netpay)) + floatval(str_replace(['₱', ','], '', $amount));
            $data->save();
        }

        $data = Payroll::with('deductions.deduction')
        ->with('user.profile:id,user_id,firstname,middlename,lastname,suffix')
        ->with('user:id,username','user.organization:id,user_id,position_id,salary_id,type_id','user.organization.type:id,name','user.organization.position:id,name','user.organization.salary:id,grade,amount')
        ->where('id',$request->payroll_id)->first();
        return [
            'data' => new PayrollResource($data),
            'message' => 'Deduction deleted successfully!', 
            'info' => "You've successfully deleted the deduction."
        ];
    }
}
