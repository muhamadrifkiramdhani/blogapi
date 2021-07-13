@extends('layouts.app')

@section('title', 'Update Articles')

@section('content')
    <h2 class="m-5">Update data {{ $data->title }}</h2>
    <form method="POST">
        @method('PATCH')
        @csrf

        <div class="mb-3">
            <input type="hidden" class="form-control" id="idf" name="idf" value="{{ $data->id }}" placeholder="input here...">
        </div>
        <div class="mb-3">
            <label for="frm-title" class="form-label">JUDUL</label>
            <input type="text" class="form-control" id="frm-title" name="frm-title" value="{{ $data->title }}" placeholder="input here...">
        </div>
        <div class="mb-3">
            <label for="frm-content" class="form-label">KONTEN</label>
            <textarea class="form-control" id="frm-content" name="frm-content" rows="3" placeholder="Type text in here...">{{ $data->content }}</textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-warning text-white form-control">UPDATE</button>
        </div>
    </form>
@endsection