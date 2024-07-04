<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeRepository $employeeRepository,
    ) {
    }

    public function index(): View|Factory
    {
        $data = $this->employeeRepository->getAll();
        return view('pages.employee.index', compact('data'));
    }

    public function create(): View|Factory
    {
        $genders = GenderEnum::class;
        return view('pages.employee.form', compact('genders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Employee::validationRules());

        try {
            $this->employeeRepository->insert($request->except('_token'));
            return redirect()->intended(route('pegawai.index'))->with('success', 'Berhasil Menambahkan pegawai');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(string $id): View|Factory
    {
        $genders = GenderEnum::class;
        $data = $this->employeeRepository->getById($id);
        return view('pages.employee.form', compact('genders', 'data'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(Employee::validationRules());
        if ($this->employeeRepository->update($id, $request->except('_token'))) {
            return back()->with('success', 'Berhasil Mengupdate pegawai');
        }
        return back()->with('error', 'Gagal Mengupdate pegawai');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->employeeRepository->delete($id);
        if (!$deleted) back()->with('error', 'Gagal menghapus pegawai');
        return back()->with('success', 'Berhasil menghapus pegawai');
    }
}
