<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'العميل';
    protected static ?string $pluralLabel = 'العميل';
    protected static ?string $modelLabel = 'عميل';
    protected static ?string $navigationGroup = 'إدارة العملاء';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('اسم العميل')->required(),
                TextInput::make('email')->label('البريد الإلكتروني')->email(),
                TextInput::make('phone')->label('رقم الهاتف'),
                TextInput::make('whatsapp')->label('رقم الواتساب'),
                TextInput::make('company')->label('اسم الشركة'),
                TextInput::make('project_name')->label('اسم المشروع'),
                Textarea::make('project_description')->label('نبذة عن المشروع'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable(),
                TextColumn::make('email')->label('الإيميل'),
                TextColumn::make('phone')->label('الهاتف'),
                TextColumn::make('company')->label('الشركة'),
                TextColumn::make('project_name')->label('المشروع'),
                TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
