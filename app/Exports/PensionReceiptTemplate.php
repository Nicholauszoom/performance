<?php

namespace App\Exports;

use App\Models\BankLoan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PensionReceiptTemplate implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       // return BankLoan::where('product','')->where('id','0')->get();
    }

        /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [ "payroll_no", "receipt","amount","created_at"];
    }
}
