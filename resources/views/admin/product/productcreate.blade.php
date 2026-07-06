@extends('layouts.master')
@section('content')
     <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-8 offset-md-2 card p-3 shadow-sm rounded">

                            <form action="{{ route('productCreateData')}}" method="post" enctype="multipart/form-data">

                                @csrf
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class='text-center mb-2'>
                                            <img class="img-profile mb-1 w-25" id="output">
                                        </div>
                                        <input type="file" name="image" accept="image/*" class="form-control mt-1 @error('image') is-invalid @enderror " onchange="loadFile(event)">
                                         @error('image')
                                                <div class="invalid-feedback">{{$message}}</div>
                                         @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror "
                                                    placeholder="Enter Name...">
                                                @error('name')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <select name="category_id" id="" class="form-control @error('category_id')
                                                is-invalid
                                                @enderror" >
                                                    <option value="">Choose Category...</option>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                 <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" name="price" value="{{ old('price')}}" class="form-control @error('price') is-invalid @enderror "
                                                    placeholder="Enter Price">
                                                @error('price')
                                                 <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Stock</label>
                                                <input type="text" name="stock" value="{{old('stock')}}" class="form-control @error('stock') is-invalid @enderror "
                                                    placeholder="Enter Stock">
                                                 @error('stock')
                                                 <div class="invalid-feedback">{{$message}}</div>
                                                 @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" value="{{ old('description')}}" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Enter Description..."></textarea>
                                         @error('description')
                                         <div class="invalid-feedback">{{$message}}</div>
                                         @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input type="submit" value="Create Product"
                                            class=" btn btn-primary w-100 rounded shadow-sm">
                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
@endsection
