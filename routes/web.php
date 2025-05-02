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
    $email = User::where('email', $data['email'])->first();
    if ($user) {
        return redirect()->back()->withErrors(['username' => 'Username already taken']);
    } elseif ($email) {
        return redirect()->back()->withErrors(['email' => 'Email already taken']);
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
    return view('index');
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
        'image' => 'nullable|url',
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
    $character->image = $data['image'];
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

Route::get('/characters/{id}/edit', function ($id) {
    $userId = session('user_id');
    if (!$userId) {
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to edit a character.']);
    }

    $character = RPGCharacters::where('id', $id)->where('user_id', $userId)->first();
    if (!$character) {
        return redirect()->route('account')->withErrors(['error' => 'Character not found or you do not have permission to edit it.']);
    }

    return view('edit', [
        'character' => $character
    ]);
})->name('characters.edit');

Route::put('/characters/{id}', function (Request $request, $id) {
    $data = $request->validate([
        'class_name' => 'required|max:255',
        'description' => 'required',
        'abilities' => 'required',
        'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary',
        'image' => 'nullable|url',
        'skills' => 'array',
        'skills.*.name' => 'required|max:255',
        'skills.*.description' => 'required',
        'skills.*.power_level' => 'required|integer',
    ]);

    $character = RPGCharacters::findOrFail($id);
    $character->update($data);

    foreach ($data['skills'] as $skillData) {
        $character->skills()->updateOrCreate(
            ['id' => $skillData['id'] ?? null],
            $skillData
        );
    }

    return redirect()->route('characters.show', $character->id)
        ->with('success', 'Character updated successfully.');
})->name('characters.update');

Route::get('/api/characters', function (Request $request) {
    $sortField = $request->query('sort', 'class_name');
    $sortOrder = $request->query('order', 'asc');

    $validFields = ['class_name', 'battles_won', 'rarity', 'power_level'];
    $validOrders = ['asc', 'desc'];

    if (!in_array($sortField, $validFields) || !in_array($sortOrder, $validOrders)) {
        return response()->json(['error' => 'Invalid sort field or order'], 400);
    }

    if ($sortField === 'rarity') {
        $rarityOrder = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'];
        $characters = RPGCharacters::with('user')
            ->orderByRaw("FIELD(rarity, '" . implode("','", $rarityOrder) . "') " . strtoupper($sortOrder))
            ->get();
    } elseif ($sortField === 'power_level') {
        $characters = RPGCharacters::with('user')
            ->leftJoin('skills', 'r_p_g_characters.id', '=', 'skills.rpg_character_id') // Correct table name
            ->select('r_p_g_characters.*', \DB::raw('SUM(skills.power_level) as total_power_level'))
            ->groupBy('r_p_g_characters.id')
            ->orderBy('total_power_level', $sortOrder)
            ->get();
    } else {
        $characters = RPGCharacters::with('user')
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    return response()->json($characters);
})->name('api.characters');
