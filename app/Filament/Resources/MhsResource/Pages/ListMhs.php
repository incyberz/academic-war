<?php

namespace App\Filament\Resources\MhsResource\Pages;

use App\Filament\Resources\MhsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMhs extends ListRecords
{
    protected static string $resource = MhsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
