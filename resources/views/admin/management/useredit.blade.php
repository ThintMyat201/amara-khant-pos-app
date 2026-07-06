@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-3 shadow-sm rounded">
                    <form action="{{ route('userEdit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $oldData->id }}" name='id'>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class='text-center mb-2'>
                                    <img class="img-profile mb-1 w-25" id="output"
                                        src="{{ $oldData->image==null ?  asset('images/default.png') : asset('images/' . $oldData->image) }}" alt="Product Image">
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
                                <label class="form-label">Email</label>
                                <input type="text" name="email" value="{{ old('email', $oldData->email) }}"
                                    class="form-control"
                                    placeholder="Enter Email" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $oldData->phone) }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Enter Number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" value="{{ old('address', $oldData->address) }}"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter Address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(Auth::user()->role == 'Admin')
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror">
                                    <option value="Admin" {{ old('role', $oldData->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="User" {{ old('role', $oldData->role) == 'User' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 rounded shadow-sm">Update
                                    User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
