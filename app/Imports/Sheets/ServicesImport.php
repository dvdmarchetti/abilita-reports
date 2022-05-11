<?php

namespace App\Imports\Sheets;

use App\Child;
use Carbon\Carbon;
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
        'data_inizio_frequenza_servizio_iscrizione_annuale',
        'data_fine_frequenza_servizio_dimissione_annuale',
    ];

    /**
     * The year fields that needs to be normalized.
     *
     * @var array
     */
    protected $years = [
        'anno_inizio_presa_in_carico_dal_servizio', // 'data_presa_in_carico_servizio_anno',
        'anno_fine_presa_in_carico_dal_servizio', // 'fine_presa_in_carico_servizio_anno',
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

            'anno_inizio_presa_in_carico_dal_servizio' => 'required|date',
            'anno_fine_presa_in_carico_dal_servizio' => 'nullable|present|date',
            'motivo_fine_della_presa_in_carico' => 'nullable|in:DIMISSIONE,MOTIVI ECONOMICI,ALTRI MOTIVI,PROGETTO TEMPORANEO,TRASFERIMENTO,VOLONTARIA',

            'data_inizio_frequenza_servizio_iscrizione_annuale' => 'required|date|before:today',
            'data_fine_frequenza_servizio_dimissione_annuale' => 'nullable|date|before:today',
            'mesi_frequenza_servizio_nellanno_solare_precedente_calcolo_automatico' => 'required|integer|min:0|max:12',
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
                return $this->isInvalidYearForImport($row['anno_inizio_presa_in_carico_dal_servizio']);
            })->reject(function ($row) {
                return Str::contains($row['note_diagnosi'], 'NOTA::: figlio');
            })
        );
    }

    protected function isInvalidYearForImport($data)
    {
        return ! empty($data)
            && $data->notEqualTo(Carbon::createMidnightDate(9999, 1, 1))
            && $data->greaterThanOrEqualTo(Carbon::createMidnightDate(config('bs.year') + 1, 1, 1));
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
            'first_appearance' => $row['anno_inizio_presa_in_carico_dal_servizio'],
            'end_of_charge' => $row['anno_fine_presa_in_carico_dal_servizio'],
            'end_reason' => $row['motivo_fine_della_presa_in_carico'],
            'from' => $row['data_inizio_frequenza_servizio_iscrizione_annuale'],
            'to' => $row['data_fine_frequenza_servizio_dimissione_annuale'],
            'attendance_months' => $row['mesi_frequenza_servizio_nellanno_solare_precedente_calcolo_automatico'],
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
