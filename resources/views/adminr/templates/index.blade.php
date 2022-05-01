@extends('adminr.layouts.master')

@section('title', 'Mail Templates')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid" id="app">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">Manage mail templates</h3>
        <div>
            <a href="{{ route(config('app.route_prefix').'.templates.create') }}" class="btn btn-primary btn-sm d-none d-sm-inline-block">
                <svg class="c-icon mr-1">
                    <use xlink:href="{{ coreUiIcon('cil-plus') }}"></use>
                </svg>
                Add new template
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title m-0">All Templates</p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-responsive-sm table-striped m-0">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px">#</th>
                            <th>Subject</th>
                            <th>Purpose</th>
                            <th>Code</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($templates as $index => $template)
                            <tr>
                                <td class="text-center">{{++$index}}</td>
                                <td>{{ $template->subject }}</td>
                                <td>{{ $template->purpose }}</td>
                                <td>{{ $template->code }}</td>
                                <td>{{ strip_tags($template->content) }}</td>
                                <td style="min-width: 120px">
                                    <a href="{{ route(config('app.route_prefix').'.templates.edit', $template) }}" class="btn btn-sm btn-icon btn-primary mr-2" title="Edit">
                                        <svg class="h-3 w-3">
                                            <use xlink:href="{{ coreUiIcon('cil-pen') }}"></use>
                                        </svg>
                                    </a>
                                    <a href="#" data-form="user_{{ $template->id }}" class="btn btn-sm btn-icon btn-danger delete-item" title="Delete">
                                        <svg class="h-3 w-3">
                                            <use xlink:href="{{ coreUiIcon('cil-trash') }}"></use>
                                        </svg>
                                    </a>
                                    <form class="d-none" id="user_{{ $template->id }}" action="{{ route(config('app.route_prefix').'.templates.destroy', $template->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No Template yet!</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {!! $templates->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scopedJs')
@endpush
