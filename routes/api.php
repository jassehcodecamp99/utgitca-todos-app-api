<?php

use App\Http\Controllers\TodoItemController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
     $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string',
    ]);

    $user = User::whereEmail($request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        $token = $user->createToken($user->email);
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token->plainTextToken,
        ]);
    }
    return response()->json(['message' => 'Invalid credentials'], 401);
});

Route::prefix('/todo-items')->middleware('auth:sanctum')->controller(TodoItemController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store')->name('todo-items');
    // Route::get('/show', 'show')->name('todo-items.show');
    Route::post('/update/{todoItem}', 'update')->name('todo-items.update');
    Route::delete('/destroy/{todoItem}', 'destroy')->name('todo-items.destroy');
});


Route::post('/register', function (Request $request) {
    // return "ddgdgd";
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create($validatedData);

    if ($user) {
        $user->password = Hash::make($request->password);
        $user->save();
    } else {
        return response()->json(['message' => 'User registration failed'], 500);
    }

    return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    
});

Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully']);
})->middleware('auth:sanctum');



Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
})->middleware('auth:sanctum');

