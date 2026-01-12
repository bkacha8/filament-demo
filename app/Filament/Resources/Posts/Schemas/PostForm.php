<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')
                    ->label('Title')->rules(['required'])->validationMessages([
                        'required' => 'The title field is required.',
                    ]),
                TextInput::make('slug')
                    ->rules(['required'])
                    ->unique(table: 'posts', column: 'slug', ignoreRecord: true)
                    ->label('Slug'),
                ColorPicker::make('color')
                    ->label('Color')->rules(['required']),
                DatePicker::make('published_at')
                    ->label('Published At')->rules(['required']),
                Select::make('category_id')->rules(['required'])
                    ->relationship('category', 'name')->label('Category')->searchable(),
                Select::make('tags')->rules(['required'])
                    ->label('Tags')->relationship('tags', 'title')->multiple(),
                FileUpload::make('image')->rules(['required'])
                    ->label('Image')
                    ->disk('public')
                    ->directory('post-images'),
                MarkdownEditor::make('body')
                    ->label('Body')->rules(['required']),
                Checkbox::make('published')
                    ->label('Published'),
                Checkbox::make('is_active')
                    ->label('Is Active'),


            ]);
    }
}
