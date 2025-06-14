<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileProfileController extends Controller
{
    // MobileProfileController.php
    public function show(Request $request)
    {
        $user = $request->user();

        $applicant = $user->applicant()->with('formSubmission')->first();

        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'applicant' => $applicant,
            ],
            'form_data' => $applicant->formSubmission,
            'submitted' => $applicant->formSubmission !== null,
            'current_step' => $applicant->current_step
        ]);
    }
}
