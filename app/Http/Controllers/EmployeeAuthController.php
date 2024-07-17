<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAbsence;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeAuthController extends Controller
{
    public function showLoginForm(): View|Factory
    {
        return view('sign-in', ['isEmployee' => true]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::guard('employee')->attempt($credentials, $request->input('remember'))) {
            return redirect()->intended(route('employee.index'))->with('success', 'Berhasil Login');
        }
        return redirect()->back()->with('error', 'Email atau Password anda salah')->withInput();
    }

    public function logout(): Redirector|RedirectResponse
    {
        Auth::guard('employee')->logout();
        return redirect(route('employee.login'));
    }

    public function index()
    {
        $employeeId = auth('employee')->id();
        $dataToCheck = EmployeeAbsence::where('teacher_id', $employeeId)
            ->whereDate('date', date('Y-m-d'))
            ->first();

        return view('pages.employee-index', compact('dataToCheck'));
    }
}
