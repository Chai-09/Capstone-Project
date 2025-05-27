<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountingExport implements FromCollection, WithMapping, WithHeadings
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data ?? Payment::all();
    }

    public function map($form): array  {
        return [
            trim("{$form->applicant_fname} {$form->applicant_mname} {$form->applicant_lname}"),
            $form->ocr_number,
        ];        
    }

    public function headings(): array {
        return [
            'Applicant Name',
            'OR Number'
        ];
    }

    
}
