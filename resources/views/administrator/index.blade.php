<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Administrator | Dashboard</title>
   @vite('resources/js/partials/sidebar.js')
   @vite('resources/css/partials/sidebar.css')
</head>
<body>

<div class ="d-flex">
    {{-- SIDEBAR --}}
    @include('partials.sidebar')
<div id="content" class="flex-grow-1 p-4">
    <div class="container mt-4">
        <h2>Accounts List</h2>
        <!-- Filter Dropdown -->
    
        <form action="{{ route('admin.createaccounts') }}" method="GET" class="ms-auto">
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
        <div class="mb-3">
            <label for="roleFilter" class="form-label">Filter by role:</label>
            <select id="roleFilter" class="form-select w-auto">
        <option value="">All</option>
        <option value="Administrator" {{ request('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
        <option value="Admission" {{ request('role') == 'Admission' ? 'selected' : '' }}>Admission</option>
        <option value="Accounting" {{ request('role') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
        <option value="Applicant" {{ request('role') == 'Applicant' ? 'selected' : '' }}>Applicant</option>
    </select>
    
        </div>
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th> 
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
    
                </tr>
            </thead>
            <tbody id="accounts-table">
                @forelse ($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ ucfirst($account->role) }}</td>
                        <td>
        <a href="{{ route('admin.editAccount', $account->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.deleteAccount', $account->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No accounts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
        {{ $accounts->links('pagination::bootstrap-5') }}
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


    

</body>
</html>
