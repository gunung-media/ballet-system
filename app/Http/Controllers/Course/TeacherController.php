<?php

namespace App\Http\Controllers\Course;

use App\Enums\GenderEnum;
use App\Enums\TeacherStatus;
use App\Http\Controllers\Controller;
use App\Models\Course\Teacher;
use App\Repositories\Course\TeacherRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherRepository $teacherRepository
    ) {
    }

    public function index(): View|Factory
    {
        $data = $this->teacherRepository->getAll();
        return view('pages.courses.teacher.index', compact('data'));
    }

    public function create(): View|Factory
    {
        $genders = GenderEnum::class;
        $status = TeacherStatus::class;
        return view('pages.courses.teacher.form', compact('genders', 'status'));
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

    public function edit($teacher): void
    {
        //
    }

    public function update(Request $request, $teacher): void
    {
        //
    }

    public function destroy($teacher): RedirectResponse
    {
        $deleted = $this->teacherRepository->delete($teacher);
        if (!$deleted) back()->with('error', 'Gagal menghapus guru');
        return back()->with('success', 'Berhasil menghapus guru');
    }
}
