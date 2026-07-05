<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PreviewImport implements ToArray, WithHeadingRow
{
    public function array(array $array)
    {
        return $array;
    }
    
    public function headingRow(): int
    {
        return 1;
    }
}