<?php

namespace App\Imports\Sheets;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithValidation;

class FamiliesImport implements ToModel, WithHeadingRow, WithPreCalculateFormulas, WithValidation
{
    /**
     * Define column validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        dd($this);
        return [
            'ID Bambino' => 'unique',

            // Above is alias for as it always validates in batches
            '*.1' => Rule::in(['patrick@maatwebsite.nl']),

            // Can also use callback validation rules
            '0' => function($attribute, $value, $onFailure) {
                if ($value !== 'Patrick Brouwers') {
                    $onFailure('Name is not Patrick Brouwers');
                }
            }
        ];
    }

    /**
     * Map row to model
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return Child::firstOrCreate([
            'id' => $row['ID Bambino'],
        ]);
    }
}
