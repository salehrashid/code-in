<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Edulevel;
use App\Models\Teachers;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::with('edulevel')->paginate(10);
//        $teachers = Teachers::with('teachers')->paginate(10);
        return view('program/index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edulevels = Edulevel::all();
        $namaGuru = Teachers::all();
        return view('program.create', compact('edulevels', 'namaGuru'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'edulevel_id' => 'required',
            'fk_teachers' => 'required'
        ], [
            'fk_teachers.required' => 'Nama guru diperlukan',
            'edulevel_id.required' => 'Nama kelas diperlukan'
        ]);
        Program::create($request->all());
        return redirect('programs')->with('status', 'Program berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Program $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $program->makeHidden(['edulevel_id']);
        return view('program/show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Program $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        $edulevels = Edulevel::all();
        $namaGuru = Teachers::all();
        return view('program.edit', compact('program', 'edulevels', 'namaGuru'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Program $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|min:3',
            'edulevel_id' => 'required',
            'fk_teachers' => 'required'
        ], [
            'fk_teachers.required' => 'Nama guru diperlukan',
            'edulevel_id.required' => 'Nama kelas diperlukan'
        ]);
        Program::where('id', $program->id)
            ->update([
                'name' => $request->name,
                'edulevel_id' => $request->edulevel_id,
                'fk_teachers' => $request->fk_teachers,
                'student_price' => $request->student_price,
                'student_max' => $request->student_max,
                'info' => $request->info,
            ]);

        return redirect('programs')->with('status', 'Program berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Program $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();
        return redirect('programs')->with('status', 'Program berhasil masuk tong sampah!');
    }

    public function trash()
    {
        $programs = Program::onlyTrashed()->get();
        return view('program.trash', compact('programs'));
    }

    public function restore($id = null)
    {
        if ($id != null) {
            $programs = Program::onlyTrashed()
                ->where('id', $id)
                ->restore();
        } else {
            $programs = Program::onlyTrashed()->restore();
        }
        return redirect('programs/trash')->with('status', 'Program berhasil di-restore!');
    }

    public function delete($id = null)
    {
        if ($id != null) {
            $programs = Program::onlyTrashed()
                ->where('id', $id)
                ->forceDelete();
        } else {
            $programs = Program::onlyTrashed()->forceDelete();
        }
        return redirect('programs/trash')->with('status', 'Program berhasil dihapus permanen!');
    }
}
