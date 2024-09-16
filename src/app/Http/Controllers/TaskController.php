<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnContoller\MoveRequest;
use App\Http\Requests\TaskController\StoreRequest;
use App\Http\Requests\TaskController\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if($request->position == null)
        {
            $data['position'] = Task::max('position') + 1 ?? 1;
        }

        return Task::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->validated();
        $task->update($data);

        return $task;
    }

    public function move(MoveRequest $request, Task $task): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $targetPosition = $data['target_position'];
        $targetColumnId = $data['target_column_id'];
        $currentPosition = $task->position;
        $currentColumnId = $task->column_id;

        if ($currentColumnId == $targetColumnId) {
            if ($targetPosition > $currentPosition) {
                Task::where('column_id', $currentColumnId)
                    ->where('position', '>', $currentPosition)
                    ->where('position', '<=', $targetPosition)
                    ->decrement('position');
            } elseif ($targetPosition < $currentPosition) {
                Task::where('column_id', $currentColumnId)
                    ->where('position', '<', $currentPosition)
                    ->where('position', '>=', $targetPosition)
                    ->increment('position');
            }

            $task->update(['position' => $targetPosition]);

        } else {
            Task::where('column_id', $currentColumnId)
                ->where('position', '>', $currentPosition)
                ->decrement('position');

            Task::where('column_id', $targetColumnId)
                ->where('position', '>=', $targetPosition)
                ->increment('position');

            $task->update([
                'column_id' => $targetColumnId,
                'position' => $targetPosition
            ]);
        }

        return response()->json(['message' => 'true']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Задача удалена']);
    }
}
