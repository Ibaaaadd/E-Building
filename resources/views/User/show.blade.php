@extends('layouts.main')

@section('title', 'Detail Deleted User')

@section('contents')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-start">
                            <h2 class="text-dark fw-bold m-3">Restore User</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <form class="docs-search-form row gx-1 align-items-center" style="margin-top: 15px"
                                id="search-form">
                                <div class="col-auto">
                                    <input type="text" id="search-docs" class="form-control"
                                        style="border: 2px solid #435ebe; border-radius: 5px; height: calc(1.5em + .75rem + 2px);"
                                        placeholder="Search">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-secondary " id="search-button"
                                        style="height: calc(1.5em + .75rem + 5px); margin-left: 3px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.397l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zM2 6.5a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                            <script>
                                // Define the search function
                                function search() {
                                    let input = document.getElementById('search-docs').value.toLowerCase();
                                    let table = document.getElementById('tabel');
                                    let rows = table.getElementsByTagName('tr');

                                    for (let i = 1; i < rows.length; i++) { // Start at 1 to skip the header row
                                        let cells = rows[i].getElementsByTagName('td');
                                        let rowContainsQuery = false;

                                        for (let j = 0; j < cells.length; j++) {
                                            if (cells[j].innerText.toLowerCase().includes(input)) {
                                                rowContainsQuery = true;
                                                break;
                                            }
                                        }

                                        if (rowContainsQuery) {
                                            rows[i].style.display = '';
                                        } else {
                                            rows[i].style.display = 'none';
                                        }
                                    }
                                }

                                // Add event listeners
                                document.getElementById('search-button').addEventListener('click', function() {
                                    search();
                                });

                                document.getElementById('search-docs').addEventListener('keypress', function(e) {
                                    if (e.key === 'Enter') {
                                        e.preventDefault();
                                        search();
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabel" class="table table-striped table-hover table-bordered mt-3 mb-3">
                                <thead>
                                    <tr style="vertical-align: middle; justify-content: center;">
                                        <th class="text-center align-middle">Nama</th>
                                        <th class="text-center align-middle">Email</th>
                                        <th class="text-center align-middle">Peran</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $deletedUser)
                                        <tr class="text-center align-middle">
                                            <td>{{ $deletedUser->name }}</td>
                                            <td>{{ $deletedUser->email }}</td>
                                            <td>
                                                @switch($deletedUser->role_id)
                                                    @case(1)
                                                        Admin
                                                    @break

                                                    @case(2)
                                                        Pelapor
                                                    @break

                                                    @case(3)
                                                        Surveyor
                                                    @break

                                                    @case(4)
                                                        Kabid
                                                    @break

                                                    @default
                                                        Undefined
                                                @endswitch
                                            </td>
                                            <td>
                                                <form id="restoreForm{{ $deletedUser->id }}"
                                                    action="{{ route('user.restore', $deletedUser->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    <button type="button" class="btn btn-success delete-btn"
                                                        onclick="confirmRestore('{{ $deletedUser->id }}')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmRestore(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin mengembalikan data ini?',
            text: "Data yang dihapus akan dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restoreForm' + userId).submit();
            }
        });
    }
</script>
