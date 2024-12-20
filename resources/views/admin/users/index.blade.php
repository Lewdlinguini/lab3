@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Users</h1>

        @if(session('success'))
            <div id="flash-message" class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-center align-items-start mb-3">
            <!-- Create New User Button with Icon -->
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary flex-fill text-center mx-2">
                <i class="bi bi-person-plus"></i> Create New User
            </a>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <!-- Edit Button with Icon -->
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm mx-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <!-- Delete Button with Icon -->
                            <button type="button" class="btn btn-danger btn-sm mx-2" onclick="showDeleteModal('{{ route('users.destroy', $user->id) }}', '{{ $user->name }}')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the user <strong id="userName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection
