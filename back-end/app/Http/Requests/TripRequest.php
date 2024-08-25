<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'data_inizio' => 'required|after_or_equal:today',
            'data_fine' => 'nullable|after_or_equal:data_inizio',
            'destinazione' => 'required|string|max:255',
            'immagine' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Il nome è obbligatorio.',
            'nome.string' => 'Il nome deve essere una stringa.',
            'nome.max' => 'Il nome non può superare i 255 caratteri.',
            'descrizione.required' => 'La descrizione è obbligatoria.',
            'descrizione.string' => 'La descrizione deve essere una stringa.',
            'data_inizio.required' => 'La data d\'inizio e\'obbligatoria.',
            'data_inizio.after_or_equal' => 'La data di inizio deve essere uguale o prima della data di fine.',
            'data_fine.after_or_equal' => 'La data di fine deve essere uguale o successiva alla data di inizio.',
            'destinazione.required' => 'La destinazione è obbligatorio.',
            'destinazione.string' => 'La destinazione deve essere una stringa.',
            'destinazione.max' => 'La destinazione non può superare i 255 caratteri.',
            'immagine.image' => 'Il file caricato deve essere un\'immagine.',
            'immagine.mimes' => 'Il formato dell\'immagine deve essere JPEG, PNG, JPG.',
            'immagine.max' => 'La dimensione massima consentita per l\'immagine è 2MB.',
        ];
    }
}
