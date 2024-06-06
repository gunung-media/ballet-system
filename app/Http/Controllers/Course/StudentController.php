<?php

namespace App\Http\Controllers\Course;

use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Models\Course\Student;
use App\Repositories\Course\StudentRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository
    ) {
    }

    public function index(): View|Factory
    {
        $data = $this->studentRepository->getAll();
        return view('pages.courses.student.index', compact('data'));
    }

    public function create(): View|Factory
    {
        $genders = GenderEnum::class;
        return view('pages.courses.student.form', compact('genders'));
    }
    /**
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(Student::validationRules());

        try {
            $this->studentRepository->insert($request->except('_token'));
            return redirect()->intended(route('siswa.index'))->with('success', 'Berhasil Menambahkan Siswa');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(string $id): void
    {
        //
    }

    public function update(Request $request, string $id): void
    {
        //
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->studentRepository->delete($id);
        if (!$deleted) back()->with('error', 'Gagal menghapus siswa');
        return back()->with('success', 'Berhasil menghapus siswa');
    }
}
