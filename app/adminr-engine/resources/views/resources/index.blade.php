@extends('adminr.layouts.master')

@section('title', __('Manage Resources'))

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid" id="app">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">{{ __('Manage Resources') }}</h3>
        <div>
            <a href="{{ route(config('adminr.route_prefix').'.builder') }}" class="btn btn-primary btn-sm d-none d-sm-inline-block">
                <svg class="c-icon mr-1">
                    <use xlink:href="{{ coreUiIcon('cil-library-add') }}"></use>
                </svg>
                {{ __('Add new resource') }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title m-0">{{ __('All Resources List') }}</p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-responsive-sm table-striped m-0">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px">#</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Model') }}</th>
                            <th>{{ __('API') }}</th>
                            <th>{{ __('Menu') }}</th>
                            <th>{{ __('Generated') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($resources as $index => $resource)
                            <tr>
                                <td class="text-center">{{++$index}}</td>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->model }}</td>
                                <td>{{ $resource->payload->has_api ? 'Yes' : 'No' }}</td>
                                <td>{{ $resource->menu->label }}</td>
                                <td>
                                    @if($resource->created_at->isToday())
                                        {{ $resource->created_at->diffForHumans() }}
                                    @elseif($resource->created_at->isYesterday())
                                        Yesterday at {{ $resource->created_at->format('h:i A') }}
                                    @else
                                        {{ $resource->created_at->format('jS M, Y') }}
                                    @endif
                                </td>
                                <td>
{{--                                    <a href="#" class="btn btn-sm btn-icon btn-primary" title="Edit">--}}
{{--                                        <svg class="h-3 w-3">--}}
{{--                                            <use xlink:href="{{ coreUiIcon('cil-pen') }}"></use>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
                                    <a href="{{ route(config('adminr.route_prefix').'.resources.configure', encrypt($resource->id)) }}" class="btn btn-sm mr-2 btn-icon btn-primary" title="Configure Permissions">
                                        <svg class="h-3 w-3">
                                            <use xlink:href="{{ coreUiIcon('cil-cog') }}"></use>
                                        </svg>
                                    </a>
{{--                                    <a href="#" data-form="resource_{{ $resource->id }}" class="btn btn-sm btn-icon btn-danger delete-item" title="Delete">--}}
{{--                                        <svg class="h-3 w-3">--}}
{{--                                            <use xlink:href="{{ coreUiIcon('cil-trash') }}"></use>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                    <form class="d-none" id="resource_{{ $resource->id }}" action="{{ route(config('adminr.route_prefix').'.resources.destroy', $resource->id) }}" method="POST">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                    </form>--}}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center">No Resources generated yet!</td></tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        {!! $resources->appends($_GET)->links() !!}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scopedJs')
@endpush
