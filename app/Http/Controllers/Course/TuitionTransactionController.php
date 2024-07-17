<?php

namespace App\Http\Controllers\Course;

use App\Enums\TuitionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\TuitionTransaction;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use App\Repositories\Course\TuitionTransactionRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TuitionTransactionController extends Controller
{
    public function __construct(
        protected TuitionTransactionRepository $tuitionTransactionRepository,
        protected StudentRepository $studentRepository,
        protected ClassRepository $classRepository,
    ) {}

    public function index(): View|Factory
    {
        $data = $this->tuitionTransactionRepository->getAll();
        $month = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $defaultMonth = now()->month;
        $classes = $this->classRepository->getAll();
        $tableHeaders = array_merge(
            ['Tanggal', 'Nama Siswa'],
            $classes->map(fn($class) => $class->name)->toArray(),
        );
        return view('pages.courses.tuition.index', compact('data', 'month', 'defaultMonth', 'tableHeaders', 'classes'));
    }

    public function getClasses($studentId)
    {
        $defaultClasses = $this->classRepository->getAll()->mapWithKeys(fn($class) => [$class->id => $class->name])->toArray();
        $getClasses = function (mixed $studentId) use ($defaultClasses) {
            if ($studentId == "Lainnya") return $defaultClasses;

            $student = $this->studentRepository->getById($studentId);
            return $student->classes->mapWithKeys(fn($class) => [$class->id => $class->name])->toArray();
        };

        return response()->json($getClasses($studentId));
    }

    private function gatherFormData(): array
    {
        $students = $this->studentRepository->getAll()->mapWithKeys(fn($student) => [$student->id => $student->name])->toArray();
        $defaultClasses = $this->classRepository->getAll()->mapWithKeys(fn($class) => [$class->id => $class->name])->toArray();
        $getClasses = function (mixed $studentId) use ($defaultClasses) {
            if ($studentId == "Lainnya") return $defaultClasses;

            $student = $this->studentRepository->getById($studentId);
            return $student->classes->mapWithKeys(fn($class) => [$class->id => $class->name])->toArray();
        };
        $getClassPrice = fn(mixed $classId) => $this->classRepository->getById($classId);
        $tuitionTypes = TuitionTypeEnum::class;

        return compact('students', 'tuitionTypes', 'getClasses', 'defaultClasses', 'getClassPrice');
    }

    public function create(): View|Factory
    {
        $formData = $this->gatherFormData();
        return view('pages.courses.tuition.form', $formData);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(TuitionTransaction::validationRules());

        try {
            $this->tuitionTransactionRepository->insert([...$request->except('_token'), 'for_month' => "{$request->for_month}-01"]);
            return redirect()->intended(route('spp.index'))->with('success', 'Berhasil Menambahkan Transasksi SPP');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(string $id): View|Factory
    {
        $formData = $this->gatherFormData();
        return view('pages.courses.tuition.form', array_merge($formData, ['data' => $this->tuitionTransactionRepository->getById($id)]));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(TuitionTransaction::validationRules());

        if ($this->tuitionTransactionRepository->update($id, [...$request->except('_token'), 'for_month' => "{$request->for_month}-01"])) {
            return back()->with('success', 'Berhasil Mengedit Transaksi SPP');
        }
        return back()->with('error', 'Gagal Mengedit Transaksi SPP');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->tuitionTransactionRepository->delete($id);
        if (!$deleted) back()->with('error', 'Gagal menghapus transaksi');
        return back()->with('success', 'Berhasil menghapus transaksi');
    }
}
