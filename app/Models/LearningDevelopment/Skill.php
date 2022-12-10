<?php

namespace App\Models\LearningDevelopment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;
    protected $table = "tbl_skill";

protected $fillable = [
'role_name',
'skill',
'budget',
'skill',
]; 

public function skill () 
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->text('skill');
            $table->string('budget');
            $table->timestamps();
        });
    }
}