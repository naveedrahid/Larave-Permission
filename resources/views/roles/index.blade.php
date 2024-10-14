@extends('layouts.masterLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div
                    class="pageTitle bg-light shadow-sm py-3 px-3 rounded mb-5 d-flex align-items-center justify-content-between">
                    <p class="m-0"><strong>{{ __('Roles') }}</strong></p>
                    <a href="{{ route('roles.create') }}"
                        class="btn btn-primary bg-dark text-white border-0">{{ __('Create') }}</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="mainContentAres">
                        @if (Session::has('success'))
                            <div class="text-white bg-success bg-gradient shadow-lg py-2 px-3 rounded">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="text-white mdi-radius shadow-sm bg-danger py-2 px-3 rounded">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="dataWrapper">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%">#</th>
                                            <th width="30%">Name</th>
                                            <th width="30%">Permissions</th>
                                            <th width="15%">Created</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td class="d-flex flex-wrap">
                                                    @foreach ($role->permissions as $permission)
                                                        <p class="rounded py-1 px-2 bg-success text-white mb-1 me-2">
                                                            {{ ucfirst($permission->name) }}
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    {{-- <a href="javascript:void(0);" id="deletePermission"
                                                        data-id="{{ $permission->id }}"
                                                        class="btn btn-primary btn-sm bg-danger text-white border-0 me-3">{{ __('Delete') }}</a>
                                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                                        class="btn btn-primary btn-sm text-white border-0 bg-aqua">{{ __('Edit') }}</a> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">{{ __('No record found!') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $roles->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        {{-- <script>
            $(function() {
                $('#deletePermission').click(function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');

                    if (confirm('Are you sure you want to delete?')) {
                        $.ajax({
                            url: "{{ route('permissions.destroy') }}",
                            type: "delete",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            headers: {
                                'x-csrf-token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status) { 
                                    location.reload();
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred: ' + xhr.responseText);
                            }
                        });
                    }
                });
            });
        </script> --}}
    @endpush
