<?php

namespace LaravelEnso\MonitoredEmails\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelEnso\MonitoredEmails\Enums\Protocol;

class ValidateMonitoredEmail extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'nullable|string|max:6', 
            'protocol' => ['required', Rule::enum(Protocol::class)],
            'is_active' => 'required|boolean',
        ];
    }
}
