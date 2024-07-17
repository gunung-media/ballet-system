<?php

namespace App\Http\Controllers;

use App\Models\Course\Absence;
use App\Models\EmployeeAbsence;
use App\Repositories\EmployeeAbsenceRepository;
use App\Repositories\EmployeeRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAbsenceController extends Controller
{
    public function __construct(
        protected EmployeeAbsenceRepository $employeeAbsenceRepository,
        protected EmployeeRepository $employeeRepository,
    ) {}

    public function index(): View|Factory
    {
        $datas = $this->employeeAbsenceRepository->getForCalendars();
        $absences = $this->employeeAbsenceRepository->getAbsences();
        $employeeCount = $this->employeeRepository->getAll()->count();
        return view('pages.employee-absence.index', compact('datas', 'absences', 'employeeCount'));
    }

    public function form(Request $request): View|Factory
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

    public function submit(Request $request): RedirectResponse
    {
        try {
            $this->employeeAbsenceRepository->insert($request->except('token'));
            return redirect()->back()->with('success', 'Pegawai Sukses Absen');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function checkIn(): RedirectResponse
    {
        $employeeId = auth('employee')->id();
        $date = Carbon::today()->toDateString();

        $absence = EmployeeAbsence::firstOrCreate(
            ['teacher_id' => $employeeId, 'date' => $date],
            ['check_in' => Carbon::now()->toTimeString()]
        );

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(): RedirectResponse
    {
        $employeeId = auth('employee')->id();
        $date = Carbon::today()->toDateString();

        $absence = EmployeeAbsence::where('teacher_id', $employeeId)->where('date', $date)->first();
        if ($absence) {
            $absence->update(['check_out' => Carbon::now()->toTimeString()]);
            return back()->with('success', 'Checked out successfully.');
        }

        return back()->with('error', 'Check-in required before check-out.');
    }
}
