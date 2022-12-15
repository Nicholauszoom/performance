<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    public $timestamps = false;

    protected $fillable = [
        'fname',
        'mname',

        // 'emp_code' =>$request->input("emp_code"),
        // 'emp_level' =>$request->input("emp_level"),

        'lname',

        // 'lname' =>$randomPassword,

        'salary',
        'gender',
        'email' ,
        'nationality' , //$request->nationality,
        'merital_status',
        'birthdate',
        'position' ,
        'contract_type' ,
        'postal_address',
        'physical_address',
        'mobile' ,
        'account_no' ,
        'bank' , //$request->bank,
        'bank_branch', //$request->bank_branch,
        'pension_fund' , //$request->pension_fund,
        'pf_membership_no',
        'home' ,
        'postal_city' ,
        'photo' ,
        'password_set' ,
        'line_manager' ,
        'department' ,
        'branch' , //$request->branch,
        'hire_date' ,
        'contract_renewal_date' ,
        'emp_id' ,
        'username' ,
        'password' ,
        'contract_end' ,
        'state' ,
        'national_id' ,
        'tin',
    ];
}
