@extends('adminr.layouts.master')

@section('title', 'Roles and permissions management')

@push('scopedCss')

@endpush

@section('content')
	<div class="container-fluid" id="app">
		<div class="d-sm-flex justify-content-between align-items-center mb-3">
			<h3 class="text-dark mb-0">Manage Roles and permissions</h3>
			<div class="d-flex align-items-center">
				<a href="javascript:void(0)" data-toggle="modal" data-target="#addNewRoleModal"
				   class="btn btn-primary btn-sm d-none d-sm-inline-block mr-3">
                    <x-cicon name="plus" class="c-icon mr-1" />
					Add new role
				</a>
				<a href="javascript:void(0)" data-toggle="modal" data-target="#addNewPermissionModal"
				   class="btn btn-primary btn-sm d-none d-sm-inline-block">
                    <x-cicon name="plus" class="c-icon mr-1" />
					Add new permission
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				@if($errors->any())
					{!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
				@endif
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<p class="card-title m-0">All roles and permissions List</p>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-bordered table-responsive-sm table-striped m-0">
								<thead>
								<tr>
									<th style="width: 50px">Permissions</th>
									@foreach($roles as $role)
										<th class="text-center">{{ \Illuminate\Support\Str::title(\Illuminate\Support\Str::replace('_', ' ', $role->name)) }}</th>
									@endforeach
								</tr>
								</thead>
								<tbody>
								@forelse($permissions as $index => $permission)
									<tr>
										<td>{{ $permission->name }}</td>
										@foreach($roles as $i => $role)
											@if($role->name == 'developer' || $role->name == 'super_admin')
												<td class="text-center">
													<span class="badge badge-success">
                                                        All permissions allowed
                                                    </span>
												</td>
											@else
												<td class="text-center">
													<div class="form-group mb-0 mx-auto d-flex align-items-center">
														<div class="custom-control text-center mx-auto custom-switch ml-3"
														     style="margin-top: -8px;">
															<input type="checkbox"
															       class="custom-control-input rpi"
															       id="{{ $role->name . $permission->id }}"
															       value="{{$role->id}}||{{$permission->id}}"
															       @if($role->hasPermissionTo($permission->id)) checked @endif>
															<label class="custom-control-label initial"
															       for="{{ $role->name . $permission->id }}"></label>
														</div>
													</div>
												</td>
											@endif
										@endforeach
									</tr>
								@empty
									<tr>
										<td colspan="{{ count($roles) + 3  }}" class="text-center">
											No Users yet!
										</td>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Role Modal -->
	<div class="modal fade" id="addNewRoleModal" data-backdrop="static" data-keyboard="false" aria-labelledby="addNewRoleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="{{ route(config('app.route_prefix').'.roles-and-permissions.storeRole') }}" method="POST">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="addNewRoleModalLabel">Create new role</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="role_name">Role Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" id="role_name" placeholder="Enter new role" required autofocus>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-sm btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add New Permission Modal -->
	<div class="modal fade" id="addNewPermissionModal" data-backdrop="static" data-keyboard="false" aria-labelledby="addNewPermissionModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="{{ route(config('app.route_prefix').'.roles-and-permissions.storePermission') }}" method="POST">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="addNewPermissionModalLabel">Create new permission</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="permission_name">Permission Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" id="permission_name" placeholder="Enter new permission" required autofocus>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-sm btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scopedJs')
	<script>
        $(document).on('change', '.rpi', function (e) {
            var $this = $(this);
            var val = $this.val();
            var roleId = val.split('||')[0];
            var permissionId = val.split('||')[1];
            if ($this.is(':checked')) {
                $.ajax({
                    url: "{{ route(config('app.route_prefix').'.roles-and-permissions.assign') }}",
                    method: "POST",
                    data: {"role_id": roleId, "permission_id": permissionId},
                    success: function (res) {
                        toastr.success(res.message);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route(config('app.route_prefix').'.roles-and-permissions.revoke') }}",
                    method: "POST",
                    data: {"role_id": roleId, "permission_id": permissionId},
                    success: function (res) {
                        toastr.success(res.message);
                    }
                });
            }
        });
        $(document).on('input', '#role_name', function (e){
            var val = $(this).val();
            $(this).val(val.split(/[\s|\-\.\d_*@#$%^&()!~`/\\,+=]/).map((t) => t ? t[0].toLowerCase() + t.slice(1) : '').join('_').trim())
        });
	</script>
@endpush
