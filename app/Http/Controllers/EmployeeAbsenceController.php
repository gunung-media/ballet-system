<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeAbsenceRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeAbsenceController extends Controller
{
    public function __construct(
        protected EmployeeAbsenceRepository $employeeAbsenceRepository,
        protected EmployeeRepository $employeeRepository,
    ) {}

    public function index()
    {
        $datas = $this->employeeAbsenceRepository->getForCalendars();
        $absences = $this->employeeAbsenceRepository->getAbsences();
        $employeeCount = $this->employeeRepository->getAll()->count();
        return view('pages.employee-absence.index', compact('datas', 'absences', 'employeeCount'));
    }

    public function form(Request $request)
    {
        $date = $request->get('date');
        $employees = $this->employeeRepository->getAll();

        $getEmployeeState = function ($employeeId)  use ($date) {
            $absence = $this->employeeAbsenceRepository->getAbsence($employeeId, $date);
            if ($absence == null) {
                return null;
            }

            $employee = $absence
                ->where('employee_id', $employeeId)
                ->first();

            if ($employee) {
                return $employee->state;
            }
            return null;
        };

        return view('pages.employee-absence.form', compact('date', 'employees', 'getEmployeeState'));
    }

    public function submit(Request $request)
    {
        try {
            $this->employeeAbsenceRepository->insert($request->except('token'));
            return redirect()->back()->with('success', 'Pegawai Sukses Absen');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
