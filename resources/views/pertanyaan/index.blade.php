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
      <h1>List Pertanyaan</h1>

      @include('layouts.inc.messages')

      @php
        $isLoggedIn = false;
        $userId = null;
        if (auth()->check()) {
          $isLoggedIn = true;
          $userId = auth()->user()->id;
        }
      @endphp

      @if (count($threads))
        @foreach ($threads as $thread)
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
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
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
        @endforeach

        {{ $threads->links() }}
      @endif

    </div>
  </div>
</div>
@endsection
