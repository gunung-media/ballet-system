<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): View|Factory
    {
        return view('pages.courses.student.index');
    }

    public function create(): View|Factory
    {
        return view('pages.courses.student.form');
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
