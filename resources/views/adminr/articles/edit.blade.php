@extends('adminr.layouts.master')

@section('title', 'Edit article')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">Create new {{ ucfirst('article') }}</h3>
    </div>
    <div class="card">
        <form method="POST" action="{{ route(config('app.route_prefix').'.articles.update', $article->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header d-flex justify-content-between align-items-center">
                <p class="card-title m-0">Add new {{ ucfirst('article') }}</p>
                <a href="{{ route(config('app.route_prefix').'.articles.index') }}" class="btn btn-sm btn-primary m-0">
                     <svg class="h-3 w-3">
                         <use xlink:href="{{ coreUiIcon('cil-list-rich') }}"></use>
                     </svg>
                     View all
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group has-feedback @if($errors->has('title')) has-error @endif">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control @if($errors->has('title')) is-invalid @endif" placeholder="Title" value="{{ old('title') ?: $article->title }}" required />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
						</div>

                    </div>
                    <div class="col-lg-4">
                        
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary m-0">
                     <svg class="h-3 w-3">
                         <use xlink:href="{{ coreUiIcon('cil-save') }}"></use>
                     </svg>
                     Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scopedJs')
    
@endpush