<?php

namespace App\Http\Controllers;

use App\Enums\StudentStatusEnum;
use App\Enums\TeacherStatus;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use App\Repositories\Course\TeacherRepository;
use App\Repositories\Course\TuitionTransactionRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected TuitionTransactionRepository $tuitionTransactionRepository,
        protected StudentRepository $studentRepository,
        protected ClassRepository $classRepository,
        protected TeacherRepository $teacherRepository,
    ) {}

    public function index()
    {
        $tuition = $this->tuitionTransactionRepository->getAll();
        $tuition = $tuition->reduce(fn($carry, $item) => $carry + $item->amount, 0);

        $students = $this->studentRepository->getAll()->filter(fn($item) => $item->status == StudentStatusEnum::APPROVED)->count();
        $classes = $this->classRepository->getAll()->count();
        $teachers = $this->teacherRepository->getAll()->count();

        return view('pages.index', compact('tuition', 'students', 'classes', 'teachers'));
    }
}
