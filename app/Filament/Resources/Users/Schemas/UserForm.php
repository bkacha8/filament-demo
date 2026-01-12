<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User Information')->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Name'),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique('users', 'email', ignoreRecord: true)
                    ->label('Email'),
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password'),
            ]),
            Section::make('Location')->schema([
                Select::make('country_id')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->required()->reactive()
                    ->label('Country')
                    ->afterStateUpdated(function (callable $set) {
                        $set('state_id', null);
                        $set('city_id', null);
                    }),
                Select::make('state_id')
                    ->options(function (callable $get) {
                        $country = Country::find($get('country_id'));
                        return $country ? $country->states->pluck('name', 'id') : [];
                    })
                    ->required()->reactive()
                    ->label('State')
                    ->afterStateUpdated(function (callable $set) {
                        $set('city_id', null);
                    }),
                Select::make('city_id')
                    ->options(function (callable $get) {
                        $state = State::find($get('state_id'));
                        return $state ? $state->cities->pluck('name', 'id') : [];
                    })
                    ->required()->reactive()
                    ->label('City'),
            ])

        ]);
    }
}
