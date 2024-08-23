<?php

namespace App\Http\Controllers;

use App\Models\Installment\Installment;
use App\Repositories\Installment\InstallmentPaymentRepository;
use App\Repositories\Installment\InstallmentRepository;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function __construct(
        protected InstallmentRepository $installmentRepository,
        protected InstallmentPaymentRepository $installmentPaymentRepository,
    ) {}

    public function index()
    {
        $data = $this->installmentRepository->getAll();
        return view('pages.installment.index', compact('data'));
    }

    public function create()
    {
        return view('pages.installment.form');
    }

    public function store(Request $request)
    {
        $request->validate(Installment::validationRules());

        try {
            $this->installmentRepository->insert($request->except('_token'));
            return redirect()->intended(route('installment.index'))->with('success', 'Berhasil Menambahkan');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = $this->installmentRepository->find($id);
        return view('pages.installment.form', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(Installment::validationRules($id));
        if (!$this->installmentRepository->update($id, $request->all())) {
            return redirect()->back()->with('error', 'Gagal mengupdate')->withInput();
        }
        return redirect()->back()->with('success', 'Berhasil mengupdate');
    }

    public function destroy(string $id)
    {
        $deleted = $this->installmentRepository->delete($id);
        if (!$deleted) back()->with('error', 'Gagal menghapus');
        return back()->with('success', 'Berhasil menghapus');
    }
}
