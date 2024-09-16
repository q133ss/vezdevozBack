<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnContoller\MoveRequest;
use App\Http\Requests\ColumnContoller\StoreRequest;
use App\Http\Requests\ColumnContoller\UpdateRequest;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Column::with('tasks')->orderBy('position')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['position'] = Column::max('position') ?? 1;

        return Column::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $column = Column::findOrFail($id);
        $data = $request->validated();
        $column->update($data);

        return $column;
    }

    public function move(MoveRequest $request, Column $column)
    {
        $data = $request->validated();

        $targetPosition = $data['target_position'];
        $currentPosition = $column->position;

        if ($targetPosition > $currentPosition) {
            Column::where('position', '>', $currentPosition)
                ->where('position', '<=', $targetPosition)
                ->decrement('position');
        } elseif ($targetPosition < $currentPosition) {
            Column::where('position', '<', $currentPosition)
                ->where('position', '>=', $targetPosition)
                ->increment('position');
        }

        $column->update(['position' => $targetPosition]);

        return response()->json(['message' => 'true']);
    }

    public function reorderTasks(Request $request, Column $column)
    {
        $tasks = $request->input('tasks');

        foreach ($tasks as $taskData) {
            $task = Task::find($taskData['id']);
            if ($task && $task->column_id == $column->id) {
                $task->position = $taskData['position'];
                $task->save();
            }
        }

        return response()->json(['message' => 'true']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Column::findOrFail($id)->delete();
        return response()->json(['message' => 'Колонка удалена']);
    }
}
