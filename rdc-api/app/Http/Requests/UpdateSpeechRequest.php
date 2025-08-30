<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpeechRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'sometimes|required|string',
            'category_id' => 'nullable|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'speech_date' => 'sometimes|required|date',
            'speech_time' => 'nullable|date_format:H:i',
            'audio_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'youtube_id' => 'nullable|string|max:20',
            'duration' => 'nullable|integer|min:1',
            'metadata' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'content.required' => 'Le contenu est obligatoire.',
            'speech_date.required' => 'La date du discours est obligatoire.',
            'speech_date.date' => 'La date du discours doit être une date valide.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'audio_url.url' => 'L\'URL audio doit être valide.',
            'video_url.url' => 'L\'URL vidéo doit être valide.',
        ];
    }
}