<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('country_id')
                    ->label('Country')
                    ->relationship('country', 'name')
                    ->required(),
                TextInput::make('name')->required()
                    ->label('Name')->rules(['required'])->maxLength(255),
            ]);
    }
}
