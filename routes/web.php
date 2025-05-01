<?php

use App\Models\RPGCharacters;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BattleController;

Route::get('/', function () {
    return redirect()->route('characters.index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required|max:255|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $data['email'])->first();

    if ($user && password_verify($data['password'], $user->password)) {
        session(['user_id' => $user->id, 'user_name' => $user->username]);

        return redirect()->route('characters.index')
            ->with('success', 'Login successful. Welcome back, ' . $user->username . '!');
    } else {
        return redirect()->route('login')
            ->withErrors(['email' => 'Invalid email or password.']);
    }
})->name('login.go');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|max:50',
        'email' => 'required|max:255|email',
        'password' => 'required'
    ]);

    $user = User::where('username', $data['username'])->first();
    if ($user) {
        return redirect()->back()->withErrors(['username' => 'Username already taken']);
    } else {
        $user = new User;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
    }
    return redirect()->route('login')
        ->with("success", 'User registered successfully. Please login to continue.');
})->name('register.save');

Route::get('/characters', function () {
    return view('index', [
        'characters' => RPGCharacters::with('user')->latest()->get()
    ]);
})->name('characters.index');

Route::get('/create', function () {
    return view('create');
})->name('characters.create');

Route::get('/battle', [BattleController::class, 'index'])->name('characters.battle');
Route::post('/battle/fight', [BattleController::class, 'fight'])->name('characters.battle.fight');

Route::get('/characters/{id}', function (RPGCharacters $id) {
    return view('show', [
        'character' => $id
    ]);
})->name('characters.show');

Route::post('/characters', function (Request $request) {
    $data = $request->validate([
        'class_name' => 'required|max:255',
        'description' => 'required',
        'abilities' => 'required',
        'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary',
        'skills' => 'array',
        'skills.*.name' => 'required|max:255',
        'skills.*.description' => 'required',
        'skills.*.power_level' => 'required|integer',
    ]);

    $userId = session('user_id');
    if (!$userId) {
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to create a character.']);
    }

    $character = new RPGCharacters;
    $character->class_name = $data['class_name'];
    $character->description = $data['description'];
    $character->abilities = $data['abilities'];
    $character->rarity = $data['rarity'];
    $character->battles_won = 0;
    $character->total_battles = 0;
    $character->user_id = $userId;
    $character->save();

    if (isset($data['skills'])) {
        foreach ($data['skills'] as $skillData) {
            $character->skills()->create($skillData);
        }
    }

    return redirect()->route('characters.show', ['id' => $character->id])
        ->with("success", 'Character class created successfully');
})->name('characters.store');

Route::get('/account', function () {
    $userId = session('user_id');
    if (!$userId) {
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this page.']);
    }

    $characters = RPGCharacters::where('user_id', $userId)->get();

    return view('account', [
        'characters' => $characters
    ]);
})->name('account');

Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('characters.index')->with('success', 'You have been logged out.');
})->name('logout');

Route::delete('/characters/{id}', function ($id) {
    $userId = session('user_id');
    if (!$userId) {
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to delete a character.']);
    }

    $character = RPGCharacters::where('id', $id)->where('user_id', $userId)->first();
    if ($character) {
        $character->delete();
        return redirect()->route('account')->with('success', 'Character deleted successfully.');
    }

    return redirect()->route('account')->withErrors(['error' => 'Character not found or you do not have permission to delete it.']);
})->name('characters.delete');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function(){
//     return 'Hello';
// })->name('hello');

// Route::get("/hallo", function(){
//     return redirect('/here', '/there');
// });

// Route::fallback(function () {
// });

// class Task{
//     public function __construct(
//         public int $id,
//         public string $title,
//         public string $description
//         public string $long_description
//     ){

//     }
// }
// $tasks = [
//     new Task(
//         1,
//         "Buy stuff",
//         "Lots of stuff"
//     ),
//     new Task(
//         2,
//         "Rent stuff",
//         "Rent lots of stuff"
//     )
// ];

// Route::get('/', function () use ($tasks){
//     return view('index', [
//         'tasks' => $tasks
//     ]);
// })-name('tasks.index');

// Rouet::get('/tasks', function(){
//     return view('index', [
//         'tasks' => \App\Models\Task::latest()->get()
//     ]);
// })-name('tasks.index');

// ROute::get('/tasks/{id}', function($id){
//     return view('show', [
//         'task' => \App\Models\Task::findOrFail($id)
//     ]);
// })->name('tasks.show');

