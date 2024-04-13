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

    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $car->name }}">

        <label for="brand">Brand</label>
        <input type="text" class="form-control" name="brand" id="brand" value="{{ $car->brand }}">

        <label for="img">Img</label>
        <input type="file" class="form-control" name="img" id="img">
        <img src="{{ asset($car->img) }}" alt="" width="50px">

        <label for="describe">Describe</label>
        <textarea class="form-control" name="describe" id="describe" value="{{ $car->describe }}"></textarea>

        <label for="categories">Category</label>
        <select name="category_id" class="form-control">
            @foreach ($categories as $key=>$cat)
                <option {{ $key == $car->item_id ? 'selected' : '' }} value="{{ $key }}">{{ $cat }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('cars.index') }}" class="btn btn-warning">Return</a>
    </form>
@endsection
