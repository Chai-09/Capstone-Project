@if ($errors->any())
    <div class="alert-box">
        @foreach ($errors->all() as $error)
            <p><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</p>
        @endforeach
    </div>
@endif
