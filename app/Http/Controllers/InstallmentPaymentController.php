<?php

namespace App\Http\Controllers;

use App\Models\Installment\Installment;
use App\Models\Installment\InstallmentPayment;
use App\Repositories\Course\StudentRepository;
use App\Repositories\Installment\InstallmentPaymentRepository;
use App\Repositories\Installment\InstallmentRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstallmentPaymentController extends Controller
{
    public function __construct(
        protected InstallmentRepository $installmentRepository,
        protected InstallmentPaymentRepository $installmentPaymentRepository,
        protected StudentRepository $studentRepository,
    ) {}

    public function create(string $installmentId): View|Factory
    {
        $students = $this->studentRepository->getAll()->mapWithKeys(fn($student) => [$student->id => $student->name])->toArray();
        return view('pages.installment.payment', compact('installmentId', 'students'));
    }

    public function store(Request $request, string $installmentId): RedirectResponse
    {
        $request->validate(InstallmentPayment::validationRules());
        $installment = $this->installmentRepository->find($installmentId);

        if ($installment->is_paid) {
            return redirect()->back()->with('error', 'Tidak dapat menambahkan pembayaran karena sudah lunas')->withInput();
        }
        try {
            $this->installmentPaymentRepository->insert([...$request->except('_token'), 'installment_id' => $installmentId]);
            return redirect()->intended(route('installment.edit', $installmentId))->with('success', 'Berhasil Menambahkan');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function edit(string $installmentId, string $installmentPaymentId): View|Factory
    {
        $data = $this->installmentPaymentRepository->find($installmentPaymentId);
        $students = $this->studentRepository->getAll()->mapWithKeys(fn($student) => [$student->id => $student->name])->toArray();
        return view('pages.installment.payment', compact('data', 'installmentId', 'students'));
    }

    public function update(Request $request, string $installmentId, string $installmentPaymentId): RedirectResponse
    {
        $request->validate(Installment::validationRules($installmentPaymentId));

        $installment = $this->installmentRepository->find($installmentId);
        if ($request->get('amount') >  $installment->total) {
            return redirect()->back()->with('error', 'Tidak dapat mengupdate karena melebihi batas')->withInput();
        }
        if (!$this->installmentPaymentRepository->update($installmentPaymentId, [...$request->except('_token'), 'installment_id' => $installmentId])) {
            return redirect()->back()->with('error', 'Gagal mengupdate')->withInput();
        }
        return redirect()->back()->with('success', 'Berhasil mengupdate');
    }

    public function destroy(string $installmentId, string $installmentPaymentId): RedirectResponse
    {
        $deleted = $this->installmentPaymentRepository->delete($installmentPaymentId);
        if (!$deleted) back()->with('error', 'Gagal menghapus');
        return back()->with('success', 'Berhasil menghapus');
    }
}
