@extends('applicant.index')

@section('content')
<div class="container recommender">
    <div class="question-form">
            <div class="form-row">
                <h2 class="fw-semibold text-center w-100">Strand Recommendation Questionnaire</h2>
                <p>
                    Hello! Please answer the following set of questions as best as you can to receive the most accurate results. However, please remember that the results you’ll receive are only recommended based on your answers and are not final. The course you’ll pick will still be based on your final decision.
                </p>
            </div>
        </div>
   

    <form method="POST" action="{{ route('strand.recommender.submit') }}">
        @csrf

        {{-- Questions Array --}}
        @php
            $questions = [
                1 => [
                    'label' => 'What subjects do you enjoy the most in school?',
                    'options' => [
                        'stem' => 'Math and Science Related',
                        'humss' => 'History and Literature Related',
                        'abm' => 'Business and Management Related',
                        'sports' => 'Physical Education or Sports Science',
                        'gas1' => 'I prefer a more general approach, tackling different disciplines',
                        'gas2' => 'I don’t have any preferences'
                    ]
                ],
                2 => [
                    'label' => 'What are you more interested in understanding?',
                    'options' => [
                        'stem' => 'How things work',
                        'humss' => 'How people think and behave',
                        'abm' => 'How businesses function and operate',
                        'sports' => 'Physical performance and health',
                        'gas' => 'I don’t have any preferences'
                    ]
                ],
                3 => [
                    'label' => 'Do you enjoy working with numbers and solving complex problems?',
                    'options' => [
                        'stem' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                4 => [
                    'label' => 'Do you have a passion for writing, reading, or expressing ideas through creative mediums?',
                    'options' => [
                        'humss' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                5 => [
                    'label' => 'Do you want to learn how businesses operate and function?',
                    'options' => [
                        'abm' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                6 => [
                    'label' => 'Are you interested in participating in physical activities or learning about sports science?',
                    'options' => [
                        'sports' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                7 => [
                    'label' => 'Are you comfortable analyzing scientific data, formulas, or performing calculations?',
                    'options' => [
                        'stem_abm' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                8 => [
                    'label' => 'Do you feel confident communicating effectively in speaking or writing?',
                    'options' => [
                        'humss' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                9 => [
                    'label' => 'Do you have experience managing businesses or operations?',
                    'options' => [
                        'abm' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                10 => [
                    'label' => 'Do you actively participate in physical or sports activities?',
                    'options' => [
                        'sports' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                11 => [
                    'label' => 'Do you excel at logical reasoning and critical thinking?',
                    'options' => [
                        'stem' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                12 => [
                    'label' => 'Are you skilled in empathizing with others and understanding perspectives?',
                    'options' => [
                        'humss' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                13 => [
                    'label' => 'Are you proficient with business-related tasks?',
                    'options' => [
                        'abm' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                14 => [
                    'label' => 'Do you have strengths in physical activities or teamwork?',
                    'options' => [
                        'sports' => 'Yes',
                        'other' => 'No'
                    ]
                ],
                15 => [
                    'label' => 'What kind of career do you envision for yourself?',
                    'options' => [
                        'stem' => 'Engineering, Medicine, or similar',
                        'humss' => 'Law, Teaching, Journalism',
                        'abm' => 'Business, Management, Entrepreneurship',
                        'sports' => 'Sports Science, Coaching',
                        'gas' => 'General/Undecided'
                    ]
                ],
                16 => [
                    'label' => 'Where do you see yourself making a contribution?',
                    'options' => [
                        'stem' => 'Technological advancements',
                        'humss' => 'Societal and cultural challenges',
                        'abm' => 'Business or entrepreneurship',
                        'sports' => 'Health and fitness or sports science',
                        'gas' => 'General academic or undecided'
                    ]
                ],
                17 => [
                    'label' => 'Preferred activity?',
                    'options' => [
                        'stem' => 'Hands-on experiments and building projects',
                        'humss' => 'Debates, discussions, brainstorming',
                        'abm' => 'Organizing, planning, business tasks',
                        'sports' => 'Physical training or sports',
                        'gas' => 'No preference, okay with anything'
                    ]
                ],
                18 => [
                    'label' => 'Where do you see yourself spending time?',
                    'options' => [
                        'stem' => 'Researching scientific phenomena',
                        'humss' => 'Analyzing history or society',
                        'abm' => 'Business solutions',
                        'sports' => 'Fitness, performance, health',
                        'gas' => 'Undecided/exploratory topics'
                    ]
                ],
                19 => [
                    'label' => 'How would you solve a challenge?',
                    'options' => [
                        'stem' => 'Design a technical solution',
                        'humss' => 'Craft a persuasive story or argument',
                        'abm' => 'Create a business plan',
                        'sports' => 'Address sports-related challenge',
                        'gas' => 'Explore general/flexible solutions'
                    ]
                ],
                20 => [
                    'label' => 'Your role in a group project?',
                    'options' => [
                        'stem' => 'Technical components',
                        'humss' => 'Presentation & interpersonal',
                        'abm' => 'Organizing/Managing',
                        'sports' => 'Physically-intensive roles',
                        'gas' => 'General responsibilities'
                    ]
                ]
            ];

            if (isset($topStrand) && strtoupper($topStrand) === 'STEM') {
                $questions[21] = [
                    'label' => 'If given a research project, would you prefer:',
                    'options' => [
                        'engineering' => 'Designing and building structures or systems',
                        'health' => 'Analyzing health-related data and medical advancements',
                        'it' => 'Developing software and technological solutions',
                    ],
                    'conditional' => 'stem'
                ];
                $questions[22] = [
                    'label' => 'In a problem-solving scenario, would you prefer:',
                    'options' => [
                        'engineering' => 'Designing and testing mechanical or structural solutions',
                        'health' => 'Researching medical innovations and treatments',
                        'it' => 'Developing software and coding programs',
                    ],
                    'conditional' => 'stem'
                ];
            }

            if (isset($topStrand) && strtoupper($topStrand) === 'ABM') {
                $questions[21] = [
                    'label' => 'In a business simulation, would you prefer:',
                    'options' => [
                        'accounting' => 'Handling financial records and accounting tasks',
                        'management' => 'Strategizing, planning, and managing operations',
                    ],
                    'conditional' => 'abm'
                ];
                $questions[22] = [
                    'label' => 'In a business competition, would you rather:',
                    'options' => [
                        'accounting' => 'Focus on financial planning and auditing',
                        'management' => 'Manage business operations and decision-making',
                    ],
                    'conditional' => 'abm'
                ];
            }
        @endphp

        @php
            $showOnlySubquestions = session('topStrand') === 'STEM' || session('topStrand') === 'ABM';
        @endphp

        @if ($showOnlySubquestions)
            <div class="alert alert-info fw-semibold">
                Please answer these additional questions to finalize your strand recommendation.
            </div>
        @endif

        <div class="question-form">
            <hr>
            @foreach ($questions as $number => $q)
                @php
                    $isSub = isset($q['conditional']);
                    $isVisible = !$showOnlySubquestions && !$isSub || ($showOnlySubquestions && $isSub && session('topStrand') === strtoupper($q['conditional']));
                @endphp

                @if ($isVisible)
                    <div class="form-row">
                        <div class="form-col w-100 mb-4 mt-4">
                            <label class="fw-semibold d-block">{{ $number }}. {{ $q['label'] }}</label>
                            @foreach ($q['options'] as $value => $label)
                                <div class="form-check mt-3">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="q{{ $number }}"
                                        id="q{{ $number }}_{{ $value }}"
                                        value="{{ $value }}"
                                        required>
                                    <label class="form-check-label" for="q{{ $number }}_{{ $value }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                @endif
            @endforeach
        </div>


        <div class="text-center mb-4">
            <button type="submit" class="btn btn-submit">Submit</button>
        </div>
    </form>
</div>
@endsection
