@extends('adminr::layouts.master')

@section('title', 'Edit article')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">Create new {{ ucfirst('article') }}</h3>
    </div>
    <div class="card">
        <form method="POST" action="{{ route( 'adminr.articles.update', $article->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header d-flex justify-content-between align-items-center">
                <p class="card-title m-0">Add new {{ ucfirst('article') }}</p>
                <a href="{{ route( 'adminr.articles.index') }}" class="btn btn-sm btn-primary m-0">
                     <svg class="h-3 w-3">
                         <use xlink:href="{{ adminrIcon('cil-list-rich') }}"></use>
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
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group has-feedback @if($errors->has('slug')) has-error @endif">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control @if($errors->has('slug')) is-invalid @endif" placeholder="Slug" value="{{ old('slug') ?: $article->slug }}" required />
                                    @if ($errors->has('slug'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

						</div>

                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
    <label>Featured Image</label>
    <label class="custom-file-button" style="--aspect-ratio: 5 / 2">
        <div class="custom-file-content">
            <span class="text-dark">
                <i class="fa fa-upload mr-2"></i>
                <span class="file-input-label">Select Featured Image</span>
            </span>
            <input name="featured_image" class="file-input" id="featured_image" type="file" accept="*/*"  />
        </div>
    </label>
    <div class="mt-3">
        {{ collect(explode('/', $article->featured_image))->last() }}
    </div>
</div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
               <button type="submit" class="btn btn-sm btn-primary m-0 d-flex align-items-center">
                    <x-aicon name="save" class="h-3 w-3 mr-2" />
                    <span>Save</span>
               </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scopedJs')
    
@endpush
