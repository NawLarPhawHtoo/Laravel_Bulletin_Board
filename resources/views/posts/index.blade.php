@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-end">
            <form action="{{ request()->is('posts/my-posts*') ? route('posts.my-posts') : route('posts.search') }}"
                method="GET" class="btn-group">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search for..."
                        value="{{ request('search') }}" />
                    <button class="btn cmn-btn" type="submit">Search</button>
                    @if (request()->has('search'))
                        <a href="{{ route('posts.search') }}" class="btn btn-danger ms-3">Cancel</a>
                    @endif
                </div>
            </form>

            <div class="d-flex justify-content-end">
                <div class="mt-3 mt-md-0 ms-md-3">
                    <a href="{{ route('posts.confirm-create') }}" class="btn cmn-btn">Create</a>
                </div>

                <div class="mt-3 mt-md-0 ms-md-3">
                    <a href="{{ route('posts.upload') }}" class="btn cmn-btn">Upload</a>
                </div>

                <div class="mt-3 mt-md-0 ms-md-3">
                    <a href="{{ route('posts.export', ['search' => request('search')]) }}" class="btn cmn-btn">Download</a>
                </div>
            </div>
        </div>

        @if (count($posts))
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4" style="margin-top: 50px;">
                        <div class="blog_post">
                            <div class="img_pod">
                                <img class="user-img" src="{{ asset('profiles/' . $post->user->profile) }}"
                                    alt="Profile Image">
                            </div>
                            <div class="container_copy">
                                <h3 class="name">By <b>{{ $post->user->name }}</b>,
                                    {{ $post->created_at->diffForHumans() }},
                                    {{ $post->status == 1 ? 'Active' : 'Inactive' }}</h3>

                                <h1 class="title">{{ Illuminate\Support\Str::limit($post->title, 15) }}</h1>
                                <p class="description">{{ Illuminate\Support\Str::limit($post->description, 25) }}</p>
                                <a class="btn_primary" data-bs-toggle="modal" aria-disabled="true"
                                    data-bs-target="#detailModal_{{ $post->id }}">View Detail &raquo;</a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal_{{ $post->id }}" data-backdrop="static" tabindex="-1"
                        role="dialog" aria-labelledby="detailPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailPostModalLabel">Detail Post </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-4">
                                        <div class="row mb-3">
                                            <label for="id" class="col-form-label col-md-4">ID:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $post->id }}"
                                                    id="id" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="title" class="col-form-label col-md-4">Title:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $post->title }}"
                                                    id="title" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="description" class="col-form-label col-md-4">Description:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="status" class="col-form-label col-md-4">Status:</label>
                                            <div class="col-md-6">
                                                @if ($post->status === 1)
                                                    <input type="text" class="form-control" id="status" value="Active"
                                                        disabled>
                                                @else
                                                    <input type="text" class="form-control" id="status"
                                                        value="Inactive" disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="created_at" class="col-form-label col-md-4">Created
                                                Date:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->created_at->format('d/m/Y') }}" id="created_at"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="created_user_id" class="col-form-label col-md-4">Created
                                                User:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->user->name }}" id="created_user_id" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="updated_at" class="col-form-label col-md-4">Updated
                                                Date:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->updated_at->format('d/m/Y') }}" id="updated_at"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="updated_user_id" class="col-form-label col-md-4">Updated
                                                User:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->user->name }}" id="updated_user_id" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    @if (auth()->user()->id === $post->created_user_id || auth()->user()->type == 0)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn cmn-btn">Edit</a>
                                        <a data-bs-toggle="modal" class="btn btn-danger"
                                            data-bs-target="#deleteModal_{{ $post->id }}"
                                            data-action="{{ route('posts.destroy', $post->id) }}">Delete</a>
                                    @endif
                                    {{-- <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal_{{ $post->id }}" data-backdrop="static" tabindex="-1"
                        role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteUserModalLabel">Delete Post Confirm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <h5 class="text-start delete-confirm-text">Are you sure to delete this Post?</h5>
                                        <div class="mt-4">
                                            <div class="row mb-3">
                                                <label for="id" class="col-form-label col-md-4">ID:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->id }}" id="id" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="title" class="col-form-label col-md-4">Title:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->title }}" id="title" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="description"
                                                    class="col-form-label col-md-4">Description:</label>
                                                <div class="col-md-6">
                                                    <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="status" class="col-form-label col-md-4">Status:</label>
                                                <div class="col-md-6">
                                                    @if ($post->status == 1)
                                                        <input type="text" class="form-control" id="status"
                                                            value="Active" disabled>
                                                    @else
                                                        <input type="text" class="form-control" id="status"
                                                            value="Inactive" disabled>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-block no-data">
                <h5>No Data Found</h5>
            </div>
        @endif

        <div class="d-flex justify-content-between mt-3 mb-4">
            <form class="col-3" method="GET" action="{{ url()->current() }}">
                <div class="pagination d-flex align-items-center">
                    <label for="perPage" class="col-4">Items per Page: </label>
                    <select class="form-select" id="perPage" name="perPage" onchange="this.form.submit()">
                        <option value="6" {{ $posts->perPage() == 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ $posts->perPage() == 12 ? 'selected' : '' }}>12</option>
                        <option value="15" {{ $posts->perPage() == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $posts->perPage() == 20 ? 'selected' : '' }}>20</option>
                        <option value="25" {{ $posts->perPage() == 25 ? 'selected' : '' }}>25</option>
                    </select>
                </div>
                <div>
                    <p class="align-items-center">Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of total
                        {{ $posts->total() }} entries</p>
                </div>
            </form>
            <div class="">
                {{ $posts->appends(['perPage' => $posts->perPage()])->links() }}
            </div>
        </div>

        {{-- <div class="float-end mt-3 mb-4">
            {{ $posts->links() }}
        </div> --}}
    </div>
@endsection
