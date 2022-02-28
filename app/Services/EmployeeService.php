<?php

namespace App\Services;

use App\Models\Employee;
use Carbon\Carbon;

class EmployeeService
{

    /**
     * @param $request
     * @return mixed
     */
    public function storeNewEmployee($request)
    {
        $employee = Employee::create([
            'name' => $request->name,
            'department' => $request->department,
            'joined_at' => Carbon::parse($request->joining_date)->toDateString(),
            'status' => $request->status,
        ]);

        $employee->uploadEmployeeImageFile($request->image);

        return $employee;
    }

    /**
     * @param $request
     * @param $employee
     * @return mixed
     */
    public function updateEmployee($request, $employee)
    {
        $employee->name = $request->name;
        $employee->department = $request->department;
        $employee->joined_at = Carbon::parse($request->joining_date)->toDateString();
        $employee->status = $request->status;
        $employee->save();

        return $employee;
    }

    public function deleteEmployee($request)
    {
        $ids = explode(",", $request->ids);

        Employee::whereIn('id', $ids)->get()->map(function ($employee) {
            $employee->delete();
        });

        return true;
    }
}