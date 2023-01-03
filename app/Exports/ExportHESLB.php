<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\ImportsEmployee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;


class ExportHESLB implements FromCollection
{
    /**
    * @param Collection $collection
    */
    public function collection()
    {  
      //$query = "SELECT fname,mname FROM employee";
      return ImportsEmployee::select('fname','mname')->get();
      
    }
}
