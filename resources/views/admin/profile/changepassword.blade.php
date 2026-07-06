@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm" style="border: none; border-radius: 8px; overflow: hidden;">
                    <div class="card-header" style="background: var(--amara-primary, #0B5EA8); border: none; padding: 1.25rem;">
                        <h5 class="m-0 font-weight-bold text-white text-center">
                            <i class="fa-solid fa-lock me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('changePassword')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Old Password</label>
                                <input type="password" name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror"
                                    placeholder="Enter Old Password...">
                                @error('oldPassword')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">New Password</label>
                                <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror"
                                    placeholder="Enter New Password...">
                                @error('newPassword')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control @error('confirmPassword') is-invalid @enderror"
                                    placeholder="Enter Confirm Password...">
                                @error('confirmPassword')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" value="Change Password" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
