@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1>Edit Pertanyaan</h1>
      <div class="card">
        <div class="card-body">

          @include('layouts.inc.messages')

          <form action="{{ route('pertanyaan.update', $thread->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" name="title" value="{{ old('title', $thread->title) }}">
            </div>

            <div class="form-group">
              <label>Pertanyaan</label>
              <textarea class="form-control" name="content" rows="5">{{ old('content', $thread->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-outline-primary" href="{{ route('pertanyaan.show', $thread->id) }}">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
