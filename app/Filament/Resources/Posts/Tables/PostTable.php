<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\TernaryFilter;

class PostTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->date()->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('image')->disk('public')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->weight(FontWeight::Bold)->sortable()->searchable()->toggleable(),
                TextColumn::make('slug')->sortable()->searchable()->toggleable(),
                TextColumn::make('category.name')->sortable()->searchable()->toggleable(),
                TextColumn::make('published_at')->date()->sortable()->searchable()->toggleable(),
                // ToggleColumn::make('published')->toggleable(),
                // ToggleColumn::make('is_active')->toggleable(),
                IconColumn::make('published')->toggleable(),
                IconColumn::make('is_active')->toggleable(),
                TextColumn::make('tags.title')->sortable()->searchable()->toggleable(),
                ColorColumn::make('color')->toggleable(),
                TextColumn::make('body')->sortable()->searchable()->toggleable(),
            ])
            ->searchable()
            ->filters([
                TernaryFilter::make('published')->placeholder('All'),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')->label("Select category"),
                Filter::make('published_at')->label("Select published date")->schema([
                    DatePicker::make('published_at')->label('Published At'),
                ])->query(function ($query, array $data) {
                    if (!empty($data['published_at'])) {
                        $query->whereDate('published_at', '=', $data['published_at']);
                    }
                }),
                // QueryBuilder::make()
                //     ->constraints([
                //         TextConstraint::make('name'),
                //         BooleanConstraint::make('published'),
                //         // NumberConstraint::make('stock'),
                //         // SelectConstraint::make('category_id')
                //         //     ->relationship('category', 'name')
                //         //     ->multiple(),
                //         DateConstraint::make('created_at'),
                //         RelationshipConstraint::make('category')
                //             ->multiple()
                //             ->selectable(
                //                 IsRelatedToOperator::make()
                //                     ->titleAttribute('name')
                //                     ->searchable()
                //                     ->multiple(),
                //             ),
                //         // NumberConstraint::make('reviews.rating')
                //         //     ->integer(),
                //     ])
            ])
            ->recordActions([
                ReplicateAction::make(),
                DeleteAction::make(),
                EditAction::make(),
                // Action::make("status change")->action(fn(Post $record) => $record->update(['published' => !$record->published])),
                Action::make("status change")->fillForm(fn(Post $record) => [
                    'published' => $record->published,
                    'is_active' => $record->is_active,
                ])->icon(Heroicon::ArrowDownLeft)->schema([
                    Checkbox::make('published')->label('Published'),
                    Checkbox::make('is_active')->label('Is Active'),
                ])->action(function (Post $record, array $data) {
                    $record->update(['published' => $data['published'], 'is_active' => $data['is_active']]);
                })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
