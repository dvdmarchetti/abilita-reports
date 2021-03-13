<?php

namespace App\Imports\Sheets;

use App\Child;
use App\Family;
use Psr\Log\LogLevel;

class ChildrenImport extends CommonImport
{

    /**
     * The date fields that needs to be normalized
     *
     * @var array
     */
    protected $dates = [
        'data_di_nascita'
    ];

    /**
     * Set the parent Multisheet importer
     *
     * @param \Maatwebsite\Excel\Concerns\BilancioSocialeImport $spreadsheet
     * @return void
     */
    public function __construct($spreadsheet)
    {
        parent::__construct($spreadsheet, 'ANAGRAFICA-B');
    }

    /**
     * Define column validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_bambino' => ['required'],
            'sesso' => ['in:M,F'],
            'data_di_nascita' => ['required', 'date'],

            'luogo_di_nascita_citta' => ['required', 'string'],
            'luogo_di_nascita_nazione' => ['required', 'string'],
            'nazionalita' => ['required'],

            'residenza_citta' => ['bail', 'same_insensitive:area_metropolitana'],
            'residenza_prov' => ['string', 'size:2'],
            'residenza_cap' => ['integer', 'min:10000', 'max:99999'],
            'municipio_milano' => ['nullable', function ($attribute, $value, $fail) {
                if ($value !== 'NO' && (!is_numeric($value) || ((int) $value) >= 10 || ((int) $value < 0))) {
                    $fail("The {$attribute} field must either be an integer number or 'NO' value.");
                }
            }],
        ];
    }

    /**
     * Create a new child or attach a new service to him.
     *
     * @param \Illuminate\Support\Collection $row
     * @return void
     */
    protected function store($row)
    {
        $family = Family::firstOrCreate([
            'id' => $row['rif_id_famiglia'],
        ]);

        $child = Child::firstOrCreate([
            'id' => $row['id_bambino'],
        ], [
            'gender' => $row['sesso'],
            'birth_date' => $row['data_di_nascita'],
            'family_id' => $family->id,

            'born_city' => $row['luogo_di_nascita_citta'],
            'born_state' => $row['luogo_di_nascita_nazione'],
            'nationality' => mb_convert_encoding($row['nazionalita'], 'utf-8'),

            'home_city' => $row['residenza_citta'],
            'home_district' => $row['residenza_prov'],
            'home_cap' => $row['residenza_cap'],
            'home_municipality' => $row['municipio_milano'],
            'home_metropolitan_area' => $row['area_metropolitana'],
        ]);

        if ($child->gender != $row['sesso'] || $child->birth_date != $row['data_di_nascita'] || $child->family_id != $family->id) {
            $this->fail([
                'level' => LogLevel::ALERT,
                'spreadsheet' => $this->name,
                'child' => $row['id_bambino'],
                'errors' => [
                    [
                        'message' => __('validation.different_existing'),
                        'existing' => $child,
                        'new' => Child::make([
                            'id' => $row['id_bambino'],
                            'gender' => $row['sesso'],
                            'birth_date' => $row['data_di_nascita'],
                            'family_id' => $family->id,

                            'born_city' => $row['luogo_di_nascita_citta'],
                            'born_state' => $row['luogo_di_nascita_nazione'],
                            'nationality' => mb_convert_encoding($row['nazionalita'], 'utf-8'),

                            'home_city' => $row['residenza_citta'],
                            'home_district' => $row['residenza_prov'],
                            'home_cap' => $row['residenza_cap'],
                            'home_municipality' => $row['municipio_milano'],
                            'home_metropolitan_area' => $row['area_metropolitana'],
                        ])
                    ],
                ],
            ], LogLevel::ALERT, 'Possible duplicate ID!');
        }
    }
}
