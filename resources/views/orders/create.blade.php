@extends('layouts.app')

@section('content')
    <h1>Create New Order</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
            @error('customer_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="menu-items">
            <h3>Menu Items</h3>
            <div id="menu-item-container">
                <div class="menu-item-row mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Item</label>
                            <select name="menu_items[]" class="form-select" required>
                                <option value="">Select an item</option>
                                @foreach($menuItems as $item)
                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                        {{ $item->name }} - Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantities[]" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger d-block w-100 remove-item" style="display: none;">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" id="add-item">Add Another Item</button>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('menu-item-container');
            const addButton = document.getElementById('add-item');

            // Show/hide remove buttons
            function updateRemoveButtons() {
                const removeButtons = container.querySelectorAll('.remove-item');
                const rows = container.querySelectorAll('.menu-item-row');
                
                removeButtons.forEach((button, index) => {
                    if (rows.length > 1) {
                        button.style.display = 'block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            }

            // Add new item row
            addButton.addEventListener('click', function() {
                const newRow = container.querySelector('.menu-item-row').cloneNode(true);
                newRow.querySelector('select').value = '';
                newRow.querySelector('input[type="number"]').value = 1;
                container.appendChild(newRow);
                updateRemoveButtons();
            });

            // Remove item row
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('.menu-item-row').remove();
                    updateRemoveButtons();
                }
            });
        });
    </script>
    @endpush
@endsection