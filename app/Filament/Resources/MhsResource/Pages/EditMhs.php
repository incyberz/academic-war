<?php

namespace App\Filament\Resources\MhsResource\Pages;

use App\Filament\Resources\MhsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMhs extends EditRecord
{
    protected static string $resource = MhsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
