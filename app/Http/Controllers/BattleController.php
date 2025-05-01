<?php
namespace App\Http\Controllers;

use App\Models\RPGCharacters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BattleController extends Controller
{
    public function index()
    {
        $characters = RPGCharacters::all();
        return view('battle', compact('characters'));
    }

    public function fight(Request $request)
    {
        $data = $request->validate([
            'character1_id' => 'required|exists:r_p_g_characters,id',
            'character2_id' => 'required|exists:r_p_g_characters,id|different:character1_id',
        ]);

        $character1 = RPGCharacters::findOrFail($data['character1_id']);
        $character2 = RPGCharacters::findOrFail($data['character2_id']);

        // Get battle result
        $battleResult = $this->determineBattleResult($character1, $character2);
        
        // Log battle result for debugging
        Log::info('Battle result: ' . json_encode($battleResult['is_tie']));
        
        // Update battle statistics
        $character1->increment('total_battles');
        $character2->increment('total_battles');
        
        // If there's a winner (not a tie), increment their win count
        if ($battleResult['is_tie'] === false) {
            $battleResult['winner']->increment('battles_won');
        }

        // Prepare result message for view
        $battleResults = [];
        
        if ($battleResult['is_tie']) {
            // It's a tie
            $battleResults = [
                'winner' => 'It\'s a tie!',
                'loser' => null,
                'character1_power' => $character1->power_level,
                'character2_power' => $character2->power_level,
                'character1_name' => $character1->class_name,
                'character2_name' => $character2->class_name,
                'is_tie' => true
            ];
        } else {
            // We have a winner
            $battleResults = [
                'winner' => $battleResult['winner']->class_name,
                'loser' => $battleResult['loser']->class_name,
                'character1_power' => $character1->power_level,
                'character2_power' => $character2->power_level,
                'character1_name' => $character1->class_name,
                'character2_name' => $character2->class_name,
                'is_tie' => false
            ];
        }
        
        Log::info('Battle results sent to view: ' . json_encode($battleResults));

        return redirect()->route('characters.battle')->with('battleResults', $battleResults);
    }

    private function determineBattleResult($character1, $character2)
    {
        Log::info('Character 1 (' . $character1->class_name . ') Power Level: ' . $character1->power_level);
        Log::info('Character 2 (' . $character2->class_name . ') Power Level: ' . $character2->power_level);

        $character1Power = $character1->power_level;
        $character2Power = $character2->power_level;

        // Debug log to check exact values
        Log::info('Power comparison: ' . $character1Power . ' vs ' . $character2Power . ' | Equal: ' . ($character1Power === $character2Power ? 'Yes' : 'No'));

        if ($character1Power > $character2Power) {
            return [
                'winner' => $character1,
                'loser' => $character2,
                'is_tie' => false
            ];
        } elseif ($character1Power < $character2Power) {
            return [
                'winner' => $character2,
                'loser' => $character1,
                'is_tie' => false
            ];
        } else {
            // It's a tie
            Log::info('It\'s a tie between ' . $character1->class_name . ' and ' . $character2->class_name);
            return [
                'winner' => null,
                'loser' => null,
                'is_tie' => true
            ];
        }
    }
}