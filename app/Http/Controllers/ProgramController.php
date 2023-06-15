<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kelas;
use App\Models\Teachers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $programs = Program::with('kelas')->paginate(10);
        return view('program/index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $kelas = Kelas::all();
        $namaGuru = Teachers::all();
        return view('program.create', compact('kelas', 'namaGuru'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'fk_kelas' => 'required',
            'fk_teachers' => 'required'
        ], [
            'fk_teachers.required' => 'Nama guru diperlukan',
            'fk_kelas.required' => 'Nama kelas diperlukan'
        ]);
        Program::create($request->all());
        return redirect('programs')->with('status', 'Program berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param Program $program
     * @return Application|Factory|View
     */
    public function show(Program $program)
    {
        $program->makeHidden(['kelas']);
        return view('program/show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Program $program
     * @return Application|Factory|View
     */
    public function edit(Program $program)
    {
        $kelas = Kelas::all();
        $namaGuru = Teachers::all();
        return view('program.edit', compact('program', 'kelas', 'namaGuru'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Program $program
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|min:3',
            'fk_kelas' => 'required',
            'fk_teachers' => 'required'
        ], [
            'fk_teachers.required' => 'Nama guru diperlukan',
            'fk_kelas.required' => 'Nama kelas diperlukan'
        ]);
        Program::where('id', $program->id)
            ->update([
                'name' => $request->name,
                'fk_kelas' => $request->fk_kelas,
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
     * @param Program $program
     * @return Application|RedirectResponse|Redirector
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
