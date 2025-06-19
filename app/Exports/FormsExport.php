<?php

namespace App\Exports;

use App\Models\FillupForms;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormsExport implements FromCollection, WithMapping, WithHeadings
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data ?? FillupForms::with(['payment', 'schedule', 'examResult'])->get();
    }

    public function map($form): array
    {
        return [
            // Applicant Info
            trim("{$form->applicant_fname} {$form->applicant_mname} {$form->applicant_lname}"),
            $form->applicant_contact_number,
            $form->applicant_email,
            $form->age,
            $form->gender,
            $form->nationality,
            $form->applicant_bday,
            $form->lrn_no,

            // Joined Address
            "{$form->numstreet}, {$form->barangay}, {$form->city}, {$form->province}, {$form->region} {$form->postal_code}",

            // Guardian Info
            trim("{$form->guardian_fname} {$form->guardian_mname} {$form->guardian_lname}"),
            $form->guardian_contact_number,
            $form->guardian_email,
            $form->relation,

            // School Info
            $form->current_school,
            $form->current_school_city,
            $form->school_type,
            $form->educational_level,
            $form->incoming_grlvl,
            $form->strand,

            // Source
            $form->source,

            // Payment
            $form->payment->ocr_number ?? '—',

            // Schedule
            $form->schedule->admission_number ?? '—',
            $form->schedule->exam_date ?? '—',
            $form->schedule->start_time ?? '—',
            $form->schedule->end_time ?? '—',
            $form->schedule->venue ?? '-',
            optional($form->examResult)->exam_status ?? '—',
            optional($form->examResult)->exam_result ?? '—',

        ];
    }


    public function headings(): array
    {
        return [
            'Applicant Full Name',
            'Applicant Contact Number',
            'Applicant Email',
            'Age',
            'Gender',
            'Nationality',
            'Birthday',
            'LRN Number',
            'Address',
            'Guardian Full Name',
            'Guardian Contact Number',
            'Guardian Email',
            'Relation to Applicant',
            'Current School',
            'School City',
            'School Type',
            'Educational Level',
            'Incoming Grade Level',
            'Strand',
            'Source of Application',
            'OCR Number',
            'Admission Number',
            'Exam Date',
            'Start Time',
            'End Time',
            'Venue',
            'Exam Status',
            'Exam Result',
        ];
    }

}
