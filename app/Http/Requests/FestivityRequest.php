<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class FestivityRequest extends Request
{
    /**
     * Get the validation rules that apply on update request.
     *
     * @return array
     */
    public function updateRules() : array
    {
        return [
            'name' => 'string|max:255',
            'place' => 'string|max:255',
            'start' => 'before:end|date_format:Y-m-d\TH:i:s.v\Z',
            'end' => 'after:start|date_format:Y-m-d\TH:i:s.v\Z',
        ];
    }

    /**
     * Get the validation rules that apply on store request.
     *
     * @return array
     */
    public function storeRules() : array
    {
        return [
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'start' => 'required|before:end|date_format:Y-m-d\TH:i:s.v\Z',
            'end' => 'required|after:start|date_format:Y-m-d\TH:i:s.v\Z',
        ];
    }

    /**
     * Get the validation rules that apply on batch store request.
     *
     * @return array
     */
    public function batchStoreRules() : array
    {
        return [
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'start' => 'required|before:resources.*.end|date_format:Y-m-d\TH:i:s.v\Z',
            'end' => 'required|after:resources.*.start|date_format:Y-m-d\TH:i:s.v\Z',
        ];
    }

    /**
     * Get the validation rules that apply on batch update request.
     *
     * @return array
     */
    public function batchUpdateRules() : array
    {
        return [
            'name' => 'string|max:255',
            'place' => 'string|max:255',
            'start' => 'before:resources.*.end|date_format:Y-m-d\TH:i:s.v\Z',
            'end' => 'after:resources.*.start|date_format:Y-m-d\TH:i:s.v\Z',
        ];
    }
}
