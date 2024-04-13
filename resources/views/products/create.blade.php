@extends('layouts.master')

@section('content')
    <h1>Thêm mới Product</h1>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">

        <label for="price">Price</label>
        <input type="text" class="form-control" name="price" id="price">

        <label for="price_sale">Price Sale</label>
        <input type="text" class="form-control" name="price_sale" id="price_sale">

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

        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Return</a>
    </form>
@endsection
