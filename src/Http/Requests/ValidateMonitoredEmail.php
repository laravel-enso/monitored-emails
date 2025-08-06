<?php

namespace LaravelEnso\MonitoredEmails\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateMonitoredEmail extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
