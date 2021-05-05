<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Todo\TodoInterface;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    protected $todo;
    protected $request;

    public function __construct (TodoInterface $todo, Request $request)
    {
        $this->todo = $todo;
        $this->request = $request;
        $this->middleware('jwt.verify');
    }

    public function myTodos ()
    {
        return $this->todo->getTodos($this->request->user()->id);
    }

    public function getMyTodo ($col_id)
    {
        return $this->todo->getMyTodo(
            $this->request->user()->id, 
            $col_id
        );
    }

    public function createTodo ()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(
                $validator->errors(), 
                400
            );
        }

        return $this->todo->createTodo(
            $this->request->user()->id, 
            $this->request->all()
        );
    }

    public function updateTodo ($col_id)
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(
                $validator->errors(), 
                400
            );
        }
        return $this->todo->updateTodo(
            $this->request->user()->id, 
            $col_id, $this->request->all()
        );
    }

    public function deleteTodo ($col_id)
    {
        return $this->todo->deleteTodo(
            $this->request->user()->id, 
            $col_id
        );
    }

    public function searchForTodo ()
    {
        return $this->todo->searchForTodo($this->request->user()->id, $this->request->get('title'));
    }
}
