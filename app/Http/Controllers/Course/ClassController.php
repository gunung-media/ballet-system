<?php

namespace App\Http\Controllers\Course;

use App\Enums\DayEnum;
use App\Http\Controllers\Controller;
use App\Models\Course\ClassModel;
use App\Repositories\Course\AbsenceRepository;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(
        protected ClassRepository $classRepository,
        protected StudentRepository $studentRepository,
        protected AbsenceRepository $absenceRepository,
    ) {}

    public function index(): View|Factory
    {
        $data = $this->classRepository->getAll();
        return view('pages.courses.class.index', compact('data'));
    }

    public function create(): View|Factory
    {
        $days = DayEnum::class;
        return view('pages.courses.class.form', compact('days'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(ClassModel::validationRules());

        try {
            $this->classRepository->insert($request->except('_token'));
            return redirect()->intended(route('kelas.index'))->with('success', 'Berhasil Menambahkan Kelas');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function show(mixed $classModel)
    {
        $data = $this->classRepository->getById($classModel)->students;
        $getStudentByAbsence = fn($studentId)  => $this->studentRepository->getStudentAbsence($studentId, $classModel, date('Y'));
        $getClassAbsences = fn($month)  => $this->absenceRepository->getByMonth($classModel, $month, date('Y'))->count();

        return view('pages.courses.class.show', compact('data', 'getStudentByAbsence', 'getClassAbsences'));
    }

    public function edit(mixed $classModel): View|Factory
    {
        $days = DayEnum::class;
        $data = $this->classRepository->getById($classModel);
        return view('pages.courses.class.form', compact('days', 'data'));
    }

    public function update(Request $request, mixed $classModel): RedirectResponse
    {
        $request->validate(ClassModel::validationRules($classModel));

        if (!$this->classRepository->update($classModel, $request->all())) {
            return redirect()->back()->with('error', 'Gagal mengupdate kelas')->withInput();
        }
        return redirect()->back()->with('success', 'Berhasil mengupdate kelas');
    }

    public function destroy(mixed $classModel): RedirectResponse
    {
        $deleted = $this->classRepository->delete($classModel);
        if (!$deleted) back()->with('error', 'Gagal menghapus kelas');
        return back()->with('success', 'Berhasil menghapus kelas');
    }
}
