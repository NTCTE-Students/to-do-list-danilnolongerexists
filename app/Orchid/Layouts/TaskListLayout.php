<?php

namespace App\Orchid\Layouts;

use App\Models\Task;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class TaskListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', 'Title')
            ->render(function (Task $task) {
                return Link::make($task->title)
                    ->route('platform.task.edit', ['task' => $task -> id]);
            }),

        TD::make('created_at', 'Created'),
        TD::make('updated_at', 'Last edit'),
        ];
    }
}
