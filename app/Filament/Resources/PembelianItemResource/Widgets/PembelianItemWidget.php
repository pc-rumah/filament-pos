<?php

namespace App\Filament\Resources\PembelianItemResource\Widgets;

use App\Models\PembelianItem;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PembelianItemWidget extends BaseWidget
{

    public $pembelianId;

    public function mount($record)
    {
        $this->pembelianId = $record;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                PembelianItem::query()->where('pembelian_id', $this->pembelianId),
            )
            ->columns([
                TextColumn::make('barang.nama_barang')->label('Nama Barang'),
                TextColumn::make('jumlah')->label('Jumlah Barang'),
                TextColumn::make('harga')->label('Harga Barang'),
            ]);
    }
}
