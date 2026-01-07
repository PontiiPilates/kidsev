<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Program;
use App\Models\Timetable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProgramController extends Controller
{
    /**
     * Вывод всех программ.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // получение всех программ
        $programs = Program::all()->sortBy('name');

        return view('Admin.Pages.programs_index', ['programs' => $programs]);
    }

    /**
     * Вывод формы для добавления программы.
     * Добавление расписания в базу данных.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {
        // если get, то вывод формы
        if ($r->isMethod('GET')) {
            return view('Admin.Pages.program_form');
        }

        // если post, то добавление в базу данных
        if ($r->isMethod('POST')) {

            // добавление программы
            $program = Program::create($r->all());

            // если если существует расписание, то добавление расписания
            if ($r->day && $r->time) {

                // сопоставления для возможности сортировки по дням
                $days = [
                    'Пн' => 1,
                    'Вт' => 2,
                    'Ср' => 3,
                    'Чт' => 4,
                    'Пт' => 5,
                    'Сб' => 6,
                    'Вс' => 7,
                ];

                foreach ($r->day as $k => $v) {

                    $day = $v;
                    $day_number = $days[$day];
                    $time = $r->time[$k];
                    $entity_id = $program->id;
                    $type = 'program';

                    // добавление расписания
                    $timetable = Timetable::create(['day' => $day, 'day_number' => $day_number, 'time' => $time, 'entity_id' => $entity_id, 'type' => $type]);
                }
            }

            //* Compiled.
            $timetable = DB::table('timetables')
                ->join('programs', 'timetables.entity_id', 'programs.id')
                ->where('type', 'program')
                ->select('timetables.day', 'timetables.time', 'programs.name')
                ->orderBy('day_number')
                ->orderBy('time')
                ->get();


            // компиляция строки для сообщения в телеграм
            $compilation_string = '';
            $i = 0;

            foreach ($timetable as $item) {

                // вывод дня при первой итерации
                if ($i == 0) {
                    $compilation_string = "🗓 $item->day\r\n";
                }

                // вывод дня при последующей итерации
                if ($i > 0) {
                    if ($item->day != $timetable[$i - 1]->day) {
                        $compilation_string .= "\r\n🗓 $item->day\r\n";
                    }
                }

                // вывод остального контента
                $time = mb_strcut($item->time, 0, 5);
                $compilation_string .= "$time $item->name\r\n";

                $i++;
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/timetable.php', $compilation_string);
            //* End Compiled.

            //* Program List Compiled.
            $programs = Program::where('status', 1)->select('name')->orderBy('name')->get();

            $compilation_programs = '';
            foreach ($programs as $v) {
                $compilation_programs .= "$v->name\r\n";
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/programs.php', $compilation_programs);
            //* End Program List Compiled.

            // сообщение о результате выполнения операции
            $r->session()->flash('message', "Программа \"$program->name\" успешно добавлена.");

            return redirect()->route('admin.programs.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Вывод программы.
     * Вывод расписания.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $r, $id = 'unrequired')
    {

        // если адрес просмотра программы
        if (url()->current() == route('admin.program.show', ['id' => $id])) {

            // получение программы
            $program = Program::find($id);

            // получение расписания
            $timetable = Timetable::where('entity_id', $id)->where('type', 'program')->orderBy('day_number')->orderBy('time')->get();

            return view('Admin.Pages.program_show', ['id' => $id, 'program' => $program, 'timetable' => $timetable]);
        }

        // если адрес просмотра расписания
        if (url()->current() == route('admin.timetable.programs.show')) {

            //* Compiled.
            // получение расписания
            $timetable = DB::table('timetables')
                ->join('programs', 'timetables.entity_id', 'programs.id')
                ->where('type', 'program')
                ->select('timetables.day', 'timetables.time', 'programs.name')
                ->orderBy('day_number')
                ->orderBy('time')
                ->get();


            // компиляция строки для сообщения в телеграм
            $compilation_string = '';
            $i = 0;

            foreach ($timetable as $item) {

                // вывод дня при первой итерации
                if ($i == 0) {
                    $compilation_string = "🗓 $item->day\r\n";
                }

                // вывод дня при последующей итерации
                if ($i > 0) {
                    if ($item->day != $timetable[$i - 1]->day) {
                        $compilation_string .= "\r\n🗓 $item->day\r\n";
                    }
                }

                // вывод остального контента
                $time = mb_strcut($item->time, 0, 5);
                if ($time) {
                    $compilation_string .= "$time $item->name\r\n";
                } else {
                    $compilation_string .= "$item->name\r\n";
                }

                $i++;
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/timetable.php', $compilation_string);
            //* End Compiled.


            //* Program List Compiled.
            $programs = Program::where('status', 1)->select('name')->orderBy('name')->get();

            $compilation_programs = '';
            foreach ($programs as $v) {
                $compilation_programs .= "$v->name\r\n";
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/programs.php', $compilation_programs);
            //* End Program List Compiled.

            return view('Admin.Pages.programs_timetable', ['compilation_string' => $compilation_string, 'compilation_programs' => $compilation_programs]);
        }
    }

    /**
     * Редактирование программы.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $r, $id)
    {

        // если get, то вывод формы
        if ($r->isMethod('GET')) {

            // получение программы
            $program = Program::find($id);

            // получение расписания
            $timetable = Timetable::where('entity_id', $id)->where('type', 'program')->orderBy('day_number')->orderBy('time')->get();

            return view('Admin.Pages.program_form', ['id' => $id, 'program' => $program, 'timetable' => $timetable]);
        }

        // если post, то обновление программы в базе данных
        if ($r->isMethod('POST')) {

            // получение программы
            $program = Program::find($id);

            // обновление программы
            $program->update($r->all());

            // дополнительное обновление при отсутствующем статусе
            if (!$r->status) {
                $program->update(['status' => 0]);
            }

            // очистка расписания для обновляемой программы, чтобы избежать дублей
            $timetable = Timetable::where('entity_id', $id)->delete();

            // сопоставления для возможности сортировки по дням
            if ($r->day && $r->time) {

                // сопоставления для возможности сортировки по дням
                $days = [
                    'Пн' => 1,
                    'Вт' => 2,
                    'Ср' => 3,
                    'Чт' => 4,
                    'Пт' => 5,
                    'Сб' => 6,
                    'Вс' => 7,
                ];

                foreach ($r->day as $k => $v) {

                    $day = $v;
                    $day_number = $days[$day];
                    $time = $r->time[$k];
                    $entity_id = $program->id;
                    $type = 'program';

                    // добавление расписания
                    $timetable = Timetable::create(['day' => $day, 'day_number' => $day_number, 'time' => $time, 'entity_id' => $entity_id, 'type' => $type]);
                }
            }

            //* Compiled.
            $timetable = DB::table('timetables')
                ->join('programs', 'timetables.entity_id', 'programs.id')
                ->where('type', 'program')
                ->select('timetables.day', 'timetables.time', 'programs.name')
                ->orderBy('day_number')
                ->orderBy('time')
                ->get();


            // компиляция строки для сообщения в телеграм
            $compilation_string = '';
            $i = 0;

            foreach ($timetable as $item) {

                // вывод дня при первой итерации
                if ($i == 0) {
                    $compilation_string = "🗓 $item->day\r\n";
                }

                // вывод дня при последующей итерации
                if ($i > 0) {
                    if ($item->day != $timetable[$i - 1]->day) {
                        $compilation_string .= "\r\n🗓 $item->day\r\n";
                    }
                }

                // вывод остального контента
                $time = mb_strcut($item->time, 0, 5);
                $compilation_string .= "$time $item->name\r\n";

                $i++;
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/timetable.php', $compilation_string);
            //* End Compiled.

            //* Program List Compiled.
            $programs = Program::where('status', 1)->select('name')->orderBy('name')->get();

            $compilation_programs = '';
            foreach ($programs as $v) {
                $compilation_programs .= "$v->name\r\n";
            }

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/programs.php', $compilation_programs);
            //* End Program List Compiled.

            // сообщение о результате выполнения операции
            $r->session()->flash('message', 'Программа успешно обновлена.');

            return redirect()->route('admin.program.show', ['id' => $program->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Удаление программы.
     * Удаление расписания к программе.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, $id)
    {
        // получение программы
        $program = Program::find($id);
        // получение названия программы
        $program_name = $program->name;
        // удаление программы
        $program->delete();
        // удаление расписания для программы
        $timetable = Timetable::where('entity_id', $id)->where('type', 'program')->delete();

        // сообщение о результате выполнения операции
        $r->session()->flash('message', "Программа \"$program_name\" успешно удалена.");

        return redirect()->route('admin.programs.index');
    }
}
