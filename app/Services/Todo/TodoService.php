<?php

namespace App\Services\Todo;
use App\Models\Todo;
use Exception;
use Illuminate\Support\Facades\DB;

class TodoService implements TodoInterface {

    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getTodos ($user_id)
    {
        $todos = DB::table('todos')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);
        if ( !$todos ){
            return response()->json(["error" => "We could not get the todo list for you!"], 400);
        }
        return response()->json($todos, 200);
    }

    public function getMyTodo ($user_id, $col_id)
    {
        $todo = $this->todo::where("user_id", $user_id)->where("id", $col_id)->first();
        if (!$todo) {
            return response()->json(['error' => 'Contact not found for you!'], 404);
        }
        return response()->json($todo, 200);
    }

    public function createTodo ($user_id, array $data)
    {
        $this->todo::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $user_id
        ]);
        return response()->json(['todo_created' => 'Todo successfully created!'], 201);
    }

    public function updateTodo ($user_id, $col_id, array $data)
    {
        $todo = $this->todo::where('id', $col_id)->where('user_id', $user_id)->first();
        if (!$todo) {
            return response()->json(['error' => 'We could not update the todo for you!'], 400);
        }
        $todo->update($data);
        return response()->json(['todo_updated' => 'Todo successfully updated!'], 201);
    }

    public function deleteTodo ($user_id, $col_id)
    {
        $todo = $this->todo::where('user_id', $user_id)->where('id', $col_id)->first();
        if(!$todo) {
            return response()->json(["error" => "We could not delete the the for you!"]);
        }
        $todo->delete();
        return response()->json(["todo_delete"=>"Todo successfully deleted!"], 201);
        
    }

    public function searchForTodo ($user_id, $data)
    {
        try {
            $todos = $this->todo::query()
            ->where('user_id', $user_id)
            ->where('title', 'LIKE', '%'."$data".'%')->get();
            return response()->json($todos, 200);
        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage());
        }
    }
}