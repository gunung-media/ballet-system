<?php

namespace App\Http\Controllers;

use App\Models\Installment\Installment;
use App\Models\Installment\InstallmentPayment;
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
    ) {}

    public function create(string $installmentId): View|Factory
    {
        return view('pages.installment.payment', compact('installmentId'));
    }

    public function store(Request $request, string $installmentId): RedirectResponse
    {
        $request->validate(InstallmentPayment::validationRules());

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
        return view('pages.installment.payment', compact('data', 'installmentId'));
    }

    public function update(Request $request, string $installmentId, string $installmentPaymentId): RedirectResponse
    {
        $request->validate(Installment::validationRules($installmentPaymentId));
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
