@extends('admin.layouts.master')

@section('content')
<div class="contents">
  <div class="demo2 mb-25 t-thead-bg">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Admin Users</h4>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card card-default card-md mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6>All Admins</h6>
              <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-default btn-squared">+ Add Admin</a>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead class="bg-light">
                  <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $i => $user)
                    <tr>
                      <td>{{ $users->firstItem() + $i }}</td>
                      <td>
                        @if($user->image)
                          <img src="{{ asset($user->image) }}" style="width:48px;height:48px;border-radius:6px;">
                        @else
                          <div style="width:48px;height:48px;background:#eee;border-radius:6px;"></div>
                        @endif
                      </td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Delete user?')">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center">No admins yet.</td></tr>
                  @endforelse
                </tbody>
              </table>

              {{ $users->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
