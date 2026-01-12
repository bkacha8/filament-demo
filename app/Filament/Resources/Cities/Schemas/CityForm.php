<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->required()->reactive(),
                Select::make('state_id')
                    ->label('State')
                    ->options(function (callable $get) {
                        $country = Country::find($get('country_id'));
                        return $country ? $country->states->pluck('name', 'id') : [];
                    })
                    ->required()->reactive(),
                TextInput::make('name')
                    ->label('Name')->rules(['required'])->maxLength(255)->reactive(),
            ]);
    }
}
