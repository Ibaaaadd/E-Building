<!-- resources/views/user/index.blade.php -->

@extends('layouts.main')

@section('page-title', 'Kelola User')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Kelola User',
    'subtitle' => 'Manajemen akun pengguna sistem',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal"><i class="fas fa-user-plus me-1"></i>Buat Akun</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-users-cog me-2 text-primary"></i>Daftar User</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roles = [1=>'Admin',2=>'Pelapor',3=>'Surveyor',4=>'Kabid'];
                                    $roleColors = [1=>'danger',2=>'primary',3=>'success',4=>'warning'];
                                @endphp
                                <span class="badge bg-{{ $roleColors[$user->role_id] ?? 'secondary' }}">
                                    {{ $roles[$user->role_id] ?? 'Undefined' }}
                                </span>
                            </td>
                            <td class="actions-cell text-center">
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" id="formDeleteUser{{ $user->id }}" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $user->id }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create -->
<x-app-modal id="createUserModal" title="Buat Akun Baru" icon="fas fa-user-plus">
    <form method="POST" action="{{ route('user.create') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Alamat Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Kata Sandi</label>
            <div class="input-group">
                <input type="text" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                <button id="generatePasswordButton" class="btn btn-outline-secondary" type="button"><i class="fas fa-key"></i></button>
            </div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Peran</label>
            <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                <option value="">Pilih Peran</option>
                <option value="1">Admin</option>
                <option value="2">Pelapor</option>
                <option value="3">Surveyor</option>
                <option value="4">Kabid</option>
            </select>
            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buat Akun</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<!-- Modal Edit -->
@foreach ($users as $user)
<x-app-modal id="editUserModal-{{ $user->id }}" title="Edit User" icon="fas fa-user-edit">
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Alamat Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Peran</label>
            <select class="form-select" name="role_id" required>
                <option value="1" {{ $user->role_id==1?'selected':'' }}>Admin</option>
                <option value="2" {{ $user->role_id==2?'selected':'' }}>Pelapor</option>
                <option value="3" {{ $user->role_id==3?'selected':'' }}>Surveyor</option>
                <option value="4" {{ $user->role_id==4?'selected':'' }}>Kabid</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endforeach

<script>
function confirmDelete(userId) {
    Swal.fire({
        title: 'Hapus User?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDeleteUser' + userId).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const generateButton = document.getElementById('generatePasswordButton');
    if (generateButton) {
        generateButton.addEventListener('click', function() {
            const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += charset[Math.floor(Math.random() * charset.length)];
            }
            passwordInput.value = password;
        });
    }
});
</script>
@endsection
