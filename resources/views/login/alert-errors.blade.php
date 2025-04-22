@if ($errors->any())
    <div class="alert-box">
        <div class="alert-content">
            <span class="alert-message">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ $errors->first() }} 
            </span>
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="alert-box">
        <div class="alert-content">
            <span class="alert-message">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
            </span>
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    </div>
@endif
