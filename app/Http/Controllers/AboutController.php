<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\About;
use Illuminate\Support\Facades\Storage;


class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // получение модели о нас
        $about = About::find(1);
        // dd($about);

        //* Compiled.
        // получение о нас
        $about = About::find(1);
        if($about) {
            // компиляция строки для сообщения в телеграм
            $compilation_string = $about->description;
            
            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/about.php', $compilation_string);
            //* End Compiled.
        }

        return view('Admin.Pages.about_show', ['about' => $about]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $r, $id = 'unrequired')
    {
        // если get, то вывод формы
        if ($r->isMethod('GET')) {

            // получение мероприятия
            $about = About::find(1);

            return view('Admin.Pages.about_form', ['about' => $about]);
        }

        // если post, то обновление о нас в базе данных
        if ($r->isMethod('POST')) {

            // получение о нас
            $about = About::find(1);
            
            if(!$about) {
                $about = About::create($r->all());
            }

            // обновление о нас
            $about->update($r->all());

            //* Compiled.
            // получение о нас
            $about = About::find(1);

            // компиляция строки для сообщения в телеграм
            $compilation_string = $about->description;

            // компиляция файла с сообщением для телеграм
            $compiled = Storage::disk('local')->put('/telegram/messages/squirrel/about.php', $compilation_string);
            //* End Compiled.

            // сообщение о результате выполнения операции
            $r->session()->flash('message', 'Информация успешно обновлена.');

            return redirect()->route('admin.about.edit');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
