@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">The weather is hot: {{ $weather->getTemp() }} {{-- $weather->getTempSym() --}}. Your categories:</div>
                {!! $weather->getImage() !!}

                <div class="card-body">
                  <ul class="list-group">
                    @foreach($categories as $category)
                      <a class="list-group-item list-group-item-action" href="{{ route('category', $category->id) }}">
                        {{ $category->title }}
                      </a>
                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add photo</div>
                <div class="card-body">

                    <form method="post" action="{{ route('createCategory') }}" class="form-inline">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label>
                          Category name:
                        </label>
                        <input type="text" name="title" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>
                          Is private:
                        </label>
                        <input type="checkbox" name="is_private" value="1" class="form-control">
                      </div>
                      <input type="submit" value="Add new Category" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
