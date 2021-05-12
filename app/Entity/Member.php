<?php

//用於存取member資料表的Entity
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'staffID';
    protected $fillable = [
        "status",
        "name",
        "account",
        "password",
    ];
}