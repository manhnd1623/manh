@extends('layouts.master')

@section('content')
    <h1>Thêm mới Device</h1>

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

    <form action="{{ route('devices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">

        <label for="serial">Serial</label>
        <input type="text" class="form-control" name="serial" id="serial">

        <label for="model">Model</label>
        <input type="text" class="form-control" name="model" id="model">

        <label for="img">Img</label>
        <input type="file" class="form-control" name="img" id="img">

        <label for="categories">Category</label>
        <select name="category_id" class="form-control" id="category_id">
            @foreach ($categories as $id=>$name)
                <option value="{{ $id }}">{{ $id }} - {{ $name }}</option>
            @endforeach
        </select>

        <label for="is_active">Status</label>
        <input type="radio" value="{{ \App\Models\Device::ACTIVE }}" name="is_active" id="is_active-1">
        <label for="is_active-1">Active</label>

        <input type="radio" value="{{ \App\Models\Device::INACTIVE }}" name="is_active" id="is_active-2">
        <label for="is_active-2">Inactive</label>
        <br>

        <label for="describe">Describe</label>
        <textarea class="form-control" name="describe" id="describe"></textarea>
        <br>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('devices.index') }}" class="btn btn-primary">Return</a>
    </form>
@endsection
