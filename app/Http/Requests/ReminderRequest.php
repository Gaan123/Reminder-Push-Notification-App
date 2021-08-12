<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data=[
            'notification' => $this->input('notification') ? 1 : 0
        ];
        if (!$this->input('id')) {
            $data=[
                'user_id' => auth()->id(),
                'notification' => $this->input('notification') ? 1 : 0
            ];
        }else{
            $data=[
                'notification' => $this->input('notification')==1 ? 1 : 0
            ];
        }
        $this->merge($data);
        return [
            'name'=>'required|min:5|max:255',
            'reminder_time'=>'required',
        ];
    }

}
