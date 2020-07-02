@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Buat Pertanyaan</div>

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

          <form action="{{ route('pertanyaan.index') }}" method="POST">
            @csrf

            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" name="title">
            </div>

            <div class="form-group">
              <label>Pertanyaan</label>
              <textarea class="form-control" name="content" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
