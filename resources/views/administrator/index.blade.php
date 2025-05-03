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
    <form method="GET" action="{{ route('admindashboard') }}" class="row g-2">
        <div class="col-md-3">
            <label for="roleFilter" class="form-label">Filter by role:</label>
            <select name="role" id="roleFilter" class="form-select">
                <option value="">All</option>
                <option value="Administrator" {{ request('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                <option value="Admission" {{ request('role') == 'Admission' ? 'selected' : '' }}>Admission</option>
                <option value="Accounting" {{ request('role') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                <option value="Applicant" {{ request('role') == 'Applicant' ? 'selected' : '' }}>Applicant</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="search" class="form-label">Search by name or email:</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Enter keyword...">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-secondary w-100">Apply</button>
        </div>
    </form>
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
            <tbody>
    @forelse($applicants as $level => $group)
        <tr class="table-primary">
            <td colspan="5" class="fw-bold text-center">{{ strtoupper($level) }}</td>
        </tr>

        @foreach($group as $applicant)
        <tr>
            <td>{{ $applicant->applicant_name }}</td>
            <td>{{ $applicant->applicant_contact_number }}</td>
            <td>{{ $applicant->incoming_grade_level }}</td>
            <td>{{ \Carbon\Carbon::parse($applicant->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($applicant->end_time)->format('h:i A') }}</td>
            <td class="text-center">
                <form method="POST" action="{{ route('exam.attendance.mark') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $applicant->id }}">
                    <button type="submit" name="status" value="done" class="btn btn-success btn-sm">Done</button>
                    <button type="submit" name="status" value="no_show" class="btn btn-danger btn-sm">No Show</button>
                </form>
            </td>
        </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No applicants scheduled for this day.</td>
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
