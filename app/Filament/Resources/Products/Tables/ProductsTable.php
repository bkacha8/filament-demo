<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Laravel\Pail\File;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Product Image')->disk('public'),
                TextColumn::make('name')->label('Product Name')->searchable()->sortable(),
                TextColumn::make("sku")->label("SKU")->searchable()->sortable(),
                TextColumn::make("stock")->label("Stock")->sortable(),
                TextColumn::make("price")->label("Price")->money('usd')->sortable(),
                TextColumn::make("description")->label("Description")->searchable()->sortable(),
            ])->defaultSort("name", "asc")
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
