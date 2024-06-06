<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Repositories\Course\AbsenceRepository;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use App\Repositories\Course\TeacherRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{
    public function __construct(
        protected ClassRepository $classRepository,
        protected TeacherRepository $teacherRepository,
        protected AbsenceRepository $absenceRepository,
        protected StudentRepository $studentRepository,
    ) {
    }

    public function index(): View|Factory
    {
        Session::flash('warning', 'Under Development!');
        $events = $this->classRepository->getForCalendar();
        return view('pages.courses.absence.index', compact('events'));
    }

    public function form(Request $request)
    {
        $scheduleId = $request->get('id');
        $date = $request->get('date');
        $absence = $this->absenceRepository->getAbsence($scheduleId, $date);
        $teachers = $this->teacherRepository->getAll()->mapWithKeys(fn ($teacher) => [$teacher->id => $teacher->name])->toArray();
        $students = $this->studentRepository->getStudentsByScheduleId($scheduleId);
        $class = $this->classRepository->getBySchedule($scheduleId);

        return view('pages.courses.absence.form', compact('scheduleId', 'date', 'teachers', 'absence', 'students', 'class'));
    }

    public function submit()
    {
    }
}
