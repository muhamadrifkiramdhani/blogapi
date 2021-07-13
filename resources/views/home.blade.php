@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row mx-3 p-4">
        @foreach ($data as $item)
       <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="../img/default.png" alt="Card image cap">
          <div class="card-body">
             <div class="card-header">
                <h3 class="card-title">{{ $item->title }}</h3>
                    </div>
                        <small class="card-subtitle mb-2 text-muted">{{ $item->created_at }}</small>
                        <p class="card-text">
                            {{ Str::limit(strip_tags($item->content), 20, '...') }}
                            <a href="{{ url('/articles/'. $item->id) }}"><small>BACA SELENGKAPNYA</small></a>
                        </p>
                            <a href="{{ url('/articles/update/' . $item->id) }}" class="btn btn-primary ">Edit</a>
                            <form method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ url('/articles/delete/' . $item->id) }}" class="btn btn-danger">Delete</a>
                            </form>
          </div>
        </div>
                
        @endforeach
    </div>
@endsection