<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSetting extends Model
{
    use HasFactory;


    protected $table = 'brand_settings';

    protected $fillable = [
        'company_logo',
        'report_logo',
        'dashboard_logo',
        'primary_color',
        'secondary_color',
        'hover_color',
        'hover_color_two',
        'loader_color_one',
        'loader_color_two',
        'loader_color_three',
        'loader_color_four',
        'loader_color_five',
        'loader_color_six',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'login_picture',
        'body_background',
    ];
    
}
