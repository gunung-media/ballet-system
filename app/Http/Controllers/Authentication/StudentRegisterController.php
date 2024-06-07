<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\GenderEnum;
use App\Enums\StudentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Course\Student;
use App\Repositories\Course\StudentRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentRegisterController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository
    ) {
    }

    public function register(): View|Factory
    {
        $genders = GenderEnum::class;
        return view('sign-up', compact('genders'));
    }

    public function registerPost(Request $request): RedirectResponse
    {
        $request->validate(Student::validationRules());

        try {
            $this->studentRepository->insert([...$request->except('_token'), 'status' => StudentStatusEnum::PENDING]);
            return redirect()->intended(route('auth.register'))->with('success', 'Berhasil Daftar');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }
}
