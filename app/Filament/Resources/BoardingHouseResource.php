<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Str;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Informasi Umum')
                            ->schema([
                                forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('boarding_house')
                                    ->required(),
                                forms\Components\TextInput::make('name')
                                    ->required()
                                    ->debounce(500)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                forms\Components\TextInput::make('slug')
                                    ->required(),
                                forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->required(),
                                forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required(),
                                forms\Components\RichEditor::make('description')
                                    ->required(),
                                forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->required(),
                                forms\Components\Textarea::make('address')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('Tab 2')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Tab 3')
                            ->schema([
                                // ...
                            ]),
                    ])->columnSpan(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
