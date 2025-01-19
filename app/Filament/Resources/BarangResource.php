<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Data Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_barang')->required(),
                TextInput::make('nama_barang')->required(),
                Select::make('kategori_barang')
                    ->options([
                        'perabotan' => 'Perabotan',
                        'Makanan' => 'Makanan',
                        'Minuman' => 'Minuman',
                    ]),
                TextInput::make('stok_barang')
                    ->required()
                    ->disabledOn('edit'),
                Select::make('satuan')
                    ->options([
                        'pcs' => 'Pcs',
                        'kg' => 'Kg',
                        'liter' => 'Liter',
                    ]),
                TextInput::make('harga')
                    ->required()
                    ->type('number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_barang')->searchable(),
                TextColumn::make('nama_barang')->searchable(),
                TextColumn::make('kategori_barang'),
                TextColumn::make('stok_barang'),
                TextColumn::make('satuan'),
                TextColumn::make('harga'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
