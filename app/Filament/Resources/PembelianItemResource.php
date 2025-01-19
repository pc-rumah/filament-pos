<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Pembelian;
use Filament\Tables\Table;
use App\Models\PembelianItem;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PembelianItemResource\Pages;
use App\Filament\Resources\PembelianItemResource\RelationManagers;

class PembelianItemResource extends Resource
{
    protected static ?string $model = PembelianItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $pembelian = new Pembelian();
        if (request()->filled('pembelian_id')) {
            $pembelian = Pembelian::find(request('pembelian_id'));
        }

        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->label('Tanggal Pembelian')
                    ->default($pembelian->tanggal)
                    ->disabled(),
                TextInput::make('supplier_id')
                    ->label('Nama Supplier')
                    ->required()
                    ->disabled()
                    ->default($pembelian->supplier?->nama),

                TextInput::make('email')
                    ->label('Email Supplier')
                    ->required()
                    ->disabled()
                    ->default($pembelian->supplier?->email),

                Select::make('barang_id')
                    ->label('Nama Barang')
                    ->required()
                    ->options(
                        Barang::all()->pluck('nama_barang', 'id')
                    )
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $barang = Barang::find($state);
                        $set('harga', $barang->harga ?? null);
                    }),

                TextInput::make('jumlah')
                    ->label('Jumlah Barang')
                    ->required(),

                TextInput::make('harga')
                    ->label('Harga Barang')
                    ->required(),


                Hidden::make('pembelian_id')
                    ->default(request('pembelian_id'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pembelian_id')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPembelianItems::route('/'),
            'create' => Pages\CreatePembelianItem::route('/create'),
            'edit' => Pages\EditPembelianItem::route('/{record}/edit'),
        ];
    }
}
