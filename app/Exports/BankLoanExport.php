<?php

namespace App\Exports;

use App\Models\BankLoan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class BankLoanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BankLoan::select("employee_id", "product","amount","created_at")->get();
    }

        /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [ "employee_id", "product","amount","created_at"];
    }
}
