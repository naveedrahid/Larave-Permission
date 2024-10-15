@extends('layouts.masterLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div
                    class="pageTitle bg-light shadow-sm py-3 px-3 rounded mb-5 d-flex align-items-center justify-content-between">
                    <p class="m-0"><strong>{{ __('Articles / Create') }}</strong></p>
                    <a href="{{ route('articles.index') }}"
                        class="btn btn-primary bg-dark text-white border-0">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mainContentAres">
                    <form action="{{ route('articles.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter your title"
                                aria-describedby="helpId" value="{{ old('title') }}" />
                            @error('title')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="text" id="text" cols="20" rows="10" class="form-control" placeholder="Content">{{ old('text') }}</textarea>
                            @error('text')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" placeholder="Enter your author"
                                aria-describedby="helpId" value="{{ old('author') }}" />
                            @error('author')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary bg-dark text-white border-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
