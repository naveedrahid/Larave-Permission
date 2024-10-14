@extends('layouts.masterLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="pageTitle bg-light shadow-sm py-3 px-3 rounded mb-5 d-flex align-items-center justify-content-between">
                    <p class="m-0"><strong>{{ __('Permissions') }}</strong></p>
                    <a href="{{route('permissions.index')}}" class="btn btn-primary bg-dark text-white border-0">{{__('Back')}}</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mainContentAres">
                    <form action="{{ route('permissions.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Permission name"
                                aria-describedby="helpId" value="{{ old('name') }}" />
                            @error('name')
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
