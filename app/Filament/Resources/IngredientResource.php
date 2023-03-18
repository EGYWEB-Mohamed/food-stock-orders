<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngredientResource\Pages;
use App\Models\Ingredient;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                                      ->required()
                                      ->maxLength(255),
            Forms\Components\TextInput::make('stock_grams')
                                      ->numeric()
                                      ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('stock_grams')
                                     ->color('success')
                                     ->description(fn (Ingredient $record): string => $record->stock_grams / 1000 .' KG',
                                         position: 'above'),

            Tables\Columns\TextColumn::make('consumed_percentage')
                                     ->color('warning')
                                     ->description(fn (Ingredient $record): string => ' Total Consumed : '.$record->consumed_grams.' ( '.$record->consumed_grams / 1000 .' KG )', position: 'above')
                                     ->description(fn (Ingredient $record): string => ' Total Remain : '.$record->stock_grams - $record->consumed_grams.' ( '.($record->stock_grams - $record->consumed_grams) / 1000 .' KG )')
                                     ->label('Available percentage of stock')
                                     ->suffix('%'),

            Tables\Columns\TextColumn::make('products_count')
                                     ->counts('products')
                                     ->label('Attached Product'),
            Tables\Columns\TextColumn::make('created_at')
                                     ->dateTime(),
        ])
                     ->filters([//
                     ])
                     ->actions([
                         Tables\Actions\ActionGroup::make([

                             Tables\Actions\EditAction::make()->color('success'),
                         ]),
                     ])
                     ->bulkActions([
                         Tables\Actions\DeleteBulkAction::make(),
                     ]);
    }

    public static function getRelations(): array
    {
        return [//
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIngredients::route('/'),
            'create' => Pages\CreateIngredient::route('/create'),
            'edit' => Pages\EditIngredient::route('/{record}/edit'),
        ];
    }
}
