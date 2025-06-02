@extends('administrator.index')

@section('content')

<div class="dashboard">
    <div class="content">
        <h2 class="text-white mb-4 fw-semibold">Account List</h2>
    </div>
</div>


<div class="table-design">

    @if (session('success'))
        <script>
            window.flashSuccess = @json(session('success'));
        </script>
    @endif
    
    <!-- Filters -->
    <form method="GET" action="{{ route('admindashboard') }}" class="row g-2">
        <div class="filter-bar" style="gap: 10px;">
            <div class="dropdown">
                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Add filter
                </button>
                <div class="dropdown-menu p-3" style="min-width: 300px;">
                    <div class="mb-3">
                        <label for="roleFilter" class="form-label">Filter by role:</label>
                        <select name="role" id="roleFilter" class="form-select">
                            <option value="">All</option>
                            <option value="Administrator" {{ request('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="Admission" {{ request('role') == 'Admission' ? 'selected' : '' }}>Admission</option>
                            <option value="Accounting" {{ request('role') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                            <option value="Applicant" {{ request('role') == 'Applicant' ? 'selected' : '' }}>Applicant</option>
                        </select>
                    </div>
                </div>
            </div>
                
            <div class="search-wrapper">
                <input type="text" name="search" class="search-input" placeholder="Search for an applicant by name or email" value="{{ request('search') }}">
                <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
            </div>
            <button type="submit" class="btn btn-search">Search</button>

            <a href="{{ route('admin.createaccounts') }}" class="btn btn-secondary ms-auto">
                Add
            </a>
        </div>
    </form>
            
            <!-- Accounts Table -->
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th> 
                            <th style="width: 30%; position: relative;">
                                <div class="dropdown" style="position: relative;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Account Name</span>
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                                type="button"
                                                id="sortNameDropDown"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                                style="line-height: 1;">
                                            <i class="bi bi-funnel"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li class="dropdown-header fw-semibold">Sort by Name</li>
                                                <li> <a class="dropdown-item {{ request('sort') === 'name' && request('direction') === 'asc' ? 'active' : '' }}"
                                                        href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => 'asc']) }}">
                                                        A to Z
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request('sort') === 'name' && request('direction') === 'desc' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => 'desc']) }}">
                                                    Z to A
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                 <li class="dropdown-header fw-semibold">Sort by Created Date</li>
                                                <li>
                                                    <a class="dropdown-item {{ request('sort') === 'created_at' && request('direction') === 'asc' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'asc']) }}">
                                                    Oldest First
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item {{ !request('sort') ? 'active' : '' }}"
                                                    href="{{ request()->url() }}">
                                                    Default (Latest)
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>  
                                </div>
                            </th>
                            <th style="width: 30%;">Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->email }}</td>
                                <td>{{ ucfirst($account->role) }}</td>
                                <td class="text-center">
                                    <!-- Example: Edit/Delete Buttons (optional) -->
                                    <!-- Icon-only Edit -->
                                    <a href="{{ route('admin.editAccount', $account->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil-square text-white"></i>
                                    </a>

                                    <!-- Icon-only Delete -->
                                    <form method="POST" action="{{ route('admin.deleteAccount', $account->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this account?')" title="Delete">
                                            <i class="bi bi-trash text-white"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $accounts->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif

<script>
    document.getElementById('roleFilter').addEventListener('change', function () {
        const selectedRole = this.value;
        const query = selectedRole ? '?role=' + encodeURIComponent(selectedRole) : '';
        window.location.href = "{{ route('admindashboard') }}" + query;
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>