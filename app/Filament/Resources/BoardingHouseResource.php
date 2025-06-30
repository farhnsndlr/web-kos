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
                                forms\Components\FileUpload::make('thumbnail')
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
                        Tabs\Tab::make('Bonus')
                            ->schema([
                                forms\Components\Repeater::make('bonuses')
                                    ->relationship('bonuses')
                                    ->schema([
                                        forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('bonuses')
                                            ->required(),
                                        forms\Components\TextInput::make('name')
                                            ->required(),
                                        forms\Components\TextInput::make('description')
                                            ->required(),
                                    ])
                            ]),
                        Tabs\Tab::make('Rooms')
                            ->schema([
                                forms\Components\Repeater::make('rooms')
                                    ->relationship('rooms')
                                    ->schema([
                                        forms\Components\TextInput::make('name')
                                            ->required(),
                                        forms\Components\TextInput::make('room_type')
                                            ->required(),
                                        forms\Components\TextInput::make('square_feet')
                                            ->numeric()
                                            ->required(),
                                        forms\Components\TextInput::make('capacity')
                                            ->numeric()
                                            ->required(),
                                        forms\Components\TextInput::make('price_per_month')
                                            ->numeric()
                                            ->prefix('IDR')
                                            ->required(),
                                        forms\Components\Toggle::make('is_available')
                                            ->required(),
                                        forms\Components\Repeater::make('images')
                                            ->relationship('images')
                                            ->schema([
                                                forms\Components\FileUpload::make('image')
                                                    ->image()
                                                    ->directory('rooms')
                                                    ->required(),
                                            ])
                                    ])
                            ]),
                    ])->columnSpan(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\ImageColumn::make('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
