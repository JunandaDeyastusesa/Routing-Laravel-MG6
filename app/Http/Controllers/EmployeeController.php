<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $pageTitle = 'Employee List';

    //     // RAW SQL QUERY
    //     $employees = DB::table('employees')
    //             ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    //             ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
    //             ->get();

    //     return view('employee.index', [
    //         'pageTitle' => $pageTitle,
    //         'employees' => $employees
    //     ]);
    // }

    public function index()
    {
        $pageTitle = 'Employee List';
        // ELOQUENT
        $employees = Employee::all();
        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }

    // public function create()
    // {
    //     $pageTitle = 'Create Employee';
    //     // RAW SQL Query
    //     $positions = DB::table('positions')->get();

    //     return view('employee.create', compact('pageTitle', 'positions'));
    // }

    // public function store(Request $request)
    // {
    //     $messages = [
    //         'required' => ':Attribute harus diisi.',
    //         'email' => 'Isi :attribute dengan format yang benar',
    //         'numeric' => 'Isi :attribute dengan angka'
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'firstName' => 'required',
    //         'lastName' => 'required',
    //         'email' => 'required|email',
    //         'age' => 'required|numeric',
    //     ], $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // INSERT QUERY
    //     DB::table('employees')->insert([
    //         'firstname' => $request->firstName,
    //         'lastname' => $request->lastName,
    //         'email' => $request->email,
    //         'age' => $request->age,
    //         'position_id' => $request->position,
    //     ]);

    //     return redirect()->route('employees.index');
    // }

    public function create()
    {
        $pageTitle = 'Create Employee';
        // ELOQUENT
        $positions = Position::all();
        return view('employee.create', compact('pageTitle', 'positions'));
    }
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $employee = new Employee;
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();
        return redirect()->route('employees.index');
    }

    // public function show(string $id)
    // {
    //     $pageTitle = 'Employee Detail';

    //     // Query Builder
    //     $employee = collect(DB::table('employees')
    //         ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
    //         ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    //         ->where('employees.id', $id)
    //         ->get())->first();

    //     return view('employee.show', compact('pageTitle', 'employee'));
    // }

    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';
        // ELOQUENT
        $employee = Employee::find($id);
        return view('employee.show', compact('pageTitle', 'employee'));
    }

    // public function edit(string $id)
    // {
    //     $pageTitle = 'Employee Detail';

    //     // Mengambil data employee berdasarkan ID
    //     $employee = collect(DB::select('
    //     select *, employees.id as employee_id, positions.name as position_name
    //     from employees
    //     left join positions on employees.position_id = positions.id
    //     where employees.id = ?
    //     ', [$id]))->first();

    //     // Mengambil semua data posisi
    //     $positions = DB::table('positions')->get();

    //     return view('employee.edit', compact('pageTitle', 'employee', 'positions'));
    // }

    // public function update(Request $request, string $id)
    // {
    //     $messages = [
    //         'required' => ':Attribute harus diisi.',
    //         'email' => 'Isi :attribute dengan format yang benar',
    //         'numeric' => 'Isi :attribute dengan angka'
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'firstName' => 'required',
    //         'lastName' => 'required',
    //         'email' => 'required|email',
    //         'age' => 'required|numeric',
    //         'position' => 'required' // Pastikan ini sesuai dengan name yang ada pada form
    //     ], $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Mengambil data employee berdasarkan ID
    //     DB::table('employees')->where('id', $id)->update([
    //         'firstname' => $request->firstName,
    //         'lastname' => $request->lastName,
    //         'email' => $request->email,
    //         'age' => $request->age,
    //         'position_id' => $request->position,
    //     ]);

    //     return redirect()->route('employees.index')->with('success', 'Employee data updated successfully.');
    // }

    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';
        // ELOQUENT
        $positions = Position::all();
        $employee = Employee::find($id);
        return view('employee.edit', compact(
            'pageTitle',
            'positions',
            'employee'
        ));
    }
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $employee = Employee::find($id);
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();
        return redirect()->route('employees.index');
    }

    // public function destroy(string $id)
    // {
    //     DB::table('employees')
    //         ->where('id', $id)
    //         ->delete();

    //     return redirect()->route('employees.index');
    // }

    public function destroy(string $id)
    {
        // ELOQUENT
        Employee::find($id)->delete();
        return redirect()->route('employees.index');
    }
}
