@extends('layouts.app')

@section('title', 'Manage User')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-3">Manage User</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editRoleModal" data-id="{{ $user->id }}"
                                        data-role="{{ $user->role }}">Edit Role</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editRoleForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role">
                                <option value="teknisi">teknisi</option>
                                <option value="operasional">operasional</option>
                                <option value="pimpinan">pimpinan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editRoleModal');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                const role = button.getAttribute('data-role');

                document.getElementById('userId').value = userId;
                document.getElementById('role').value = role;
            });

            document.getElementById('editRoleForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const userId = document.getElementById('userId').value;
                const role = document.getElementById('role').value;

                fetch(`/manage-user/${userId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            role
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
