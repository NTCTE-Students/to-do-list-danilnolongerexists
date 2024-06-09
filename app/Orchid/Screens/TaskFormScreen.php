<?php

namespace App\Orchid\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Quill;
use App\Models\User;
use Orchid\Screen\Fields\Relation;


class TaskFormScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание заметки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать')
            ->icon('paper-plane')
            ->method('createTask'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('task')
                    ->title('Заметка')
                    ->required()
                    ->placeholder('Напишите заметку...'),

                Quill::make('content')
                    ->title('Описание')
                    ->required()
                    ->placeholder('Напишите здесь текст заметки...')
            ])
        ];
    }

    public function createTask(Request $request)
    {
        $request->validate([
            'task' => 'required|min:1|max:100',
            'content' => 'required|min:1|max:100'
        ]);

        Alert::info('Ваша заметка создана.');
    }
}
