<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityMeasure extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'type',
    'description',
    'status',
    'settings',
    'implementation_date',
    'review_date'
  ];

  protected $casts = [
    'settings' => 'array',
    'implementation_date' => 'date',
    'review_date' => 'date'
  ];
}
