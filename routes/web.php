<?php

use App\Models\RPGCharacters;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return redirect()->route('characters.index');
});

Route::get('/characters', function () {
    return view('index', [
        'characters' => RPGCharacters::latest()->get()
    ]);
})->name('characters.index');

Route::get('/create', function () {
    return view('create');
})->name('characters.create');

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

    $character = new RPGCharacters;
    $character->class_name = $data['class_name'];
    $character->description = $data['description'];
    $character->abilities = $data['abilities'];
    $character->rarity = $data['rarity']; 
    $character->save();

    foreach ($data['skills'] as $skillData) {
        $character->skills()->create($skillData);
    }

    return redirect()->route('characters.show', ['id' => $character->id])
        ->with("success", 'Character class created successfully');
})->name('characters.store');

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

