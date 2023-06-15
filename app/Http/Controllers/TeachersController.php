<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersController extends Controller
{
    public function data()
    {
        $teacher = DB::table('teachers')->simplePaginate(5);
        return view('teachers.data')->with('teachers', $teacher);
    }

    public function add()
    {
        return view('teachers.add');
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
        ], [
            'name.required' => 'Nama guru tidak boleh kosong'
        ]);

        DB::table('teachers')->insert([
            'name' => $request->name,
        ]);
        return redirect('teachers')->with('status', 'Guru berhasil ditambah!');
    }

    public function edit($id)
    {
        $teacher = DB::table('teachers')->where('id', $id)->first();
        return view('teachers/edit', compact('teacher'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        DB::table('teachers')->where('id', $id)
            ->update([
                'name' => $request->name,
            ]);
        return redirect('teachers')->with('status', 'Guru berhasil diupdate!');
    }

    public function delete($id)
    {
        DB::table('teachers')->where('id', $id)->delete();
        return redirect('teachers')->with('status', 'Guru berhasil dihapus!');
    }
}
