@extends('admin.layouts.master')

@section('content')
<div class="contents">
  <div class="demo2 mb-25 t-thead-bg">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Edit Admin</h4>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="card card-default card-md mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6>Edit Admin</h6>
              <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-default btn-squared">Back to List</a>
            </div>

            <div class="card-body py-md-30">
              <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-6 mb-25">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>New Password (leave blank to keep)</label>
                    <input type="password" name="password" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Profile Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($user->image)
                      <img src="{{ asset('storage/'.$user->image) }}" alt="" style="width:80px;margin-top:8px;">
                    @endif
                  </div>

                 

                  <div class="col-md-12">
                    <div class="button-group d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>

                </div>
              </form>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
