@extends('layouts.master')

@section('content')
    <h1>Danh sách Car</h1>
    <a href="{{ route('cars.create') }}" class="btn btn-primary">Add</a>

    @if (\Session::has('msg'))
        <div class="alert alert-success">
            {{ \Session::get('msg') }}
        </div>
    @endif

    <table class="table" enctype="multipart/form-data">
        <tr>
            <td>ID</td>
            <td>CategoryId</td>
            <td>Name</td>
            <td>Brand</td>
            <td>Image</td>
            <td>Describe</td>
            <td>Action</td>
        </tr>

        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->category->id . ' - ' . $item->category->name}}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->brand }}</td>
                <td>
                    <img src="{{ \Storage::url($item->img) }}" width="50px" alt="">
                </td>
                <td>{{ $item->describe }}</td>
                <td>
                    <a href="{{ route('cars.edit', $item) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('cars.destroy', $item) }}" method="POST">
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
