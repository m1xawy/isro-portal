@extends('admin.layouts.app')
@section('title', __('Pages'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Pages</h1>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-outline-secondary">+ New Page</a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->title }}</td>
                            <td>
                                @if($value->active == 1)
                                    <span class="text-success">Active</span>
                                @elseif($value->active == 0)
                                    <span class="text-danger">Not Active</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $value->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="{{ route('admin.pages.delete', $value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Records Found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
