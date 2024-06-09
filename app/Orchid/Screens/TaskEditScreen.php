<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class TaskEditScreen extends Screen
{

    public $task;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Task $task
     *
     * @return array
     */
    public function query(Task $task): array
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->task->exists ? 'Редактирование заметки' : 'Cоздание новой заметки';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Заметки";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->task->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->task->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->task->exists),
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

    public function createOrUpdate(Request $request)
    {
        $this->task->fill($request->get('post'))->save();

        Alert::info('Вы успешно создали пост.');

        return redirect()->route('platform.task.list');
    }
    public function remove()
    {
        $this->task->delete();

        Alert::info('Вы успешно удалили пост.');

        return redirect()->route('platform.task.list');
    }
}
