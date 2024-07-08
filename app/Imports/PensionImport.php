<?php
namespace App\Imports;

use App\Models\PayrollLog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;


class PensionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $payrollDate = $row['payroll_date'];
        $payrolldateObj = Carbon::createFromFormat('d/m/Y', $payrollDate);
        $payrollDate = $payrolldateObj->format('Y-m-d');

        // $payrollDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['payroll_date'])->format('Y-m-d');

        $receiptDate = $row['receipt_date'];

        if($receiptDate){
        $receiptdateObj = Carbon::createFromFormat('d/m/Y', $receiptDate);
        $receiptDate = $receiptdateObj->format('Y-m-d');
        }

        // $receiptDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['receipt_date'])->format('Y-m-d');
        $empID = $row['employee_id'];

        $payrollLog = PayrollLog::where('payroll_date', $payrollDate)->where('empID', $empID)->first();

        // dd($payrollDate);

        if ($payrollLog) {
            $payrollLog->update([
                'empID' => $empID,
                'pension_employer' => $row['pension_employer'],
                'pension_employee' => $row['pension_employee'],
                'receipt_date' => $receiptDate,
                'years' => $payrolldateObj->format('Y'),
                'receipt_no' => $row['receipt_number'],
                'pension_fund' => $row['pension_fund'],
            ]);
        } else {
            $payrollLog = new PayrollLog([
                'empID' => $empID,
                'payroll_date' => $payrollDate,
                'pension_employer' => $row['pension_employer'],
                'pension_employee' => $row['pension_employee'],
                'receipt_date' => $receiptDate,
                'years' => $payrolldateObj->format('Y'),
                'receipt_no' => $row['receipt_number'],
                'pension_fund' => $row['pension_fund'],
            ]);
        }

        return $payrollLog;
    }
}

