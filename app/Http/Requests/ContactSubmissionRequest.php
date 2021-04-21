<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ContactSubmissionRequest
 * @package App\Http\Requests
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 */
class ContactSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'email' => "string",
        'phone' => "string",
        'message' => "string",
        'subscribe' => "string"
    ])] public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required_without:phone|email',
            'phone' => 'nullable',
            'message' => 'required',
            'subscribe' => 'nullable|boolean'
        ];
    }
}
