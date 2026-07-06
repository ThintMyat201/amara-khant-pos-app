@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm" style="border: none; border-radius: 8px; overflow: hidden;">
                    <div class="card-header" style="background: var(--amara-primary, #0B5EA8); border: none; padding: 1.25rem;">
                        <h5 class="m-0 font-weight-bold text-white text-center">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile
                        </h5>
                    </div>
                    <form action="{{ route('profileEdit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class='text-center mb-2'>
                                    <img class="img-profile mb-1" id="output"
                                        src="{{ $oldData->image==null ?  asset('images/default.png') : asset('images/' . $oldData->image) }}" alt="Product Image"
                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--amara-primary, #0B5EA8);">
                                </div>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control mt-1 @error('image') is-invalid @enderror"
                                    onchange="loadFile(event)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Name</label>
                                <input type="text" name="name" value="{{ old('name', $oldData->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Name...">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Email</label>
                                <input type="text" name="email" value="{{ old('email', $oldData->email) }}"
                                    class="form-control"
                                    placeholder="Enter Email" readonly style="background-color: #f5f5f5;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $oldData->phone) }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Enter Number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Address</label>
                                <input type="text" name="address" value="{{ old('address', $oldData->address) }}"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter Address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

