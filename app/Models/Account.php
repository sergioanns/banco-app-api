<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $table = "accounts";
    protected $fillable = ['full_name', 'identification', 'account_balance'];
    protected $primaryKey = 'id';
    /* public $timestamps = false; */
}
