<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{

    public function data()
    {
        $kelas = DB::table('kelas')->simplePaginate(5);
        return view('kelas.data')->with('kelas', $kelas);
    }

    public function add()
    {
        return view('kelas.add');
    }

    public function addProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'desc' => 'required',
        ], [
            'name.required' => 'Nama kelas tidak boleh kosong'
        ]);

        DB::table('kelas')->insert([
            'name' => $request->name,
            'desc' => $request->desc
        ]);
        return redirect('kelas')->with('status', 'Kelas berhasil ditambah!');
    }

    public function edit($id)
    {
        $kelas = DB::table('kelas')->where('id', $id)->first();
        return view('kelas/edit', compact('kelas'));
    }

    public function editProcess(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2',
            'desc' => 'required',
        ]);

        DB::table('kelas')->where('id', $id)
            ->update([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
        return redirect('kelas')->with('status', 'Kelas berhasil diupdate!');
    }

    public function delete($id)
    {
        DB::table('kelas')->where('id', $id)->delete();
        return redirect('kelas')->with('status', 'Kelas berhasil dihapus!');
    }
}
