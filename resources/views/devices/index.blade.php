@extends('layouts.master')

@section('content')
    <h1>Danh sách Device</h1>
    <a href="{{ route('devices.create') }}" class="btn btn-primary">Add</a>

    @if (\Session::has('msg'))
        <div class="alert alert-success">
            {{ \Session::get('msg') }}
        </div>
    @endif

    <table class="table" enctype="multipart/form-data">
        <tr>
            <td>ID</td>
            <td>Category</td>
            <td>Name</td>
            <td>Serial</td>
            <td>Model</td>
            <td>Img</td>
            <td>Status</td>
            <td>Describe</td>
            <td>Action</td>
        </tr>

        @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->category->id . ' - ' . $item->category->name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->serial }}</td>
            <td>{{ $item->model }}</td>
            <td>
                <img src="{{ \Storage::url($item->img) }}" width="50px" alt="">
            </td>
            <td>{{ $item->is_active ? 'Active' : 'Inactive' }}</td>
            <td>{{ $item->describe }}</td>
            <td>
                <a href="{{ route('devices.edit', $item) }}" class="btn btn-info">Edit</a>
                <form action="{{ route('devices.destroy', $item) }}" method="POST">
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
