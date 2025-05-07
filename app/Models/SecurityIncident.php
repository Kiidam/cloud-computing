<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityIncident extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'severity',
    'status',
    'cloud_service_id',
    'detected_at',
    'resolved_at',
    'affected_resources',
    'resolution_steps'
  ];

  protected $casts = [
    'detected_at' => 'datetime',
    'resolved_at' => 'datetime',
    'affected_resources' => 'array',
    'resolution_steps' => 'array'
  ];

  public function cloudService()
  {
    return $this->belongsTo(CloudService::class);
  }
}
