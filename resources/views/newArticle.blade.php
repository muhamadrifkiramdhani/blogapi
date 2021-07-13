@extends('layouts.app')

@section('title', 'New Article')

@section('content')
    <h2 class="m-5">New Article</h2>
    <form method="post">
        @csrf

        <div class="mb-3">
            <label for="frm-title" class="form-label">JUDUL</label>
            <input type="text" class="form-control" id="frm-title" name="frm-title" placeholder="input here...">
        </div>
        <div class="mb-3">
            <label for="frm-content" class="form-label">KONTEN</label>
            <textarea class="form-control" id="frm-content" name="frm-content" placeholder="Type text in here..." rows="3"></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary form-control">SUBMIT</button>
        </div>
    </form>
@endsection