<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course\ClassModel;
use App\Repositories\Course\ClassRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(
        protected ClassRepository $classRepository,
    ) {
    }

    public function index(): View|Factory
    {
        $data = $this->classRepository->getAll();
        return view('pages.courses.class.index', compact('data'));
    }

    public function create(): View|Factory
    {
        return view('pages.courses.class.index');
    }

    public function store(Request $request): void
    {
        $request->validate(ClassModel::validationRules());

        try {
            $this->classRepository->insert($request->all());
        } catch (\Exception $exception) {
            back()->with('error', $exception->getMessage());
        }
    }

    public function edit(ClassModel $classModel): View|Factory
    {
        return view('pages.courses.class.index', compact('classModel'));
    }

    public function update(Request $request, ClassModel $classModel): void
    {
        $request->validate(ClassModel::validationRules($classModel->id));

        if (!$this->classRepository->update($classModel, $request->all())) {
            back()->with('error', 'Gagal mengupdate kelas');
        }
        back()->with('success', 'Berhasil mengupdate kelas');
    }

    public function destroy(ClassModel $classModel): RedirectResponse
    {
        $deleted = $this->classRepository->delete($classModel->id);
        if (!$deleted) back()->with('error', 'Gagal menghapus kelas');
        return back()->with('success', 'Berhasil menghapus kelas');
    }
}
