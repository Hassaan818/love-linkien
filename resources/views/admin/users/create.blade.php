@extends('admin.layouts.master')

@section('content')
<div class="contents">
  <div class="demo2 mb-25 t-thead-bg">
    <div class="container-fluid">
      @include('admin.partials.success-messages')
      @include('admin.partials.validation-error-messages')
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Add Admin</h4>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="card card-default card-md mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6>Add Admin</h6>
              <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-default btn-squared">Back to List</a>
            </div>

            <div class="card-body py-md-30">
              <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="col-md-6 mb-25">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control">
                  </div>

                  <div class="col-md-6 mb-25">
                    <label>Profile Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>



                  <div class="col-md-12">
                    <div class="button-group d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Save</button>
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