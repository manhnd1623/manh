@extends('layouts.master')

@section('content')
    <h1>Danh sách Product</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add</a>

    @if (\Session::has('msg'))
        <div class="alert alert-success">
            {{ \Session::get('msg') }}
        </div>
    @endif

    <table class="table" enctype="multipart/form-data">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Price</td>
            <td>Price Sale</td>
            <td>Img</td>
            <td>Describe</td>
            <td>Category</td>
            <td>Action</td>
        </tr>

        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->price_sale }}</td>
                <td>
                    <img src="{{ \Storage::url($item->img) }}" width="50px" alt="">
                </td>
                <td>{{ $item->describe }}</td>
                <td>{{ $item->category->id . ' - ' . $item->category->name }}</td>
                <td>
                    <a href="{{ route('products.edit', $item) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('products.destroy', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Có chắc chắn xóa không?')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $data->links() }}
@endsection
