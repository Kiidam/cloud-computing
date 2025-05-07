<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CloudService;
use App\Models\SecurityMeasure;
use App\Models\SecurityIncident;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $s3Service = CloudService::create([
            'name' => 'Cloud Storage Service',
            'provider' => 'AWS',
            'type' => 'Storage',
            'description' => 'S3 Bucket for application storage',
            'status' => 'active',
            'configuration' => [
                'region' => 'us-east-1',
                'bucket' => 'app-storage'
            ]
        ]);

        CloudService::create([
            'name' => 'Application Server',
            'provider' => 'AWS',
            'type' => 'Compute',
            'description' => 'EC2 instances for application hosting',
            'status' => 'active',
            'configuration' => [
                'instance_type' => 't3.medium',
                'region' => 'us-east-1'
            ]
        ]);

        CloudService::create([
            'name' => 'Database Service',
            'provider' => 'AWS',
            'type' => 'Database',
            'description' => 'RDS instance for application database',
            'status' => 'active',
            'configuration' => [
                'engine' => 'postgres',
                'version' => '13.7'
            ]
        ]);

        SecurityMeasure::create([
            'name' => 'Data Encryption',
            'type' => 'Encryption',
            'description' => 'AES-256 encryption for all stored data',
            'status' => 'implemented',
            'settings' => [
                'algorithm' => 'AES-256',
                'key_rotation' => '90 days'
            ],
            'implementation_date' => now(),
            'review_date' => now()->addMonths(3)
        ]);

        SecurityMeasure::create([
            'name' => 'Access Control',
            'type' => 'Authentication',
            'description' => 'Multi-factor authentication for all admin access',
            'status' => 'implemented',
            'settings' => [
                'mfa_required' => true,
                'session_timeout' => '2 hours'
            ],
            'implementation_date' => now()->subMonths(1),
            'review_date' => now()->addMonths(2)
        ]);

        SecurityMeasure::create([
            'name' => 'Network Security',
            'type' => 'Firewall',
            'description' => 'Advanced firewall rules and intrusion detection',
            'status' => 'implemented',
            'settings' => [
                'ids_enabled' => true,
                'allowed_ips' => ['10.0.0.0/8', '192.168.0.0/16']
            ],
            'implementation_date' => now()->subMonths(2),
            'review_date' => now()->addMonth()
        ]);

        SecurityIncident::create([
            'title' => 'Unauthorized Access Attempt',
            'description' => 'Multiple failed login attempts detected from suspicious IP',
            'severity' => 'medium',
            'status' => 'resolved',
            'cloud_service_id' => $s3Service->id,
            'detected_at' => now()->subDays(5),
            'resolved_at' => now()->subDays(4),
            'affected_resources' => [
                'service' => 'Authentication System',
                'ip_addresses' => ['192.168.1.100']
            ],
            'resolution_steps' => [
                'IP blocked',
                'Security rules updated',
                'Additional monitoring implemented'
            ]
        ]);

        SecurityIncident::create([
            'title' => 'High Resource Usage Alert',
            'description' => 'Unusual spike in CPU and memory usage detected',
            'severity' => 'low',
            'status' => 'investigating',
            'cloud_service_id' => $s3Service->id,
            'detected_at' => now()->subHours(12),
            'affected_resources' => [
                'service' => 'Application Server',
                'resource_type' => 'CPU/Memory'
            ]
        ]);
    }
}
