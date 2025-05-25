<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemRequest;
use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return TodoItem::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoItemRequest $todoItemRequest)
    {
       if($todoItemRequest->save()){

           return response()->json([
           "status" => "success",
           "message" => "Todo created successfully"
         ]);
        }
        return response()->json([
        "status" => "fail",
        "message" => "Todo not saved successfully"
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoItem $todoItem)
    {
      return $todoItem;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoItem $todoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoItemRequest $todoItemRequest)
    {
        if($todoItemRequest->save()){

           return response()->json([
           "status" => "success",
           "message" => "Todo updated successfully"
         ]);
        }
        return response()->json([
        "status" => "fail",
        "message" => "Todo not updated successfully"
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoItem $todoItem)
    {
      if($todoItem->delete()){

           return response()->json([
           "status" => "success",
           "message" => "Todo deleted successfully"
         ]);
        }
        return response()->json([
        "status" => "fail",
        "message" => "Todo not deleted successfully"
      ]);
    }
}
