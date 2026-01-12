<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Support\Icons\Heroicon;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make("Product Information")->icon(Heroicon::AcademicCap)->description('Enter basic product details')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make('name')->label('Product Name')->required(),
                                TextInput::make('sku')->label('SKU')->required()->unique(table: 'products', column: 'sku', ignoreRecord: true)
                            ])->columns(2),
                            MarkdownEditor::make('description')->label('Description'),

                        ]),
                    Step::make("Product SKU & Price")->description('Enter product SKU and pricing details')
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([
                            TextInput::make('price')->label('Price')->required(),
                            TextInput::make('stock')->label('Stock')->required(),
                        ]),
                    Step::make("Product Image")->icon(Heroicon::HomeModern)->description('Upload product image')
                        ->schema([
                            FileUpload::make('image')->label('Image')->disk('public')->required()->directory('product-images'),
                        ])
                ])->columnSpanFull()->submitAction(Action::make('save')->color('primary')->label('Save Product')->submit('save'))
            ]);
    }
}
