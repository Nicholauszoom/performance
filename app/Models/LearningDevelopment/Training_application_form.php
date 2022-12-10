<?php

namespace App\Models\LearningDevelopment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training_application_form extends Model
{
    use HasFactory;
    protected $table = "tbl_training_application_form";

protected $fillable = [
'fname',
'mname',
'lname',
'skill',
'reason',
'location',
'budget',
'start_date',
'end_date',
]; 

public function training_application_form () 
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->text('mname');
            $table->string('lname');
            $table->text('skill');
            $table->string('reason');
            $table->string('location');
            $table->string('budget');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }
}