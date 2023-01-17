<?php

namespace App\Imports;

use App\Models\BankLoan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankLoanImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row)
        {


          $data = [
            'employee_id' => $row['employee_id'], 
            'product'=> $row['product'],
            'amount' => $row['amount'], 
            'created_at' => $row['issued_date'], 
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




        }
    }
        // return new BankLoan([
        //         'employee_id' => $row['employee_id'], 
        //         'product'=> $row['product'],
        //         'amount' => $row['amount'], 
                
        //         'added_by' =>1, 
                
          
        // ]);
    // }
// }
