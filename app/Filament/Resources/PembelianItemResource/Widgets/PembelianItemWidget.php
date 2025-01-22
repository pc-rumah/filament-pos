<?php

namespace App\Filament\Resources\PembelianItemResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PembelianItem;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Summarizer;

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
                TextColumn::make('jumlah')->label('Jumlah Barang')
                    ->alignCenter(),
                TextColumn::make('harga')->label('Harga Barang')
                    ->money('IDR')->alignEnd(),
                TextColumn::make('total')->label('Total Harga')
                    ->getStateUsing(function ($record) {
                        return $record->jumlah * $record->harga;
                    })->money('IDR')->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->money('IDR')
                            ->using(function ($query) {
                                return $query->sum(DB::raw('jumlah * harga'));
                            })
                    ),
            ])->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        TextInput::make('jumlah')->required(),
                    ]),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
