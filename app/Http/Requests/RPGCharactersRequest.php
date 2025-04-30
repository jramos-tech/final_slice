<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RPGCharactersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_name' => 'required|max:255',
            'description' => 'required',
            'abilities' => 'required',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary',
            'skills' => 'array',
            'skills.*.name' => 'required|max:255',
            'skills.*.description' => 'required',
            'skills.*.power_level' => 'required|integer|min:1|max:100',
            'battles_won' => 'required|integer|min:0',
            'total_battles' => 'required|integer|min:0',
        ];
    }
}