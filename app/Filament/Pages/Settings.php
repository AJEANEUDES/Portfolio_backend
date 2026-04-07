<?php

namespace App\Filament\Pages;

use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Paramètres du site';
    protected static ?string $title = 'Paramètres du site';
    protected static ?int $navigationSort = -1;
    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Profile::first();

        if ($profile) {
            $heroPhrasesTrans = $profile->hero_phrases_translatable;
            if (is_string($heroPhrasesTrans)) {
                $heroPhrasesTrans = json_decode($heroPhrasesTrans, true);
            }

            $this->form->fill([
                'name'  => $profile->name,
                'title' => $profile->title,
                'bio'   => $profile->bio,
                'photo' => $profile->photo,
                'avatar'=> $profile->avatar,
                'cv_file' => $profile->cv_file,
                'video_url' => $profile->video_url,
                'email' => $profile->email,
                'hero_phrases' => $profile->hero_phrases ?? [],
                'hero_phrases_translatable' => $heroPhrasesTrans ?? ['en' => [], 'es' => []],
                'name_translatable'  => is_string($profile->name_translatable) ? json_decode($profile->name_translatable, true) : $profile->name_translatable,
                'title_translatable' => is_string($profile->title_translatable) ? json_decode($profile->title_translatable, true) : $profile->title_translatable,
                'bio_translatable'   => is_string($profile->bio_translatable) ? json_decode($profile->bio_translatable, true) : $profile->bio_translatable,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations principales')
                    ->description('Ces informations s\'affichent dans la section Hero du site.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom complet')
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Titre professionnel')
                            ->required()
                            ->placeholder('Ex: Étudiant M.Sc. & Développeur'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email de contact')
                            ->email(),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biographie')
                            ->rows(4),
                        Forms\Components\TextInput::make('video_url')
                            ->label('Vidéo de présentation (YouTube/Vimeo)')
                            ->url()
                            ->placeholder('https://youtube.com/watch?v=...'),
                    ])->columns(2),

                Forms\Components\Section::make('Photo & CV')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo de profil')
                            ->image()
                            ->directory('profiles')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400'),
                        Forms\Components\FileUpload::make('cv_file')
                            ->label('CV (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('profiles'),
                        Forms\Components\FileUpload::make('avatar')
                            ->label('Avatar (petite icône header)')
                            ->helperText('Image ronde utilisée dans le header du site. Doit être différente de la photo principale.')
                            ->image()
                            ->directory('profiles')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('150')
                            ->imageResizeTargetHeight('150'),
                    ])->columns(2),

                Forms\Components\Section::make('Phrases du Hero (Français)')
    ->description('Ces phrases défilent en boucle dans la section d\'accueil.')
    ->schema([
        Forms\Components\Repeater::make('hero_phrases')
            ->label('Phrases (français)')
            ->simple(
                Forms\Components\TextInput::make('phrase')
                    ->placeholder('Ex: Développeur Full-Stack passionné')
                    ->required()
            )
            ->addActionLabel('Ajouter une phrase')
            ->reorderable()
            ->defaultItems(1),
    ]),

            Forms\Components\Section::make('Phrases du Hero (Traductions)')
            ->description('Versions traduites des phrases. L\'ordre doit correspondre à celui des phrases françaises.')
            ->collapsible()
            ->collapsed()
            ->schema([
                Forms\Components\Tabs::make('hero_phrases_translations')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Anglais')
                            ->schema([
                                Forms\Components\Repeater::make('hero_phrases_translatable.en')
                                    ->label('Phrases (EN)')
                                    ->simple(
                                        Forms\Components\TextInput::make('phrase')
                                            ->placeholder('Ex: Passionate Full-Stack Developer')
                                    )
                                    ->addActionLabel('Add a phrase')
                                    ->reorderable()
                                    ->defaultItems(0),
                            ]),
                        Forms\Components\Tabs\Tab::make('Espagnol')
                            ->schema([
                                Forms\Components\Repeater::make('hero_phrases_translatable.es')
                                    ->label('Phrases (ES)')
                                    ->simple(
                                        Forms\Components\TextInput::make('phrase')
                                            ->placeholder('Ex: Desarrollador Full-Stack apasionado')
                                    )
                                    ->addActionLabel('Añadir una frase')
                                    ->reorderable()
                                    ->defaultItems(0),
                            ]),
                    ]),
            ]),

            Forms\Components\Section::make('Autres traductions')
            ->collapsible()
            ->collapsed()
            ->schema([
                Forms\Components\Tabs::make('translations')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Anglais')
                            ->schema([
                                Forms\Components\TextInput::make('name_translatable.en')->label('Nom (EN)'),
                                Forms\Components\TextInput::make('title_translatable.en')->label('Titre (EN)'),
                                Forms\Components\Textarea::make('bio_translatable.en')->label('Bio (EN)')->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('Espagnol')
                            ->schema([
                                Forms\Components\TextInput::make('name_translatable.es')->label('Nom (ES)'),
                                Forms\Components\TextInput::make('title_translatable.es')->label('Titre (ES)'),
                                Forms\Components\Textarea::make('bio_translatable.es')->label('Bio (ES)')->rows(3),
                            ]),
                    ]),
            ]),


                    ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $profile = Profile::first() ?? new Profile();

        $heroPhrasesRaw = $data['hero_phrases'] ?? [];
        $heroPhrases = array_values(array_filter(
            is_array($heroPhrasesRaw) ? $heroPhrasesRaw : []
        ));

        // Phrases traduites — nettoyer les valeurs vides
        $heroTrans = $data['hero_phrases_translatable'] ?? [];
        if (is_array($heroTrans)) {
            foreach ($heroTrans as $lang => $phrases) {
                $heroTrans[$lang] = array_values(array_filter(
                    is_array($phrases) ? $phrases : []
                ));
            }
        }

        $profile->fill([
            'name'   => $data['name'],
            'title'  => $data['title'],
            'bio'    => $data['bio'],
            'photo'  => $data['photo'],
            'avatar' => $data['avatar'],
            'cv_file' => $data['cv_file'],
            'video_url' => $data['video_url'],
            'email'  => $data['email'],
            'hero_phrases' => $heroPhrases,
            'hero_phrases_translatable' => json_encode($heroTrans),
            'name_translatable'  => isset($data['name_translatable']) ? json_encode($data['name_translatable']) : null,
            'title_translatable' => isset($data['title_translatable']) ? json_encode($data['title_translatable']) : null,
            'bio_translatable'   => isset($data['bio_translatable']) ? json_encode($data['bio_translatable']) : null,
        ]);

        $profile->save();

        Notification::make()->title('Paramètres sauvegardés')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Sauvegarder')
                ->submit('save'),
        ];
    }
}