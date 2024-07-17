<?php

namespace App\Http\Controllers\Course;

use App\Enums\EmployeeTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\TeacherStatus;
use App\Http\Controllers\Controller;
use App\Models\Course\Teacher;
use App\Repositories\Course\TeacherRepository;
use App\Repositories\EmployeeAbsenceRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherRepository $teacherRepository,
        protected EmployeeAbsenceRepository $employeeAbsenceRepository,
    ) {}

    public function index(): View|Factory
    {
        $data = $this->teacherRepository->getAll();
        $absences = $this->employeeAbsenceRepository->getAll();
        return view('pages.courses.teacher.index', compact('data', 'absences'));
    }

    public function create(): View|Factory
    {
        $genders = GenderEnum::class;
        $status = TeacherStatus::class;
        $type = EmployeeTypeEnum::class;
        return view('pages.courses.teacher.form', compact('genders', 'status', 'type'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Teacher::validationRules());

        try {
            $this->teacherRepository->insert($request->except('_token'));
            return redirect()->intended(route('guru.index'))->with('success', 'Berhasil Menambahkan Guru');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(mixed $teacher): View|Factory
    {
        $genders = GenderEnum::class;
        $status = TeacherStatus::class;
        $type = EmployeeTypeEnum::class;
        $data =  $this->teacherRepository->getById($teacher);
        return view('pages.courses.teacher.form', compact('genders', 'status', 'data', 'type'));
    }

    public function update(Request $request, mixed $teacher): RedirectResponse
    {
        $request->validate(Teacher::validationRules());
        if ($this->teacherRepository->update($teacher, $request->except('_token'))) {
            return back()->with('success', 'Berhasil Mengupdate Guru');
        }
        return back()->with('error', 'Gagal Mengupdate Guru');
    }

    public function destroy(mixed $teacher): RedirectResponse
    {
        $deleted = $this->teacherRepository->delete($teacher);
        if (!$deleted) back()->with('error', 'Gagal menghapus guru');
        return back()->with('success', 'Berhasil menghapus guru');
    }
}
