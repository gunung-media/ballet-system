<?php

namespace App\Http\Controllers\Course;

use App\Enums\TuitionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\TuitionTransaction;
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
    ) {}

    public function index(): View|Factory
    {
        $data = $this->tuitionTransactionRepository->getAll();
        return view('pages.courses.tuition.index', compact('data'));
    }

    public function create(): View|Factory
    {
        $students = $this->studentRepository->getAll()->mapWithKeys(fn($student) => [$student->id => $student->name])->toArray();
        $tuitionTypes = TuitionTypeEnum::class;
        return view('pages.courses.tuition.form', compact('students', 'tuitionTypes'));
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
        $data = $this->tuitionTransactionRepository->getById($id);
        $students = $this->studentRepository->getAll()->mapWithKeys(fn($student) => [$student->id => $student->name])->toArray();
        return view('pages.courses.tuition.form', compact('data', 'students'));
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
