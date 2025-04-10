<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
</head>
<body>
    <h2>Registered Accounts</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('login.store') }}">Register New Account</a>
</body>
</html>
