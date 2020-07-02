@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Detail Pertanyaan</div>

        <div class="card-body">

          <h3>
            <a href="{{ route('jawaban.index', $thread->id) }}">
              {{ $thread->title }}
            </a>
          </h3>
          <small class="text-muted">Oleh {{ $thread->user->name }} - {{ $thread->created_at->diffForHumans() }}</small>
          <p>
            {{ $thread->content }}
          </p>
          <hr>

          @if ($errors->any())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                {{ $error }}<br>
              @endforeach
            </div>
          @endif

          @if (session()->has('successMessage'))
            <div class="alert alert-success">
              {{ session('successMessage') }}
            </div>
          @endif

          @if (auth()->check())
            <form action="{{ route('jawaban.store', $thread->id) }}" method="POST">
              @csrf

              <div class="form-group">
                <label>Jawaban</label>
                <textarea class="form-control" name="content" rows="5"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <hr>
          @endif

          @if (count($thread->replies))
            <h3>Jawaban</h3>
            @foreach ($thread->replies as $reply)
              <small class="text-muted">Oleh {{ $thread->user->name }} - {{ $thread->created_at->diffForHumans() }}</small>
              <p>
                {{ $thread->content }}
              </p>
              <hr>
            @endforeach
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
