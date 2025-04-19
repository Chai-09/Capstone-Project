@if ($errors->any())
    <div class="alert-box">
        <div class="alert-content">
            @foreach ($errors->all() as $error)
                <span class="alert-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
            @endforeach
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="alert-box">
        <div class="alert-content">
            <div class="alert-message">
                <span class="alert-message"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</span>
            </div>
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    </div>
@endif
