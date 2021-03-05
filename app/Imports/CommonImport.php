<?php

namespace App\Imports;

use App\LogMessage;
use App\Traits\ExcelNormalizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Validators\Failure;
use Psr\Log\LogLevel;

abstract class CommonImport implements ToCollection, WithMapping, WithHeadingRow, WithCalculatedFormulas, HasReferencesToOtherSheets
{
    use ExcelNormalizer;

    /**
     * Spreadsheet name for logging purposes.
     *
     * @var string
     */
    protected string $name;

    /**
     * Hold the parent multi-import instance
     *
     * @var \App\Imports\BilancioSocialeImport
     */
    protected BilancioSocialeImport $spreadsheet;


    /**
     * Set the parent Multisheet importer
     *
     * @param \Maatwebsite\Excel\Concerns\BilancioSocialeImport $spreadsheet
     * @return void
     */
    public function __construct($spreadsheet, $name)
    {
        $this->spreadsheet = $spreadsheet;
        $this->name = $name;
    }

    /**
     * Define column validation rules.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Process excel rows.
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        return $rows->reject(function ($row) {
            return $row->except($this->years + $this->dates)->filter()->count() === 0;
        })->reject(function ($row) {
            return strpos($row['id_bambino'], 'BN') === 0;
        })->filter(function ($row) {
            return $this->validate($row);
        })->each(function ($row) {
            $this->store($row);
        });
    }

    /**
     * Apply validation rules on a particular row. Failing rows
     * will be recored in the log.
     *
     * @param \Illuminate\Support\Collection $input
     * @return void
     */
    protected function validate($input)
    {
        try {
            Validator::make($input->toArray(), $this->rules())->validate();
            return true;
        } catch(ValidationException $exception) {
            $this->onFailure($exception->validator);
            return false;
        }
    }

    /**
     * Create a new child or attach a new service to him.
     *
     * @param \Illuminate\Support\Collection $row
     * @return void
     */
    abstract protected function store($row);

    /**
     * Handle validation failures
     *
     * @param Failure[] $failures
     */
    public function onFailure($validator)
    {
        $this->fail([
            'level' => LogLevel::ERROR,
            'child' => $validator->attributes()['id_bambino'],
            'errors' => $validator->errors()->all(),
        ]);
    }

    /**
     * Register failure on log files and to database.
     *
     * @param array $context
     * @param LogLevel|null $level
     * @param string|null $message
     * @return void
     */
    protected function fail($context, $level = null, $message = null)
    {
        $level ??= LogLevel::ERROR;
        $message ??= 'Validation failed.';
        $context += [
            'spreadsheet' => $this->name,
            'service' => (string) $this->spreadsheet->getService()->id
        ];

        LogMessage::create($context);
        Log::channel('import')->error($message, $context);
    }
}
