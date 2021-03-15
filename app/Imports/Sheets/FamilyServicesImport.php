<?php

namespace App\Imports\Sheets;

use App\Family;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FamilyServicesImport extends CommonImport
{
    /**
     * The date fields that needs to be normalized
     *
     * @var array
     */
    protected $dates = [
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
            'rif_id_famiglia' => 'required',

            'anno_inizio_presa_in_carico_dal_servizio' => 'required|date',
            'anno_fine_presa_in_carico_dal_servizio' => 'nullable|present|date',

            'data_inizio_frequenza_servizio_iscrizione_annuale' => 'required|date|before:today',
            'data_fine_frequenza_servizio_dimissione_annuale' => 'nullable|date|before:today',
            'mesi_frequenza_servizio_nellanno_solare_precedente_x_bilancio_sociale_inserire_a_mano' => 'required|integer|min:0|max:12',

            'grado_parentela' => 'sometimes|required|string|in:Genitore,Fratello,nonno,n.a.',
            'attivita' => 'sometimes|required|in:Individuale,Genitori-IND,Genitori-COPPIA,Gruppo Fratelli,Gruppo Nonni,NO,Altro,Verificare',
            'attivita_2' => 'sometimes|present|in:Individuale,Genitori-IND,Genitori-COPPIA,Gruppo Fratelli,Gruppo Nonni,NO,Altro,Verificare',
            'attivita_3' => 'sometimes|present|in:Individuale,Genitori-IND,Genitori-COPPIA,Gruppo Fratelli,Gruppo Nonni,NO,Altro,Verificare',
            'attivita_4' => 'sometimes|present|in:Individuale,Genitori-IND,Genitori-COPPIA,Gruppo Fratelli,Gruppo Nonni,NO,Altro,Verificare',
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

        $family = Family::firstOrCreate([
            'id' => $row['rif_id_famiglia']
        ]);

        $family->services()->attach($this->spreadsheet->getService(), [
            'first_appearance' => $row['anno_inizio_presa_in_carico_dal_servizio'],
            'end_of_charge' => $row['anno_fine_presa_in_carico_dal_servizio'],
            'from' => $row['data_inizio_frequenza_servizio_iscrizione_annuale'],
            'to' => $row['data_fine_frequenza_servizio_dimissione_annuale'],
            'attendance_months' => $row['mesi_frequenza_servizio_nellanno_solare_precedente_x_bilancio_sociale_inserire_a_mano'],

            'relationship_degree' => $row['grado_parentela'] ?? null,
            'activity_1' => $row['attivita'] ?? null,
            'activity_2' => $row['attivita_2'] ?? null,
            'activity_3' => $row['attivita_3'] ?? null,
            'activity_4' => $row['attivita_4'] ?? null,
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
