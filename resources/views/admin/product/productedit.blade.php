@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-3 shadow-sm rounded">
                    <form action="{{ route('productEdit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $oldData->id }}" name='id'>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="product-preview-container mb-2">
                                    <img class="product-preview-image" id="output"
                                        src="{{ $oldData->image ? asset('images/' . $oldData->image) : asset('images/default.png') }}" alt="Product Image Preview">
                                </div>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control mt-1 @error('image') is-invalid @enderror"
                                    onchange="loadFile(event)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name', $oldData->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Name...">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <select name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('category_id', $oldData->category_id) == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" value="{{ old('price', $oldData->price) }}"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="Enter Price">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" value="{{ old('stock', $oldData->stock) }}"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    placeholder="Enter Stock">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" cols="30" rows="5"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter Description">{{ old('description', $oldData->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 rounded shadow-sm">Update
                                    Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

