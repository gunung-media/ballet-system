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
    ) {}

    public function index(): View|Factory
    {
        $events = $this->classRepository->getForCalendar();
        $absences = $this->absenceRepository->getAbsences();
        return view('pages.courses.absence.index', compact('events', 'absences'));
    }

    public function form(Request $request): View|Factory
    {
        $scheduleId = $request->get('id');
        $date = $request->get('date');
        $absence = $this->absenceRepository->getAbsence($scheduleId, $date);
        $teachers = $this->teacherRepository->getAll()->mapWithKeys(fn($teacher) => [$teacher->id => $teacher->name])->toArray();
        $students = $this->studentRepository->getStudentsByScheduleId($scheduleId);
        $class = $this->classRepository->getBySchedule($scheduleId);

        $getStudentState = function ($studentId) use ($absence) {
            $student = $absence->students
                ->where('student_id', $studentId)
                ->first();

            if ($student) {
                return $student->state;
            }
            return null;
        };

        return view('pages.courses.absence.form', compact('scheduleId', 'date', 'teachers', 'absence', 'students', 'class', 'getStudentState'));
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

    public function perClass($className)
    {
        $props = [
            'isClassWrong' => false,
            'isNoSchedule' => false,
        ];
        $class = $this->classRepository->getByClassName($className);
        if (is_null($class)) {
            $props['isClassWrong'] = true;
            session()->flash('warning', 'Kelas tidak ditemukan');
            return view('pages.courses.absence.class', $props)->with('warning', 'Kelas tidak ditemukan');
        }
        $date = now();
        $dayIndex = $date->dayOfWeek;
        $daysInIndonesian = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $today = $daysInIndonesian[$dayIndex];
        $schedule = collect($class->schedules->toArray())->where('day', $today)->first();
        if (is_null($schedule)) {
            $props['isNoSchedule'] = true;
            session()->flash('warning', 'Tidak ada jadwal pada hari ini');
            return view('pages.courses.absence.class', $props)->with('warning', 'Tidak ada jadwal pada hari ini');
        }

        $absence = $this->absenceRepository->getAbsence($schedule['id'], $date);
        $teachers = $this->teacherRepository->getAll()->mapWithKeys(fn($teacher) => [$teacher->id => $teacher->name])->toArray();
        $students = $this->studentRepository->getStudentsByScheduleId($schedule['id']);
        $class = $this->classRepository->getBySchedule($schedule['id']);

        $getStudentState = function ($studentId) use ($absence) {
            $student = $absence->students
                ->where('student_id', $studentId)
                ->first();

            if ($student) {
                return $student->state;
            }
            return null;
        };
        $props = array_merge($props, compact('schedule', 'absence', 'teachers', 'students', 'class', 'getStudentState', 'date'));
        return view('pages.courses.absence.class', $props);
    }
}
