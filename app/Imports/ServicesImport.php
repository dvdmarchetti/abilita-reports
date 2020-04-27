<?php

namespace App\Imports;

use App\Child;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ServicesImport extends CommonImport
{

    /**
     * The date fields that needs to be normalized
     *
     * @var array
     */
    protected $dates = [
        'data_di_nascita',
        'data_inizio_frequenza',
        'data_fine_frequenza',
    ];

    /**
     * The year fields that needs to be normalized.
     *
     * @var array
     */
    protected $years = [
        'data_presa_in_carico_servizio_anno',
        'fine_presa_in_carico_servizio_anno',
    ];

    /**
     * Set the parent Multisheet importer
     *
     * @param \Maatwebsite\Excel\Concerns\BilancioSocialeImport $spreadsheet
     * @return void
     */
    public function __construct($spreadsheet)
    {
        parent::__construct($spreadsheet, 'SERVIZIO');
    }

    /**
     * Define column validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_bambino' => 'exists:children,id',
            'rif_id_famiglia' => 'exists:families,id',
            'sesso' => 'in:M,F',
            'data_di_nascita' => 'date',

            'area_diagnosi' => 'required|in:DISABILITÀ INTELLETTIVA,DISABILITÀ NEUROMOTORIA,DISTURBO SPETTRO AUTISTICO,SINDROMI GENETICHE,ALTRE PATOLOGIE',
            'diagnosi_1' => 'required|string',
            'diagnosi_2' => 'nullable|string',
            'diagnosi_3' => 'nullable|string',

            'data_presa_in_carico_servizio_anno' => 'required|date',
            'fine_presa_in_carico_servizio_anno' => 'nullable|present|date',
            'motivo_fine_presa_in_carico' => 'nullable|in:DIMISSIONE,MOTIVI ECONOMICI,ALTRI MOTIVI,TRASFERIMENTO,VOLONTARIA',

            'data_inizio_frequenza' => 'required|date|before:today',
            'data_fine_frequenza' => 'nullable|date|before:today',
            'mesi_frequenza_servizio_anno_solare' => 'required|integer|min:0|max:12',
            'fonte_invio' => 'required|string|in:ATS,SERVIZI SOCIALI,SPONTANEA,UONPIA,CASE MANAGER,SCUOLA,SERVIZIO INTERNO ABILITÀ,ALTRO',
        ];
    }

    /**
     * Process excel rows.
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        return parent::collection(
            $rows->reject(function ($row) {
                return Str::contains($row['note_diagnosi'], 'NOTA::: figlio');
            })
        );
    }

    /**
     * Create a new child or attach a new service to him.
     *
     * @param \Illuminate\Support\Collection $row
     * @return void
     */
    protected function store($row)
    {
        $child = Child::firstOrNew([
            'id' => $row['id_bambino'],
            'gender' => $row['sesso'],
            'birth_date' => $row['data_di_nascita'],
            'family_id' => $row['rif_id_famiglia'],
        ]);

        $child->services()->attach($this->spreadsheet->getService(), [
            'diagnosis_area' => $row['area_diagnosi'],
            'diagnosis_count' => $this->countDiagnosis($row),
            // '' => $row['diagnosi_prevalente'],
            // '' => $row['diagnosi_2'],
            // '' => $row['diagnosi_3'],
            'first_appearance' => $row['data_presa_in_carico_servizio_anno'],
            'end_of_charge' => $row['fine_presa_in_carico_servizio_anno'],
            'end_reason' => $row['motivo_fine_presa_in_carico'],
            'from' => $row['data_inizio_frequenza'],
            'to' => $row['data_fine_frequenza'],
            'attendance_months' => $row['mesi_frequenza_servizio_anno_solare'],
            'source' => $row['fonte_invio'],
        ]);
    }

    /**
     * Get the max diagnosis count for the current service-child pair.
     *
     * @param array $row
     * @return integer
     */
    protected function countDiagnosis($row)
    {
        return $row->only(['diagnosi_1', 'diagnosi_2', 'diagnosi_3'])->reject(function ($diagnosi) {
            return empty($diagnosi);
        })->count();
    }
}
