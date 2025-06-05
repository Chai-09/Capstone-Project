@php
    $currentStep = $currentStep;
    $incomingGrLvl = $applicant->incoming_grlvl ?? '';
    $isSeniorHigh = in_array($incomingGrLvl, ['GRADE 11', 'GRADE 12']);
    $existingPayment = $existingPayment ?? null;
@endphp

<div class="sidebar-nav-wrapper" id="sidebarWrapper">
    <ul class="sidebar-nav nav-pills flex-column">
        <li class="nav-item {{ $currentStep > 1 ? 'completed' : '' }}  {{ $currentStep == 1 ? 'active' : '' }}">
            <span class="step-number">
                Step 1
            </span>
            <a href="{{ route('applicantdashboard') }}"
               class="nav-link load-view {{ $currentStep > 1 ? 'completed' : '' }}  {{ $currentStep == 1 ? 'active' : '' }}">
                <i class="fa-brands fa-wpforms"></i> 
                Fill-Up Forms
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{ $currentStep > 2 ? 'completed' : '' }}  {{ $currentStep == 2 ? 'active' : '' }}">
            <span class="step-number">Step 2</span>
            @if ($existingPayment && $existingPayment->payment_status === 'denied' && $currentStep == 3)
        <form id="sidebarBackForm" method="POST" action="{{ route('payment.delete', ['id' => $existingPayment->id]) }}">
            @csrf
            @method('DELETE')
            <a href="#" class="nav-link {{ $currentStep == 2 ? 'active' : '' }}" onclick="event.preventDefault(); document.getElementById('sidebarBackForm').submit();">
                <i class="fa-solid fa-money-bill-wave"></i> Send Payment
            </a>
        </form>
    @else
        {{-- Normal redirect if not denied --}}
        <a href="{{ route('applicant.steps.payment.payment') }}"
           class="nav-link {{ $currentStep == 2 ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-wave"></i> Send Payment
        </a>
    @endif
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{ $currentStep > 3 ? 'completed' : '' }}  {{ $currentStep == 3 ? 'active' : '' }}">
            <span class="step-number">Step 3</span>
            <a href="{{ route('payment.verification') }}
            " class="nav-link {{ $currentStep > 3 ? 'completed' : '' }}  {{ $currentStep == 3 ? 'active' : '' }}">
                <i class="fa-solid fa-check-to-slot"></i> Payment Verification
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{ $currentStep > 4 ? 'completed' : '' }}  {{ $currentStep == 4 ? 'active' : '' }}">
            <span class="step-number">Step 4</span>
            <a href="{{ route ('applicant.examdates') }}
            " class="nav-link {{ $currentStep > 4 ? 'completed' : '' }}  {{ $currentStep == 4 ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i> Schedule entrance exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{ $currentStep > 5 ? 'completed' : '' }}  {{ $currentStep == 5 ? 'active' : '' }}">
            <span class="step-number">Step 5</span>
            <a href="{{ route ('reminders.view') }}" 
            class="nav-link {{ $currentStep > 5 ? 'completed' : '' }}  {{ $currentStep == 5 ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen"></i> Take the exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li class="nav-item {{ $currentStep > 6 ? 'completed' : '' }}  {{ $currentStep == 6 ? 'active' : '' }}">
            <span class="step-number">Step 6</span>
            <a href="{{ route ('applicant.exam.result') }}" 
            class="nav-link {{ $currentStep > 6 ? 'completed' : '' }}  {{ $currentStep == 6 ? 'active' : '' }}">
                <i class="fa-solid fa-square-poll-vertical"></i> Results
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
       
    @if ($isSeniorHigh && $currentStep == 1)
        <li class="nav-item pt-4">
            <a href="{{ route('strand.recommender') }}"  id="open-questionnaire" class="nav-link strand-link fw-semibold" style="white-space: normal; line-height: 1.3;">
                <i class="fa-solid fa-circle-question"></i>
                Need help choosing your strand?
            </a>
        </li>
    @endif

    @if ($isSeniorHigh && request()->routeIs('applicantdashboard') && !empty($applicant->strand_breakdown))
    <li class="nav-item">
        <a href="#scoreBreakdownModal" class="nav-link strand-link fw-semibold" data-bs-toggle="modal">
            <i class="fa-solid fa-chart-pie"></i>
            View Score Breakdown
        </a>
    </li>
@endif
    </ul>
</div>


