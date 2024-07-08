<?php

namespace App\Models\Attributes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model {

    // Your model code goes here

    use HasFactory;

    protected $table = "attribute_genders";

}
