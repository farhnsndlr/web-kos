<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                forms\Components\TextInput::make('code')
                    ->required(),
                forms\Components\Select::make('boarding_house_id')
                    ->relationship('boardingHouse', 'name')
                    ->required(),
                forms\Components\Select::make('room_id')
                    ->relationship('room', 'name')
                    ->required(),
                forms\Components\TextInput::make('name')
                    ->required(),
                forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                forms\Components\TextInput::make('phone')
                    ->required(),
                forms\Components\Select::make('payment_method')
                    ->options([
                        'down_payment' => 'Down Payment',
                        'full_payment' => 'Full Payment',
                    ])
                    ->required(),
                forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])
                    ->required(),
                forms\Components\DatePicker::make('start_date')
                    ->required(),
                forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->required(),
                forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('IDR')
                    ->required(),
                forms\Components\DatePicker::make('transaction_date')
                    ->required(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
