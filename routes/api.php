<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\EducationController;
use App\Http\Controllers\Api\V1\ExperienceController;
use App\Http\Controllers\Api\V1\LanguageController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\PublicationController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\SocialLinkController;
use App\Http\Controllers\Api\V1\TrackingController;
use App\Http\Controllers\Api\V1\ReferenceController;
use App\Http\Controllers\Api\V1\SiteSectionController;
use App\Http\Controllers\Api\V1\TranslationController;
use App\Http\Controllers\Api\V1\CertificationController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes — Portfolio
|--------------------------------------------------------------------------
|
| Toutes les routes sont publiques (lecture) sauf mention contraire.
| Identifiants : par slug uniquement — aucun ID exposé.
| Langue : header Accept-Language (fr, en, es...)
|
*/

Route::prefix('v1')->middleware('force.json')->group(function () {

    // --- Profil (singleton) ---
    Route::get('profile', ProfileController::class)
        ->name('api.v1.profile');

    // --- Services ---
    Route::get('services', [ServiceController::class, 'index'])
        ->name('api.v1.services.index');

    // --- Expériences ---
    Route::get('experiences', [ExperienceController::class, 'index'])
        ->name('api.v1.experiences.index');

    // --- Projets ---
    Route::get('projects', [ProjectController::class, 'index'])
        ->name('api.v1.projects.index');
    Route::get('projects/{project}', [ProjectController::class, 'show'])
        ->name('api.v1.projects.show');

    // --- Éducation ---
    Route::get('educations', [EducationController::class, 'index'])
        ->name('api.v1.educations.index');

    // --- Blog ---
    Route::get('posts', [PostController::class, 'index'])
        ->name('api.v1.posts.index');
    Route::get('posts/{post}', [PostController::class, 'show'])
        ->name('api.v1.posts.show');

    // --- Publications ---
    Route::get('publications', [PublicationController::class, 'index'])
        ->name('api.v1.publications.index');

    // --- Catégories ---
    Route::get('categories', [CategoryController::class, 'index'])
        ->name('api.v1.categories.index');

    // --- Langues disponibles ---
    Route::get('languages', [LanguageController::class, 'index'])
        ->name('api.v1.languages.index');

    // --- Liens sociaux ---
    Route::get('social-links', [SocialLinkController::class, 'index'])
        ->name('api.v1.social-links.index');

    // --- Contact (rate-limited : 5 messages par minute) ---
    Route::post('contact', [ContactController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('api.v1.contact.store');

    // --- Tracking analytics (rate-limited : 30 par minute) ---
    Route::post('track', [TrackingController::class, 'store'])
        ->middleware('throttle:30,1')
        ->name('api.v1.track.store');
    // --- Références ---
    Route::get('references', [ReferenceController::class, 'index'])
        ->name('api.v1.references.index');  
    // --- Sections du site ---
    Route::get('sections', [SiteSectionController::class, 'index'])
    ->name('api.v1.sections.index');
        // --- Traductions (clé/valeur pour i18n frontend) ---
    Route::get('translations', [TranslationController::class, 'index'])
    ->name('api.v1.translations.index');
    // --- Certifications ---
    Route::get('certifications', [CertificationController::class, 'index'])
    ->name('api.v1.certifications.index');
});