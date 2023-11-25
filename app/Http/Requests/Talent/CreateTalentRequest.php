<?php

namespace App\Http\Requests\Talent;
use Illuminate\Foundation\Http\FormRequest;

class CreateTalentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>>
     */
    public function rules(): array
    {
        return [
            'last'              => 'required|max:50',
            'first'             => 'required|max:50',
            'xp'                => 'integer',
            'tjm'               => 'integer',
            'address'           => [
                'address'           => 'max:255',
                'complementaddress' => 'max:255',
                'cp'                => 'max:255',
                'city'              => 'max:255',
                'country'           => 'max:255',
            ],
            'remote'            => 'boolean',
            'linkedin'          => 'max:255',
            'indicatifphone'    => 'max:255',
            'phone'             => 'max:255',
            'email'             => 'max:255',
        ];
    }
}
