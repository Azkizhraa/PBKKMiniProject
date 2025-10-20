@extends('layouts.app')

@section('content')
    <h1>Menu Items</h1>
    <a href="{{ route('menu-items.create') }}" class="btn btn-primary mb-3">Add New Menu Item</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menuItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->availability ? 'Available' : 'Not Available' }}</td>
                    <td>
                        <a href="{{ route('menu-items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('menu-items.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection