@extends('main')

@section('title', 'EduLevel')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Guru</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">Guru</a></li>
                        <li class="active">Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                        <strong>Data Guru</strong>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('teachers/add') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Guru</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teachers as $key => $item)
                            <tr>
                                <td>{{ $teachers->firstItem() + $key }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">
                                    <a href="{{ url('teachers/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <form action="{{ url('teachers/'.$item->id) }}" method="post" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
