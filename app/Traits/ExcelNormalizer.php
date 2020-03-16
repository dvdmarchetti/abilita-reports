<?php

namespace App\Traits;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

trait ExcelNormalizer
{
    protected $dates = [];

    protected $years = [];

    /**
     * Apply mapping to raw data before validation and parsing.
     * (convert dates from integers to real \DateTime instances)
     *
     * @param array $row
     * @return array
     */
    public function map($row): array
    {
        $row = array_map(function ($value) {
            return mb_convert_encoding(trim($value), 'utf-8');
        }, $row);

        $mappers = ['dates', 'years'];

        foreach ($mappers as $prop) {
            $class = 'map'.ucfirst($prop);
            $row = call_user_func([$this, $class], $row);
        }

        return $row;
    }


    protected function mapDates($row)
    {
        foreach ($this->dates as $date) {
            if (! empty($row[$date])) {
                $row[$date] = new Carbon(Date::excelToDateTimeObject($row[$date]));
            } else {
                $row[$date] = null;
            }
        }

        return $row;
    }

    protected function mapYears($row)
    {
        foreach ($this->years as $year) {
            if (! empty($row[$year])) {
                $row[$year] = Carbon::createMidnightDate($row[$year], 1, 1);
            } else {
                $row[$year] = null;
            }
        }

        return $row;
    }
}
