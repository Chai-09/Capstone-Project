<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;

class MobileStrandRecommenderController extends Controller
{
    public function submit(Request $request)
{
    $user = auth()->user();
    $applicant = Applicant::where('account_id', $user->id)->first();

    $answers = $request->all();

    $score = [
        'stem' => 0,
        'abm' => 0,
        'humss' => 0,
        'sports' => 0,
        'gas' => 0,
    ];

    // Main questions (1–20)
    for ($i = 1; $i <= 20; $i++) {
        $key = 'q' . $i;
        $value = strtolower($answers[$key] ?? '');

        switch ($value) {
            case 'stem':
                $score['stem'] += 3;
                break;
            case 'abm':
                $score['abm'] += 3;
                break;
            case 'humss':
                $score['humss'] += 3;
                break;
            case 'sports':
                $score['sports'] += 3;
                break;
            case 'gas':
            case 'gas1':
            case 'gas2':
                $score['gas'] += 3;
                break;
            case 'stem_abm':
                $score['stem'] += 3;
                $score['abm'] += 3;
                break;
            case 'other':
                $score['stem'] += 1;
                $score['abm'] += 1;
                $score['humss'] += 1;
                $score['sports'] += 1;
                $score['gas'] += 1;
                break;
        }
    }

    // Determine top strand
    arsort($score);
    $top = array_keys($score, max($score));
    $topStrand = strtoupper($top[0]);
    $finalStrand = $topStrand;

    // If subquestions missing
    if (in_array($topStrand, ['STEM', 'ABM']) && (!isset($answers['q21']) || !isset($answers['q22']))) {
        return response()->json([
            'recommended_strand' => $topStrand,
            'require_subquestions' => true,
        ]);
    }

    // Process subquestion influence
    if ($topStrand === 'STEM') {
        if (($answers['q21'] ?? '') === 'engineering' || ($answers['q22'] ?? '') === 'engineering') {
            $finalStrand = 'STEM Engineering';
        } elseif (($answers['q21'] ?? '') === 'health' || ($answers['q22'] ?? '') === 'health') {
            $finalStrand = 'STEM Health Allied';
        } elseif (($answers['q21'] ?? '') === 'it' || ($answers['q22'] ?? '') === 'it') {
            $finalStrand = 'STEM Information Technology';
        }
    }

    if ($topStrand === 'ABM') {
        if (($answers['q21'] ?? '') === 'accounting' || ($answers['q22'] ?? '') === 'accounting') {
            $finalStrand = 'ABM Accountancy';
        } elseif (($answers['q21'] ?? '') === 'management' || ($answers['q22'] ?? '') === 'management') {
            $finalStrand = 'ABM Business Management';
        }
    }

    // Avoid division by zero
    $totalScore = array_sum($score) ?: 1;

    $strandBreakdown = [];
    foreach ($score as $strand => $points) {
        $strandBreakdown[$strand] = round(($points / $totalScore) * 100, 2);
    }

    
     $percentage = $strandBreakdown[strtolower($topStrand)] ?? 0; 

     $description = $this->getStrandDescription($finalStrand);
     $strengthLevel = $this->getStrengthLevelDescription($percentage);

     $fullDescription = $description . ' ' . $strengthLevel;

    // Save to DB
    if ($applicant) {
        $applicant->strand_description = $fullDescription;
        $applicant->recommended_strand = $finalStrand;
        $applicant->strand_breakdown = json_encode($strandBreakdown);
        $applicant->save();
    }

    return response()->json([
        'recommended_strand' => $finalStrand,
        'strand_breakdown' => $strandBreakdown,
    ]);
}


    private function getStrandDescription($strand)
    {
        $descriptions = [
            'STEM Health Allied' => 'You are inclined towards health sciences you likely have a passion for biology, care for others, and interest in healthcare professions.',
            'STEM Engineering' => 'You show strength in logical reasoning, problem-solving, and an interest in how things work ideal for engineering and technical fields.',
            'STEM Information Technology' => 'You show strong analytical thinking and an interest in computers, software, and emerging technology.',
            'ABM Accountancy' => 'You have a keen eye for numbers, detail-oriented mindset, and interest in financial systems suited for accountancy and financial careers.',
            'ABM Business Management' => 'Your leadership, entrepreneurial mindset, and business acumen make you fit for management and entrepreneurship.',
            'HUMSS' => 'You have strong communication skills, empathy, and interest in humanities, social sciences, or community service.',
            'GAS' => 'You exhibit a wide range of interests and skills, making you versatile and adaptable ideal for general academic exploration.',
            'SPORTS' => 'Your energy, discipline, and competitive nature align with sports, physical education, and athletic development.',
        ];

        return $descriptions[$strand] ?? 'No description available for this strand.';
    }

    private function getStrengthLevelDescription($percentage)
    {
        return match (true) {
            $percentage >= 50 => 'This is a key strength for you. You show exceptional interest and aptitude in this area.',
            $percentage >= 40 => 'You have a strong inclination for this strand, making it a likely good fit.',
            $percentage >= 30 => 'You show potential in this area. With further exploration, this could suit you well.',
            $percentage >= 25 => 'You have moderate interest here, but may want to consider other options too.',
            default => 'This may not be your sole area of focus or interest, but could still be worth exploring further if you’re curious.',
        };
    }

    }

