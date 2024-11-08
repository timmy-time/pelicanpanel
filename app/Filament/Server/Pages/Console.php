<?php

namespace App\Filament\Server\Pages;

use App\Filament\Server\Widgets\ServerConsole;
use App\Filament\Server\Widgets\ServerCpuChart;
use App\Filament\Server\Widgets\ServerMemoryChart;
use App\Filament\Server\Widgets\ServerNetworkChart;
use App\Filament\Server\Widgets\ServerOverview;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class Console extends Page
{
    protected static ?string $navigationIcon = 'tabler-brand-tabler';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.server.pages.console';

    public function getWidgetData(): array
    {
        return [
            'server' => Filament::getTenant(),
            'user' => auth()->user(),
        ];
    }

    public function getWidgets(): array
    {
        return [
            ServerOverview::class,
            ServerConsole::class,
            ServerCpuChart::class,
            ServerMemoryChart::class,
            ServerNetworkChart::class,
        ];
    }

    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    public function getColumns(): int|string|array
    {
        return 3;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('start')
                ->color('primary')
                ->action(fn () => $this->dispatch('setServerState', state: 'start')),

            Action::make('restart')
                ->color('gray')
                ->action(fn () => $this->dispatch('setServerState', state: 'restart')),

            Action::make('stop')
                ->color('danger')
                ->action(fn () => $this->dispatch('setServerState', state: 'stop')),
        ];
    }
}