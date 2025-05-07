<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudService extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'provider',
    'type',
    'description',
    'status',
    'configuration'
  ];

  protected $casts = [
    'configuration' => 'array'
  ];
}
