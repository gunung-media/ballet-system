<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Repositories\Course\AbsenceRepository;
use App\Repositories\Course\AbsenceStudentRepository;
use App\Repositories\Course\ClassRepository;
use App\Repositories\Course\StudentRepository;
use App\Repositories\Course\TeacherRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function __construct(
        protected ClassRepository $classRepository,
        protected TeacherRepository $teacherRepository,
        protected AbsenceRepository $absenceRepository,
        protected AbsenceStudentRepository $absenceStudentRepository,
        protected StudentRepository $studentRepository,
    ) {
    }

    public function index(): View|Factory
    {
        $events = $this->classRepository->getForCalendar();
        return view('pages.courses.absence.index', compact('events'));
    }

    public function form(Request $request): View|Factory
    {
        $scheduleId = $request->get('id');
        $date = $request->get('date');
        $absence = $this->absenceRepository->getAbsence($scheduleId, $date);
        $teachers = $this->teacherRepository->getAll()->mapWithKeys(fn ($teacher) => [$teacher->id => $teacher->name])->toArray();
        $students = $this->studentRepository->getStudentsByScheduleId($scheduleId);
        $class = $this->classRepository->getBySchedule($scheduleId);

        return view('pages.courses.absence.form', compact('scheduleId', 'date', 'teachers', 'absence', 'students', 'class'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $isSubmit = $request->has('is_submit');

        try {
            if ($isSubmit) {
                $this->absenceRepository->insert($request->except('token'));
                return redirect()->back()->with('success', 'Absence created successfully!');
            }

            $this->absenceStudentRepository->createOrUpdate($request->except('token'));
            return redirect()->back()->with('success', 'Siswa berhasil absen!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
