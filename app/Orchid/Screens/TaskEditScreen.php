<?php

namespace App\Orchid\Screens;

use App\Models\Task;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;

class TaskEditScreen extends Screen
{

    public $task;

    /**
     * Fetch data to be displayed on the screen.
     *
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     *
     */
    public function name(): ?string
    {
        return $this->task->exists ? 'Редактирование заметки' : 'Cоздание новой заметки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create')
                ->icon('star')
                ->method('create')
                ->canSee(!$this->task->exists),

            Button::make('Save')
                ->icon('star')
                ->method('save')
                ->canSee($this->task->exists),

            Button::make('Remove')
                ->icon('star')
                ->confirm('Вы точно хотите удалить заметку?')
                ->method('remove')
                ->canSee($this->task->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('task.title')
                    ->title('Заметка')
                    ->required()
                    ->placeholder('Напишите заметку...'),

                Input::make('task.description')
                    ->title('Описание')
                    ->required()
                    ->placeholder('Напишите здесь текст заметки...'),

                CheckBox::make('task.completed')
                    ->sendTrueOrFalse()
                    ->title('Completed'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $task = new Task();
        $task->fill($request->get('task'));
        $task->save();
        return redirect()->route('platform.tasks');
    }

    public function save(Request $request)
    {
        $this->task->fill($request->get('task'));
        $this->task->save();
        return redirect()->route('platform.tasks');
    }
    public function remove()
    {
        $this->task->delete();
    }
}
