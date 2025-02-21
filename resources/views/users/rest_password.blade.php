@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mt-3 text-center">Reset Password</div>
                </div>
                <form method="POST" action="{{ route('update-password-user', Auth::user()->id) }}" style="padding:16px;">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- ส่วนที่ 1: ข้อมูลพื้นฐาน -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password: </label>
                            <input name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm-Password: </label>
                            <input name="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
