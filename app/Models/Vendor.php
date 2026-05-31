<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        // Account & Business
        'full_name',
        'mobile',   
        'email',
        'password',
        'business_type',
        'experience',
        'referral_code',

        // Shop
        'shop_name',
        'shop_address',
        'pincode',
        'map_location',
        'shop_type',
        'gstin',
        'fssai',
        'shop_photo',
        'business_proof',
        'home_delivery',

        // Bank
        'account_holder',
        'bank_name',
        'account_number',
        'ifsc',
        'upi',
        'pan',
        'pan_image',
        'bank_proof',

        'status'
    ];


    protected $hidden = ['password'];
}
