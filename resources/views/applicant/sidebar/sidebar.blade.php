{{-- @php
    $currentStep = $currentStep;
@endphp --}}


<div class="sidebar-nav-wrapper">
    <ul class="sidebar-nav nav-pills flex-column">
        <li class="nav-item {{-- {{ $currentStep > 1 ? 'completed' : '' }}  {{ $currentStep > 1 ? 'completed' : '' }} --}}">
            <span class="step-number">
                Step 1
            </span>
            <a href="{{ route('applicantdashboard') }}"
               class="nav-link load-view {{-- {{ $currentStep > 1 ? 'completed' : '' }}  {{ $currentStep > 1 ? 'completed' : '' }} --}}">
                <i class="fa-brands fa-wpforms"></i> Fill-Up Forms
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{-- {{ $currentStep > 2 ? 'completed' : '' }}  {{ $currentStep > 2 ? 'completed' : '' }} --}}">
            <span class="step-number">Step 2</span>
            <a href="{{ route('applicant.steps.payment.payment') }}
        " class="nav-link {{-- {{ $currentStep > 2 ? 'completed' : '' }}  {{ $currentStep > 2 ? 'completed' : '' }} --}}">
                <i class="fa-solid fa-money-bill-wave"></i> Send Payment
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{-- {{ $currentStep > 3 ? 'completed' : '' }}  {{ $currentStep > 3 ? 'completed' : '' }} --}}">
            <span class="step-number">Step 3</span>
            <a href="{{ route('payment.verification') }}
            " class="nav-link {{-- {{ $currentStep > 3 ? 'completed' : '' }}  {{ $currentStep > 3 ? 'completed' : '' }} --}}">
                <i class="fa-solid fa-check-to-slot"></i> Payment Verification
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{-- {{ $currentStep > 4 ? 'completed' : '' }}  {{ $currentStep > 4 ? 'completed' : '' }} --}}">
            <span class="step-number">Step 4</span>
            <a href="{{ route ('applicant.examdates') }}
            " class="nav-link {{-- {{ $currentStep > 4 ? 'completed' : '' }}  {{ $currentStep > 41 ? 'completed' : '' }} --}}">
                <i class="fa-solid fa-calendar-days"></i> Schedule entrance exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{-- {{ $currentStep > 5 ? 'completed' : '' }}  {{ $currentStep > 5 ? 'completed' : '' }} --}}">
            <span class="step-number">Step 5</span>
            <a href="{{ route ('reminders.view') }}" 
            class="nav-link {{-- {{ $currentStep > 5 ? 'completed' : '' }}  {{ $currentStep > 5 ? 'completed' : '' }} --}}">
                <i class="fa-solid fa-file-pen"></i> Take the exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{-- {{ $currentStep > 6 ? 'completed' : '' }}  {{ $currentStep > 6 ? 'completed' : '' }} --}}">
            <span class="step-number">Step 6</span>
            <a href="{{ route ('applicant.exam.result') }}" 
            class="nav-link {{-- {{ $currentStep > 6 ? 'completed' : '' }}  {{ $currentStep > 6 ? 'completed' : '' }} --}}">
                <i class="fa-solid fa-square-poll-vertical"></i> Results
            </a>
        </li>
        <div class="double-line pb-5">
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </ul>
</div>