<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make("Tabs")->tabs([
                    Tab::make('Product Info')->icon(Heroicon::AcademicCap)->schema([
                        TextEntry::make('name')->color('primary')->weight('bold')->label('Product Name'),
                        TextEntry::make('sku')->color('secondary')->label('SKU'),
                        TextEntry::make('description')->color('quinary')->label('Description'),
                        TextEntry::make('created_at')->label('Created At')->date('y-m-d'),
                    ]),
                    Tab::make('Product Price & Stock')->badgeColor('danger')->badge(10)->icon(Heroicon::CurrencyDollar)->schema([
                        TextEntry::make('price')->color('tertiary')->badge()->color('success')->label('Price')->icon(Heroicon::CurrencyDollar),
                        TextEntry::make('stock')->color('quaternary')->label('Stock'),
                    ]),
                    Tab::make('Product Image')->icon(Heroicon::ListBullet)->schema([
                        ImageEntry::make('image')->label('Image')->disk('public'),
                    ])
                ])->columnSpanFull()->vertical(),
            ]);
    }
}
