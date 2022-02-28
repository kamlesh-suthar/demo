<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeDeleteRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\TemporaryFile;
use App\Models\TemporayFile;
use App\Services\EmployeeService;
use App\Services\Reports\ReportDownloadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = new Employee();

            if ($request->search['value']) {
                $search   = $request->search['value'];
                $employees = $employees->where('name', 'like', '%' . $search . '%');
            }

            $order = $request->columns[$request->order[0]['column']]['name'];
            $dir   = $request->order[0]['dir'];

            if ($order == 'name') {
                $employees = $employees->orderBy('name', $dir);
            } else {
                $employees = $employees->orderBy($order, $dir);
            }

            $offset = $request->start ?: 0;
            $limit  = $request->length ?: 10;

            $employees   = $employees->orderBy('id', 'desc');
            $clientTotal = $employees->get();
            $employees    = $employees->skip($offset)->take($limit)->get();

            $employeeList  = [];

            if (!empty($employees)) {
                foreach ($employees as $index => $employee) {
                    $employeeData   = [];
                    $employeeData[] = '<div class="checkbox-inline"> <div class="checkbox-inline">' .
                        '<input type="checkbox" class="checkbox-inline chkbox" name="id" data-id="'. $employee->id .'">' .
                        '<label for="id' . $employee->id . '"></label></div></div>';
                    $employeeData[] = $index + 1;
                    $employeeData[] = $employee->name;
                    $employeeData[] = $employee->department;
                    $employeeData[] = Carbon::parse($employee->joined_at)->toDateString();
                    $employeeData[] = ($employee->status == 1) ? '<span class="text text-primary">Active</span>' : '<span class="text text-danger">In-active</span> ';
//                    Display storage Image
                    $employeeData[] = $employee->image ? '<img src="' . asset('storage/app/public/'. $employee->id .'/'.$employee->image) . '" />' : '';
//                    Display Public Image
//                    $employeeData[] = '<img src="'.asset('uploads/').'/'.$employee->image .'" width="100%%">';
                    $employeeData[] = '<div class="d-flex">
                     <a href="' . route('employees.edit', $employee->id) . '" class="btn btn-primary me-2">Edit</a>
                     <a href="javascript:void(0);" onClick="deleteRecord(' . $employee->id . ')" class="btn btn-danger">Delete</a> </div>';
                    $employeeList[]  = $employeeData;
                }
            }

            $json_data = [
                "draw"            => intval($request['draw']),
                "data"            => $employeeList,
                "recordsTotal"    => count($clientTotal),
                "recordsFiltered" => count($clientTotal)
            ];
            return response()->json($json_data);
        }

        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * @param EmployeeCreateRequest $request
     * @param EmployeeService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeCreateRequest $request, EmployeeService $service)
    {
        $service->storeNewEmployee($request);

        return response()->json([
            'message' => 'Employee created successfully',
            'status'  => 'success',
            'code'    => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.update', [
            'employee' => $employee,
        ]);
    }

    /**
     * @param EmployeeUpdateRequest $request
     * @param EmployeeService $service
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmployeeUpdateRequest $request, EmployeeService $service, Employee $employee)
    {
        $service->updateEmployee($request, $employee);

        return response()->json([
            'message' => 'Employee updated successfully',
            'status'  => 'success',
            'code'    => 200
        ]);
    }

    /**
     * @param EmployeeDeleteRequest $request
     * @param EmployeeService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmployeeDeleteRequest $request, EmployeeService $service)
    {
        $service->deleteEmployee($request);

        return response()->json([
            'message' => 'Employees deleted successfully',
            'status'  => 'success',
            'code'    => 200
        ]);
    }

    public function report(ReportDownloadService $service, $format = 'html')
    {
        return $service->downloadReport($format);
    }

    public function imageUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $folder = uniqid() . '-' . now()->timestamp;
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/employees/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }
        return '';
    }
}
