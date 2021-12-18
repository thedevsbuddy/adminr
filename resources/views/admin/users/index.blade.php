@extends('adminr.layouts.master')

@section('title', 'Users management')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid" id="app">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">Manage Users</h3>
        <div>
            <a href="{{ route(config('app.route_prefix').'.users.create') }}" class="btn btn-primary btn-sm d-none d-sm-inline-block">
                <svg class="c-icon mr-1">
                    <use xlink:href="{{ coreUiIcon('cil-user-plus') }}"></use>
                </svg>
                Add new user
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title m-0">All Users List</p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-responsive-sm table-striped m-0">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px">#</th>
                            <th class="text-center"></th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">{{++$index}}</td>
                                <td class="text-center">
                                    <img src="{{ asset($user->avatar) }}" class="lq-user-avatar rounded-circle" alt="">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <a href="{{ route(config('app.route_prefix').'.users.edit', $user) }}" class="btn btn-sm btn-icon btn-primary mr-2" title="Edit">
                                        <svg class="h-3 w-3">
                                            <use xlink:href="{{ coreUiIcon('cil-pen') }}"></use>
                                        </svg>
                                    </a>
                                    <a href="#" data-form="user_{{ $user->id }}" class="btn btn-sm btn-icon btn-danger delete-item" title="Delete">
                                        <svg class="h-3 w-3">
                                            <use xlink:href="{{ coreUiIcon('cil-trash') }}"></use>
                                        </svg>
                                    </a>
                                    <form class="d-none" id="user_{{ $user->id }}" action="{{ route(config('app.route_prefix').'.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No Resources generated yet!</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {!! $users->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scopedJs')
@endpush
