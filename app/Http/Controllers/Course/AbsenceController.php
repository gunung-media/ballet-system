<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Repositories\Course\ClassRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{
    public function __construct(
        protected ClassRepository $classRepository,
    ) {
    }

    public function index(): View|Factory
    {
        Session::flash('warning', 'Under Development!');
        $events = $this->classRepository->getForCalendar();
        return view('pages.courses.absence.index', compact('events'));
    }
}
