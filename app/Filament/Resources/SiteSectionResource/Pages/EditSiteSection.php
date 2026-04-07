<?php

namespace App\Filament\Resources\SiteSectionResource\Pages;

use App\Filament\Resources\SiteSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteSection extends EditRecord
{
    protected static string $resource = SiteSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
