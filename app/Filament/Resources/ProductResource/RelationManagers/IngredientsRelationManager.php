<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;

class IngredientsRelationManager extends RelationManager
{
    protected static string $relationship = "ingredients";

    protected static ?string $recordTitleAttribute = "name";

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make("name"),
            Tables\Columns\TextColumn::make('grams_quantity')
                                     ->suffix('G')
                                     ->description(fn($record): string => $record->pivot->grams_quantity / 1000 .' KG',
                                         position: 'above'),
        ])
                     ->filters([])
                     ->headerActions([
                         Tables\Actions\AttachAction::make()
                                                    ->label("Attach New Ingredient")
                                                    ->form(fn(AttachAction $action): array => [
                                                        $action->getRecordSelect()
                                                               ->disableLabel(false)
                                                               ->label("Select ingredient"),
                                                        Forms\Components\TextInput::make("grams_quantity")
                                                                                  ->required(),
                                                    ]),
                     ])
                     ->actions([
                         Tables\Actions\DetachAction::make(),
                         Tables\Actions\EditAction::make()
                                                  ->form(fn(Tables\Actions\EditAction $action): array => [
                                                      Forms\Components\TextInput::make("grams_quantity")
                                                                                ->required()
                                                                                ->numeric(),
                                                  ]),
                     ])
                     ->bulkActions([]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }
}
