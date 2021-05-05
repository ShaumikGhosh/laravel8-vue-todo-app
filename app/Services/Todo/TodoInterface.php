<?php

namespace App\Services\Todo;


interface TodoInterface 
{

    public function getTodos ($id);

    public function getMyTodo ($user_id, $col_id);

    public function createTodo ($user_id, array $data);

    public function updateTodo ($user_id, $col_id, array $data);

    public function deleteTodo ($user_id, $col_id);

    public function searchForTodo ($user_id, $data);
}