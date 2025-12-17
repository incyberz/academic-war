<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MhsResource\Pages;
use App\Filament\Resources\MhsResource\RelationManagers;
use App\Models\Mhs;
use App\Models\Prodi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MhsResource extends Resource
{
    protected static ?string $model = Mhs::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Data Mahasiswa';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->maxLength(20),
                Forms\Components\Select::make('prodi_id')
                    // ->relationship('prodi', 'nama')
                    ->options(function () {
                        return Prodi::all()->pluck('nama', 'prodi')->toArray();
                    })
                    ->required(),
                Forms\Components\TextInput::make('angkatan')
                    ->required()
                    ->maxLength(4),
                Forms\Components\Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'cuti' => 'Cuti',
                        'lulus' => 'Lulus',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nim')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('prodi.nama')->label('Prodi')->sortable(),
                Tables\Columns\TextColumn::make('angkatan')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('prodi')->relationship('prodi', 'nama'),
                Tables\Filters\SelectFilter::make('status')->options([
                    'aktif' => 'Aktif',
                    'cuti' => 'Cuti',
                    'lulus' => 'Lulus',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMhs::route('/'),
            'create' => Pages\CreateMhs::route('/create'),
            'edit' => Pages\EditMhs::route('/{record}/edit'),
        ];
    }
}
