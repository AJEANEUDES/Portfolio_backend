<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certifications = [
            [
                'name'             => 'AWS Certified Solutions Architect - Associate',
                'issuer'           => 'Amazon Web Services',
                'category'         => 'cloud',
                'credential_id'    => 'AWS-ASA-12345678',
                'verification_url' => 'https://www.credly.com/badges/example',
                'issued_date'      => '2025-06-15',
                'expiration_date'  => '2028-06-15',
                'description'      => 'Certification validant les compétences en conception et déploiement de systèmes distribués sur AWS.',
                'skills'           => ['AWS', 'Cloud Architecture', 'EC2', 'S3', 'VPC', 'IAM'],
                'is_featured'      => true,
                'order'            => 1,
            ],
            [
                'name'             => 'TensorFlow Developer Certificate',
                'issuer'           => 'Google',
                'category'         => 'ai_ml',
                'credential_id'    => 'TF-DEV-98765',
                'verification_url' => 'https://www.credential.net/example',
                'issued_date'      => '2024-11-20',
                'expiration_date'  => '2027-11-20',
                'description'      => 'Certification officielle Google validant les compétences en deep learning avec TensorFlow.',
                'skills'           => ['TensorFlow', 'Deep Learning', 'Neural Networks', 'Computer Vision'],
                'is_featured'      => true,
                'order'            => 2,
            ],
            [
                'name'             => 'Professional Scrum Master I',
                'issuer'           => 'Scrum.org',
                'category'         => 'other',
                'credential_id'    => 'PSM-I-456789',
                'verification_url' => 'https://www.scrum.org/certificates/example',
                'issued_date'      => '2024-03-10',
                'expiration_date'  => null,
                'description'      => 'Certification démontrant la maîtrise des principes et pratiques du framework Scrum.',
                'skills'           => ['Scrum', 'Agile', 'Project Management'],
                'is_featured'      => false,
                'order'            => 3,
            ],
        ];

        foreach ($certifications as $data) {
            Certification::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'slug'      => Str::slug($data['name']),
                    'is_active' => true,
                ])
            );
        }
    }
}