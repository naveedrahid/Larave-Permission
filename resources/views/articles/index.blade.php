@extends('layouts.masterLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div
                    class="pageTitle bg-light shadow-sm py-3 px-3 rounded mb-5 d-flex align-items-center justify-content-between">
                    <p class="m-0"><strong>{{ __('Articles') }}</strong></p>
                    <a href="{{ route('articles.create') }}"
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
                                            <th width="20%">Title</th>
                                            <th width="10%">Date</th>
                                            <th width="30%">Content</th>
                                            <th width="10%">Author</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($articles as $article)
                                            <tr>
                                                <td>{{ $article->id }}</td>
                                                <td>{{ $article->title }}</td>
                                                <td>{{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}</td>
                                                <td>{{ $article->text }}</td>
                                                <td>{{ $article->author }}</td>
                                                <td>
                                                    <a href="javascript:void(0);" id="deleteArticle"
                                                        data-id="{{ $article->id }}"
                                                        class="btn btn-primary btn-sm bg-danger text-white border-0 me-3">{{ __('Delete') }}</a>
                                                    <a href="{{ route('articles.edit', $article->id) }}"
                                                        class="btn btn-primary btn-sm text-white border-0 bg-aqua">{{ __('Edit') }}</a>
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
                                    {{ $articles->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script>
            $(function() {
                $('#deleteArticle').click(function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');

                    if (confirm('Are you sure you want to delete?')) {
                        $.ajax({
                            url: "{{ route('articles.destroy', ':id') }}".replace(':id', id),
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
                                if (xhr.status === 403) {
                                    // Show a message for no permission
                                    alert('You do not have permission to delete this article.');
                                } else if (xhr.status === 404) {
                                    // Show a message for article not found
                                    alert('Article not found.');
                                } else {
                                    alert('An error occurred: ' + xhr.responseText);
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
