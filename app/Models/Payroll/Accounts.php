<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = "tbl_accounts";

    protected $primaryKey = "account_id";

    protected $fillable = ['account_id','account_name','description','balance','account_number','contact_person','contact_phone','bank_details','permission'];

    public static function pendingPayroll_month(){
        $query = "payroll_date as payroll_month  WHERE state = 1 OR state = 2  LIMIT 1";
        $record = DB::table('payroll_months')
        ->select(DB::raw($query));
        
        $records = $record->count();
        if ($records==1) {
            $row = $record->row();
            return $row->payroll_month;
        } else return 2;
    }
}


