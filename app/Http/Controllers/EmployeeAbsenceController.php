<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\EmployeeAbsenceRepository;
use Illuminate\Http\Request;

class EmployeeAbsenceController extends Controller
{
    public function __construct(
        protected EmployeeAbsenceRepository $employeeAbsenceRepository,
        protected Employee $employee,
    ) {
    }

    public function index()
    {
        $datas = $this->employeeAbsenceRepository->getForCalendars();
        return view('pages.employee-absence.index', compact('datas'));
    }

    public function form()
    {
    }

    public function submit(Request $request)
    {
        //
    }
}
