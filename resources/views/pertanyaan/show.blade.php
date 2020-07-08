@extends('layouts.app')

@push('css')
  <style>
    .vote-container {
      width: 80px;
    }

    .vote-count {
      display: block;
      text-align: center;
      font-size: 20px;
    }

    .vote-up, .vote-down {
      display: block;
      text-align: center;
      font-size: 30px;
      cursor: pointer;
      color: #ccc!important;
    }

    .vote-up.active svg,
    .vote-down.active svg{
      color: #3490dc!important;
    }
  </style>
@endpush

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1>Detail Pertanyaan</h1>

      @include('layouts.inc.messages')

      @php
        $isLoggedIn = false;
        $userId = null;
        if (auth()->check()) {
          $isLoggedIn = true;
          $userId = auth()->user()->id;
        }
      @endphp

      <div class="card mb-4">
        <div class="card-body">
          <div class="media mb-2">
            <div class="mr-3 vote-container">
              <a class="vote-up">
                <i class="fa fa-caret-up"></i>
              </a>
              <span class="vote-count">
                {{ $thread->vote }}
              </span>
              <a class="vote-down">
                <i class="fa fa-caret-down"></i>
              </a>
            </div>

            <div class="media-body">
              <div class="media mb-2">
                <img class="d-flex mr-3 img-thumbnail rounded-circle" src="https://api.adorable.io/avatars/50/{{ $thread->user->email }}.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">{{ $thread->user->name }}</h5>
                  <span class="text-muted">{{ $thread->created_at->diffForHumans() }}</span>
                </div>
              </div>

              <h3>
                <a href="{{ route('pertanyaan.show', $thread->id) }}">
                  {{ $thread->title }}
                </a>
              </h3>
              <p>
                {{ $thread->content }}
              </p>

              <div class="row">
                <div class="col-sm-4">
                  <span class="text-muted">
                    {{ $thread->replies_count }}
                    Jawaban
                  </span>
                </div>
                <div class="col-sm-8">
                </div>
                <div class="col-sm-12">
                  <span class="text-muted">Dibuat {{ $thread->created_at->diffForHumans() }} </span> ·
                  <span class="text-muted">Diperbarui {{ $thread->updated_at->diffForHumans() }}</span>
                </div>
              </div>

              @if ($isLoggedIn && $thread->user_id == $userId)
                <div class="mt-4">
                  <a class="btn btn-success btn-sm" href="{{ route('pertanyaan.edit', $thread->id) }}">Edit</a>

                  <form style="display: inline-block;" action="{{ route('pertanyaan.destroy', $thread->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                  </form>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          @if (auth()->check())
            <form action="{{ route('jawaban.store', $thread->id) }}" method="POST">
              @csrf

              <div class="form-group">
                <label>Jawaban</label>
                <textarea class="form-control" name="content" rows="5"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          @else
            <div class="alert alert-warning mb-0">
              Silahkan <a href="{{ route('login') }}">login</a> untuk menjawab pertanyaan
            </div>
          @endif
        </div>
      </div>

      <h3 class="mb-4">Jawaban</h3>
      @if (count($thread->replies))
        @foreach ($thread->replies as $reply)
          <div class="card mb-4">
            <div class="card-body">
              <div class="media mb-2">
                <div class="mr-3 vote-container">
                  <a class="vote-up">
                    <i class="fa fa-caret-up"></i>
                  </a>
                  <span class="vote-count">
                    {{ $thread->vote }}
                  </span>
                  <a class="vote-down">
                    <i class="fa fa-caret-down"></i>
                  </a>
                </div>

                <div class="media-body">
                  <div class="media mb-2">
                    <img class="d-flex mr-3 img-thumbnail rounded-circle" src="https://api.adorable.io/avatars/50/{{ $reply->user->email }}.png" alt="Generic placeholder image">
                    <div class="media-body">
                      <h5 class="mt-0">{{ $reply->user->name }}</h5>
                      <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                  </div>

                  <p>
                    {{ $reply->content }}
                  </p>
                </div>
              </div>

            </div>
          </div>
        @endforeach
      @else
        <div class="alert alert-warning">
          Pertanyaan ini belum memiliki jawaban.
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
