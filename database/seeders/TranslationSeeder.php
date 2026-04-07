<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            // === HEADER ===
            ['key' => 'header.experience',   'group' => 'header', 'fr' => 'Expérience',  'en' => 'Experience',  'es' => 'Experiencia'],
            ['key' => 'header.projects',     'group' => 'header', 'fr' => 'Projets',     'en' => 'Projects',    'es' => 'Proyectos'],
            ['key' => 'header.services',     'group' => 'header', 'fr' => 'Services',    'en' => 'Services',    'es' => 'Servicios'],
            ['key' => 'header.education',    'group' => 'header', 'fr' => 'Formation',   'en' => 'Education',   'es' => 'Formación'],
            ['key' => 'header.blog',         'group' => 'header', 'fr' => 'Blog',        'en' => 'Blog',        'es' => 'Blog'],
            ['key' => 'header.publications', 'group' => 'header', 'fr' => 'Publications','en' => 'Publications','es' => 'Publicaciones'],
            ['key' => 'header.references',   'group' => 'header', 'fr' => 'Références',  'en' => 'References',  'es' => 'Referencias'],
            ['key' => 'header.contact',      'group' => 'header', 'fr' => 'Contact',     'en' => 'Contact',     'es' => 'Contacto'],
            ['key' => 'header.cv',           'group' => 'header', 'fr' => 'CV',          'en' => 'CV',          'es' => 'CV'],

            // === HERO ===
            ['key' => 'hero.contact_button',  'group' => 'hero', 'fr' => 'Me contacter',     'en' => 'Contact me',     'es' => 'Contáctame'],
            ['key' => 'hero.download_cv',     'group' => 'hero', 'fr' => 'Télécharger CV',   'en' => 'Download CV',    'es' => 'Descargar CV'],

            // === FILTRES ===
            ['key' => 'filters.all',          'group' => 'filters', 'fr' => 'Tout',        'en' => 'All',         'es' => 'Todo'],
            ['key' => 'filters.paid',         'group' => 'filters', 'fr' => 'Emploi',      'en' => 'Job',         'es' => 'Empleo'],
            ['key' => 'filters.founded',      'group' => 'filters', 'fr' => 'Fondé',       'en' => 'Founded',     'es' => 'Fundado'],
            ['key' => 'filters.volunteer',    'group' => 'filters', 'fr' => 'Bénévolat',   'en' => 'Volunteer',   'es' => 'Voluntariado'],
            ['key' => 'filters.internship',   'group' => 'filters', 'fr' => 'Stage',       'en' => 'Internship',  'es' => 'Pasantía'],
            ['key' => 'filters.customer',     'group' => 'filters', 'fr' => 'Client',      'en' => 'Customer',    'es' => 'Cliente'],
            ['key' => 'filters.personal',     'group' => 'filters', 'fr' => 'Personnel',   'en' => 'Personal',    'es' => 'Personal'],
            ['key' => 'filters.open_source',  'group' => 'filters', 'fr' => 'Open Source', 'en' => 'Open Source', 'es' => 'Open Source'],
            ['key' => 'filters.academic',     'group' => 'filters', 'fr' => 'Académique',  'en' => 'Academic',    'es' => 'Académico'],
            ['key' => 'filters.conference',   'group' => 'filters', 'fr' => 'Conférence',  'en' => 'Conference',  'es' => 'Conferencia'],
            ['key' => 'filters.journal',      'group' => 'filters', 'fr' => 'Article',     'en' => 'Journal',     'es' => 'Artículo'],
            ['key' => 'filters.thesis',       'group' => 'filters', 'fr' => 'Mémoire',     'en' => 'Thesis',      'es' => 'Tesis'],
            ['key' => 'filters.report',       'group' => 'filters', 'fr' => 'Rapport',     'en' => 'Report',      'es' => 'Informe'],

            // === PROJETS ===
            ['key' => 'projects.featured',    'group' => 'projects', 'fr' => 'Mis en avant',  'en' => 'Featured',     'es' => 'Destacado'],
            ['key' => 'projects.view_demo',   'group' => 'projects', 'fr' => 'Voir la démo',  'en' => 'Watch demo',   'es' => 'Ver demo'],
            ['key' => 'projects.no_preview',  'group' => 'projects', 'fr' => 'Pas d\'aperçu', 'en' => 'No preview',   'es' => 'Sin vista previa'],
            ['key' => 'projects.empty',       'group' => 'projects', 'fr' => 'Aucun projet dans cette catégorie.', 'en' => 'No project in this category.', 'es' => 'Ningún proyecto en esta categoría.'],

            // === EXPERIENCES ===
            ['key' => 'experiences.empty',    'group' => 'experiences', 'fr' => 'Aucune expérience dans cette catégorie.', 'en' => 'No experience in this category.', 'es' => 'Ninguna experiencia en esta categoría.'],

            // === BLOG ===
            ['key' => 'blog.read_more',       'group' => 'blog', 'fr' => 'Voir tous les articles', 'en' => 'View all articles', 'es' => 'Ver todos los artículos'],
            ['key' => 'blog.reading_time',    'group' => 'blog', 'fr' => 'min de lecture',         'en' => 'min read',          'es' => 'min de lectura'],
            ['key' => 'blog.back',            'group' => 'blog', 'fr' => 'Retour au blog',         'en' => 'Back to blog',      'es' => 'Volver al blog'],

            // === PUBLICATIONS ===
            ['key' => 'publications.abstract', 'group' => 'publications', 'fr' => 'Voir le résumé', 'en' => 'View abstract', 'es' => 'Ver resumen'],
            ['key' => 'publications.copied',   'group' => 'publications', 'fr' => 'Copié !',        'en' => 'Copied!',       'es' => '¡Copiado!'],
            ['key' => 'publications.project',  'group' => 'publications', 'fr' => 'Projet',         'en' => 'Project',       'es' => 'Proyecto'],
            ['key' => 'publications.empty',    'group' => 'publications', 'fr' => 'Aucune publication dans cette catégorie.', 'en' => 'No publication in this category.', 'es' => 'Ninguna publicación en esta categoría.'],

            // === CONTACT ===
            ['key' => 'contact.find_me',      'group' => 'contact', 'fr' => 'Retrouvez-moi sur',     'en' => 'Find me on',           'es' => 'Encuéntrame en'],
            ['key' => 'contact.my_cv',        'group' => 'contact', 'fr' => 'Mon CV',                'en' => 'My CV',                'es' => 'Mi CV'],
            ['key' => 'contact.send_message', 'group' => 'contact', 'fr' => 'Envoyez-moi un message','en' => 'Send me a message',    'es' => 'Envíame un mensaje'],
            ['key' => 'contact.name',         'group' => 'contact', 'fr' => 'Nom',                   'en' => 'Name',                 'es' => 'Nombre'],
            ['key' => 'contact.email',        'group' => 'contact', 'fr' => 'Email',                 'en' => 'Email',                'es' => 'Correo'],
            ['key' => 'contact.message',      'group' => 'contact', 'fr' => 'Message',               'en' => 'Message',              'es' => 'Mensaje'],
            ['key' => 'contact.your_name',    'group' => 'contact', 'fr' => 'Votre nom',             'en' => 'Your name',            'es' => 'Tu nombre'],
            ['key' => 'contact.your_email',   'group' => 'contact', 'fr' => 'votre@email.com',       'en' => 'your@email.com',       'es' => 'tu@email.com'],
            ['key' => 'contact.your_message', 'group' => 'contact', 'fr' => 'Votre message...',      'en' => 'Your message...',      'es' => 'Tu mensaje...'],
            ['key' => 'contact.send',         'group' => 'contact', 'fr' => 'Envoyer',               'en' => 'Send',                 'es' => 'Enviar'],
            ['key' => 'contact.sending',      'group' => 'contact', 'fr' => 'Envoi en cours...',     'en' => 'Sending...',           'es' => 'Enviando...'],
            ['key' => 'contact.success',      'group' => 'contact', 'fr' => 'Message envoyé !',     'en' => 'Message sent!',        'es' => '¡Mensaje enviado!'],
            ['key' => 'contact.success_text', 'group' => 'contact', 'fr' => 'Je vous répondrai dans les plus brefs délais.', 'en' => 'I will reply as soon as possible.', 'es' => 'Te responderé lo antes posible.'],
            ['key' => 'contact.send_another', 'group' => 'contact', 'fr' => 'Envoyer un autre message', 'en' => 'Send another message', 'es' => 'Enviar otro mensaje'],
            ['key' => 'contact.print_doc',    'group' => 'contact', 'fr' => 'Besoin d\'un document imprimé ?', 'en' => 'Need a printed document?', 'es' => '¿Necesitas un documento impreso?'],
            ['key' => 'contact.click_download','group' => 'contact', 'fr' => 'Cliquez pour télécharger', 'en' => 'Click to download', 'es' => 'Haz clic para descargar'],
            ['key' => 'contact.download_cv',  'group' => 'contact', 'fr' => 'Télécharger le CV',     'en' => 'Download CV',          'es' => 'Descargar CV'],
            ['key' => 'contact.video_bio',    'group' => 'contact', 'fr' => 'Ma biographie en vidéo','en' => 'My video bio',         'es' => 'Mi bio en video'],
            ['key' => 'contact.know_me',      'group' => 'contact', 'fr' => 'Pour mieux me connaître','en' => 'Know me better',         'es' => 'Conóceme mejor'],

            // === REFERENCES ===
            ['key' => 'references.letter_available',  'group' => 'references', 'fr' => 'Lettre disponible', 'en' => 'Letter available', 'es' => 'Carta disponible'],
            ['key' => 'references.letter_pending',    'group' => 'references', 'fr' => 'En attente',        'en' => 'Pending',          'es' => 'Pendiente'],
            ['key' => 'references.letter_on_request', 'group' => 'references', 'fr' => 'Sur demande',       'en' => 'On request',       'es' => 'A petición'],
            ['key' => 'references.letter_pdf',        'group' => 'references', 'fr' => 'Lettre PDF',        'en' => 'PDF Letter',       'es' => 'Carta PDF'],
        ];

        foreach ($translations as $t) {
            Translation::firstOrCreate(
                ['key' => $t['key']],
                [
                    'group'        => $t['group'],
                    'value_fr'     => $t['fr'],
                    'translations' => json_encode([
                        'en' => $t['en'],
                        'es' => $t['es'],
                    ]),
                ]
            );
        }
    }
}