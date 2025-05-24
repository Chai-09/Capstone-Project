<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart | Accounting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CSS --}}
    @vite('resources/css/partials/tables.css')
    @vite('resources/css/accounting/payment-modal.css')
    @vite('resources/css/partials/dashboard.css')

    {{-- JS --}}
    @vite('resources/js/accounting/payment.js')

</head>
<body>

    <div class="d-flex">
        {{-- SIDEBAR --}}
        @include('partials.sidebar')

        {{-- Main Content --}}
        <div class="container table-design" id="content" class="flex-grow-1 p-2">
            @yield('content')
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.uploadReceiptUrl = "{{ route('upload.receipt') }}";
    window.deleteReceiptUrl = "{{ route('delete.receipt') }}";
    window.csrfToken = "{{ csrf_token() }}";
  </script>
</html>