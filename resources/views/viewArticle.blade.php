@extends('layouts.app')

@section('title', 'View Articles')

@section('content')

    <h2 class="m-5 p-0">{{ $data->title }}</h2>
    <p class="content p-2">{!! $data->content !!}</p>

    <div class="dropdown-divider"></div>

    <form action="{{ route('new_comment') }}" method="post" >
        @csrf

        {{-- <a href="{{ route('see_comment') }}" class="btn btn-info text-center text-white">See Comment</a> --}}
    
        <h3 class="text-center">Comment</h3>

        @foreach($comments as $comment)
        <div class="card">
            <div class="card-body">
            {{$comment->author}} : {{$comment->content}}
            </div>
        </div>
        @endforeach

       

        <div class="mb-3">
            <div class="col-md-4">
                <input type="hidden" class="form-control" id="frm-article-id" name="frm-article-id" value="{{ $data->id }}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <div class="col-md-4">
                <label for="frm-author" class="form-label"><small>PEMBUAT</small></label>
                <input type="text" class="form-control" id="frm-author" name="frm-author" value="{{ session()->get('name') }}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label for="frm-comment" class="form-label"><small>KOMEN</small></label>
            <textarea class="form-control" id="frm-comment" name="frm-comment" placeholder="Type text in here..." rows="3"></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-info form-control text-white">KOMEN</button>
        </div>
    </form>
@endsection