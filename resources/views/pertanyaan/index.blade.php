@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">List Pertanyaan</div>

        <div class="card-body">

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

          @if (count($threads))
            @foreach ($threads as $thread)
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
            @endforeach

            {{ $threads->links() }}
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
