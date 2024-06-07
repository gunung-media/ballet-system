<?php

namespace App\Http\Controllers\Course;

use App\Enums\GenderEnum;
use App\Enums\StudentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Course\Student;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository,
        protected ClassRepository $classRepository
    ) {
    }

    public function index(): View|Factory
    {
        $data = $this->studentRepository->getAll();
        $selectedClass = fn ($student) => $student->classes->map(fn ($query) => $query->name)->join(', ');
        $enum = StudentStatusEnum::class;
        return view('pages.courses.student.index', compact('data', 'selectedClass', 'enum'));
    }

    public function create(): View|Factory
    {
        $genders = GenderEnum::class;
        $classes = $this->classRepository->getAll()->mapWithKeys(fn ($class) => [$class->id => $class->name])->toArray();
        return view('pages.courses.student.form', compact('genders', 'classes'));
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(Student::validationRules());

        try {
            $this->studentRepository->insert([...$request->except('_token'), 'status' => StudentStatusEnum::APPROVED]);
            return redirect()->intended(route('siswa.index'))->with('success', 'Berhasil Menambahkan Siswa');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(string $id): View|Factory
    {
        $genders = GenderEnum::class;
        $data = $this->studentRepository->getById($id);
        $classes = $this->classRepository->getAll()->mapWithKeys(fn ($class) => [$class->id => $class->name])->toArray();
        $selectedClass = $data->classes->map(fn ($query) => $query->id)->join(', ');
        return view('pages.courses.student.form', compact('genders', 'data', 'classes', 'selectedClass'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(Student::validationRules());

        if ($this->studentRepository->update($id, $request->except('_token'))) {
            return back()->with('success', 'Berhasil Mengedit Siswa');
        }
        return back()->with('error', 'Gagal Mengedit Siswa');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->studentRepository->delete($id);
        if (!$deleted) back()->with('error', 'Gagal menghapus siswa');
        return back()->with('success', 'Berhasil menghapus siswa');
    }

    public function changeStatus(Request $request, string $id): RedirectResponse
    {
        try {
            $data = $this->studentRepository->getById($id);
            $data->status = $request->status;
            $data->save();
            return back()->with('success', 'Berhasil Mengubah Status siswa');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'Gagal Mengubah Status siswa');
        }
    }
}
