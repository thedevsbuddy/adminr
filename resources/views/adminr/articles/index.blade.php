@extends('adminr.layouts.master')

@section('title', 'Manage articles')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">{{ ucfirst('articles management') }}</h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="card-title m-0">All {{ ucfirst('articles list') }}</p>

                    <div class="d-flex align-items-center">
                        
                        <a href="{{ route(config('app.route_prefix').'.articles.create') }}" class="btn btn-sm btn-primary m-0">
                             <svg class="h-3 w-3">
                                 <use xlink:href="{{ coreUiIcon('cil-plus') }}"></use>
                             </svg>
                             Add new
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-responsive-sm table-striped m-0">
                        <thead>
                            <tr>
                                <th>#</th>
								<th>Title</th>
								<th>Featured_image</th>
                                <th>Created At</th>
                                <th>Last Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $index => $article)
                                <tr>
                                    <td>{{++$index}}</td>
									<td>{{ $article->title }}</td>
									<td><img src='{{ asset($article->featured_image) }}'  class="img-thumb" alt='Featured Image' /></td>
                                    <td>{{ $article->created_at->format('jS M, Y') }}</td>
                                    <td>{{ $article->updated_at->format('jS M, Y') }}</td>
                                    <td>
                                        @if(request()->has('trashed') && request()->get('trashed') == "true")
                                            <a href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('article_restore_{{ $article->id }}').submit();" class="btn btn-sm mr-2 btn-icon btn-success" title="Restore">
                                                <svg class="h-3 w-3" style="transform: rotateY(180deg)">
                                                    <use xlink:href="{{ coreUiIcon('cil-reload') }}"></use>
                                                </svg>
                                            </a>
                                            <form class="d-none" id="article_restore_{{ $article->id }}" action="{{ route(config('app.route_prefix').'.articles.restore', $article->id) }}" method="POST">
                                                @csrf
                                            </form>
                                            <a href="#" data-form="article_forceDelete_{{ $article->id }}" class="btn btn-sm mr-2 btn-icon btn-danger delete-item" title="Delete permanently">
                                                <svg class="h-3 w-3">
                                                    <use xlink:href="{{ coreUiIcon('cil-trash') }}"></use>
                                                </svg>
                                            </a>
                                            <form class="d-none" id="article_forceDelete_{{ $article->id }}" action="{{ route(config('app.route_prefix').'.articles.force-destroy', $article->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <a href="{{ route(config('app.route_prefix').'.articles.edit', $article->id) }}" class="btn btn-sm mr-2 btn-icon btn-primary" title="Edit">
                                                <svg class="h-3 w-3">
                                                    <use xlink:href="{{ coreUiIcon('cil-pen') }}"></use>
                                                </svg>
                                            </a>
                                            <a href="#" data-form="article_{{ $article->id }}" class="btn btn-sm mr-2 btn-icon btn-danger delete-item" title="Delete">
                                                <svg class="h-3 w-3">
                                                    <use xlink:href="{{ coreUiIcon('cil-trash') }}"></use>
                                                </svg>
                                            </a>
                                            <form class="d-none" id="article_{{ $article->id }}" action="{{ route(config('app.route_prefix').'.articles.destroy', $article->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">No data available for Articles</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            {!! $articles->appends($_GET)->links() !!}
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