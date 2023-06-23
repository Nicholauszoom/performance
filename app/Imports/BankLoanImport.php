<?php

namespace App\Imports;

use App\Models\BankLoan;
use App\Models\TempDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BankLoanImport implements ToCollection, WithHeadingRow, WithValidation
{

    use Importable;
    public function startRow(): int
    {
        return 4;
    }

    /**
    * @param Collection $collection
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection )
    {

        foreach ($collection as $row)
        {


        $date= Date::excelToDateTimeObject($row['created_at'])->format('Y-m-d');

        $date_added=TempDate::first();

          $data = [
            'employee_id' => $row['employee_id'],
            'product'=> $row['product'],
            'amount' => $row['amount'],
            'created_at' => $date,
            'added_by'=>Auth::user()->id,
            //'date'=>$date_added->date,
          ];
          $check=DB::table('bank_loans')
          ->where($data)->first();



        if ($check) {
            return redirect('flex/bank-loans/all-loans')->with('status','Uploaded data already exists');
        }
        else{
            $check=DB::table('bank_loans')
                ->insert($data);


    }
        }

        $date_added= TempDate::first();

        $date_added->delete();



        }


        public function rules(): array
        {
            return [
                'created_at' => 'required',
                'product' => 'required',
            ];
        }

        public function customValidationMessages()
    {
        return [
            'created_at.*' => 'Please check the template',
            'product.*' => 'Please check the template',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'created_at' => 'Issued Date',
            'product' => 'Product',
        ];
    }
    }

