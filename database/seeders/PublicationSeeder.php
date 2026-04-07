<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        $ladderProject = Project::where('name', 'like', '%LADDER%')->first();

        $publications = [
            [
                'title'       => 'LADDER : A Dataset for Comparative Difficulty Analysis in Platformer Video Games',
                'authors'     => 'Adjanohoun, J., Bouchard, B., Tremblay, H., Francillette, Y.',
                'type'        => 'conference',
                'venue'       => 'IEEE Conference on Games (CoG)',
                'year'        => 2026,
                'abstract'    => 'We present LADDER, a novel dataset designed for comparative difficulty analysis across platformer video games. Using computer vision pipelines with YOLO object detection, we automatically extract and classify gameplay elements from speedrun footage of Super Mario Bros, Super Meat Boy, and Mega Man. Our pipeline achieves 96.5% automated classification with 60-70% data reduction while maintaining analytical precision.',
                'bibtex'      => '@inproceedings{adjanohoun2026ladder, title={LADDER: A Dataset for Comparative Difficulty Analysis in Platformer Video Games}, author={Adjanohoun, Jean and Bouchard, Bruno and Tremblay, Hugo and Francillette, Yannick}, booktitle={IEEE Conference on Games}, year={2026}}',
                'is_featured' => true,
                'order'       => 1,
                'project_id'  => $ladderProject?->id,
            ],
            [
                'title'       => 'Automated Level Classification in Super Mario Bros Using Deep Learning',
                'authors'     => 'Adjanohoun, J., Francillette, Y., Bouchard, B.',
                'type'        => 'journal',
                'venue'       => 'Journal of Game AI Research',
                'year'        => 2025,
                'abstract'    => 'This paper presents a deep learning approach for automated level classification in Super Mario Bros speedrun footage. Our YOLO-based model achieves 99.5% accuracy on a dataset of 15,566 annotated video frames across 25 object classes.',
                'is_featured' => true,
                'order'       => 2,
                'project_id'  => $ladderProject?->id,
            ],
            [
                'title'       => 'Contribution technique au projet LADDER : Pipeline de traitement vidéo pour l\'analyse de jeux de plateformes',
                'authors'     => 'Adjanohoun, J.',
                'type'        => 'thesis',
                'venue'       => 'Université du Québec à Chicoutimi',
                'year'        => 2026,
                'abstract'    => 'Ce mémoire présente la contribution technique complète au projet LADDER, incluant le développement d\'un pipeline de 15 modules pour le traitement automatisé de vidéos de speedrun. Le système atteint des vitesses de 180-220 FPS avec un taux de classification automatisé de 96.5%.',
                'is_featured' => false,
                'order'       => 3,
                'project_id'  => $ladderProject?->id,
            ],
        ];

        foreach ($publications as $data) {
            Publication::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'is_active' => true,
                    'slug' => Str::slug($data['title'])
                ])
            );
        }
    }
}