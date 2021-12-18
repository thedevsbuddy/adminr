<div class="py-3">
    <h3>General settings</h3>
    <hr>
    <form action="{{ route(config('app.route_prefix').'.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="app_name">App Name</label>
                    <input type="text" class="form-control @if($errors->has('app_name')) is-invalid @endif" name="app_name" id="app_name" placeholder="App name"
                           value="{{ old('app_name') ?? getSetting('app_name') }}" required>
                    @if($errors->has('app_name'))
                        <span class="text-danger">{{ $errors->first('app_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="app_tagline">App Tag Line</label>
                    <input type="text" class="form-control @if($errors->has('app_tagline')) is-invalid @endif" name="app_tagline" id="app_tagline"
                           placeholder="App Tag Line" value="{{ old('app_tagline') ?? getSetting('app_tagline') }}">
                    @if($errors->has('app_tagline'))
                        <span class="text-danger">{{ $errors->first('app_tagline') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="meta_title">App meta title</label>
                    <input type="text" class="form-control @if($errors->has('meta_title')) is-invalid @endif" name="meta_title" id="meta_title"
                           placeholder="App meta title" value="{{ old('meta_title') ?? getSetting('meta_title') }}">
                    @if($errors->has('meta_title'))
                        <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="meta_description">App meta description</label>
                    <textarea rows="4" class="form-control @if($errors->has('meta_description')) is-invalid @endif" name="meta_description" id="meta_description"
                              placeholder="App meta description" style="resize: none">{{ old('meta_description') ?? getSetting('meta_description') }}</textarea>
                    @if($errors->has('meta_description'))
                        <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="title_separator">Title Separator</label>
                    <select class="form-control select2 @if($errors->has('title_separator')) is-invalid @endif" name="title_separator" id="title_separator">
                        <option value="-">Hyphen (-)</option>
                        <option value="|">Pipe Sign (|)</option>
                        <option value="~">Tilda (~)</option>
                    </select>
                    @if($errors->has('title_separator'))
                        <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center py-3">
                    <x-circle-file-input
                            containerId="app_logo_input"
                            label="Change site logo"
                            data-target="#app_logo_input"
                            name="app_logo"
                            src="{{ asset(getSetting('app_logo')) }}"
                            id="app_logo"
                            accept=".png, .svg, .jpg, .jpeg, .webp"/>
                </div>

                <div class="text-center py-3">
                    <x-circle-file-input
                            containerId="app_favicon_input"
                            label="Change site favicon"
                            data-target="#app_favicon_input"
                            name="app_favicon"
                            src="{{ asset(getSetting('app_favicon')) }}"
                            id="app_favicon"
                            accept=".png, .ico, .jpg"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>