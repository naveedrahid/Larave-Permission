@extends('layouts.masterLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div
                    class="pageTitle bg-light shadow-sm py-3 px-3 rounded mb-5 d-flex align-items-center justify-content-between">
                    <p class="m-0"><strong>{{ __('Roles / Edit') }}</strong></p>
                    <a href="{{ route('roles.index') }}"
                        class="btn btn-primary bg-dark text-white border-0">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mainContentAres">
                    <form action="{{ route('roles.update', $role) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Permission name"
                                aria-describedby="helpId" value="{{ old('name', $role->name) }}" />
                            @error('name')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="checkBoxWrapper mb-3">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input 
                                        {{($hasPermissions->contains($permission->name)) ? 'checked': ''}}
                                        class="form-check-input permissionNumber-{{ $permission->id }}"
                                        type="checkbox" name="permission[]" 
                                        value="{{ $permission->name }}" />
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                <div>No Permission found!</div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary bg-dark text-white border-0">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
