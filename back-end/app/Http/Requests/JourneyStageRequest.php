<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JourneyStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'posizione' => 'required|string|max:255',
            'data' => 'nullable|after_or_equal:today',
            'ordine' => 'required|integer|min:0',
            'completata' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Il campo nome è obbligatorio.',
            'nome.string' => 'Il campo nome deve essere una stringa.',
            'nome.max' => 'Il campo nome non può superare i 255 caratteri.',
            'descrizione.string' => 'Il campo descrizione deve essere una stringa.',
            'posizione.required' => 'Il campo posizione è obbligatorio.',
            'posizione.string' => 'Il campo posizione deve essere una stringa.',
            'posizione.max' => 'Il campo posizione non può superare i 255 caratteri.',
            'data.after_or_equal' => 'Il campo data deve essere una data odierna o futura.',
            'ordine.required' => 'Il campo ordine è obbligatorio.',
            'ordine.integer' => 'Il campo ordine deve essere un numero intero.',
            'ordine.min' => 'Il campo ordine deve essere almeno 0.',
            'completata.boolean' => 'Il campo completata deve essere vero o falso.',
        ];
    }

}
