<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingRepository $settingRepository,
    ) {}

    public function index(): View|Factory
    {
        return view('pages.setting', ['data' => $this->settingRepository->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Setting::validationRules());

        try {
            $this->settingRepository->createOrUpdate($request->except('_token'));
            return redirect()->intended(route('setting.index'))->with('success', 'Berhasil');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }
}
