<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(): View|Factory
    {
        Session::flash('warning', 'Under Development!');
        return view('pages.sales.category.index');
    }

    public function create(): View|Factory
    {
        Session::flash('warning', 'Under Development!');
        return view('pages.sales.category.form');
    }

    public function store(Request $request): void
    {
        //
    }

    public function show(string $id): void
    {
        //
    }

    public function edit(string $id): void
    {
        //
    }

    public function update(Request $request, string $id): void
    {
        //
    }

    public function destroy(string $id): void
    {
        //
    }
}
