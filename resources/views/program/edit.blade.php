@extends('main')

@section('title', 'Program')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Program</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">Program</a></li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                        <strong>Edit Program</strong>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('programs') }}" class="btn btn-secondary btn-sm rounded">
                            <i class="fa fa-undo"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('programs/'.$program->id) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>Nama Program</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $program->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="fk_kelas"
                                            class="form-control @error('fk_kelas') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        @foreach ($kelas as $item)
                                            <option
                                                value="{{ $item->id }}" {{ old('fk_kelas', $program->fk_kelas) == $item->id ? 'selected' : null }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fk_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Guru</label>
                                    <select name="fk_teachers"
                                            class="form-control @error('fk_teachers') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        @foreach ($namaGuru as $item)
                                            <option
                                                value="{{ $item->id }}" {{ old('fk_teachers') == $item->fk_teachers ? 'selected' : null }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fk_teachers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Member</label>
                                    <input type="number" name="student_price"
                                           class="form-control @error('student_price') is-invalid @enderror"
                                           value="{{ old('student_price', $program->student_price) }}">
                                    @error('student_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Member Maksimal</label>
                                    <input type="number" name="student_max"
                                           class="form-control @error('student_max') is-invalid @enderror"
                                           value="{{ old('student_max', $program->student_max) }}">
                                    @error('student_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Info</label>
                                    <textarea name="info"
                                              class="form-control @error('info') is-invalid @enderror">{{ old('info', $program->info) }}</textarea>
                                    @error('info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success rounded">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
