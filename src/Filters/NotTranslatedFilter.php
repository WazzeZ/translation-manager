<?php

namespace musa11971\FilamentTranslationManager\Filters;

use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class NotTranslatedFilter extends Filter
{
    public static function make(?string $name = null): static
    {
        return parent::make('not-translated')
            ->form([
                Select::make('lang')
                    ->label(__('filament-translation-manager::translations.filter-not-translated'))
                    ->options(collect(config('filament-translation-manager.available_locales'))->pluck('code', 'code')),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['lang'],
                        fn (Builder $query, $date): Builder => $query->whereNull('text->' . $data['lang'])
                    );
            });
    }
}