@extends('layouts.master')

@section('content')
    <h1>Thêm mới Car</h1>

    @if (\Session::has('msg'))
        <div class="alert alert-success">
            {{ \Session::get('msg') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">

        <label for="brand">Brand</label>
        <input type="text" class="form-control" name="brand" id="brand">

        <label for="img">Img</label>
        <input type="file" class="form-control" name="img" id="img">

        <label for="describe">Describe</label>
        <textarea class="form-control" name="describe" id="describe"></textarea>

        <label for="categories">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            @foreach ($categories as $id=>$name)
                <option value="{{ $id }}">{{ $id }} - {{ $name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('cars.index') }}" class="btn btn-warning">Return</a>
    </form>
@endsection
