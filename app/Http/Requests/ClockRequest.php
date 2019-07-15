<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClockRequest extends FormRequest
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
        return [
            "name" => "required|max:100",
            "gender" => "required|in:men,women",
            "typeOfIndexation" => "required|in:strelochnye,cifrovye,strelochnyePlusCifrovye",
            "typeOfMechanism" => "required|in:quartz,mehanicheskie",
            "producer" => "required|max:50",
            "price" => "integer|nullable|min:0|max:999999",
            "oldPrice" => "integer|nullable|min:0|max:999999",
            "availability" => "required|in:yes,no,soon,byOrder",
            "hide" => "required|boolean",
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Незаповнене поле: Назва годинника',
            'name.max:100' => 'Перевищено максимальну кількість символів (100): Назва годинника',
            'gender.required' => 'Незаповнене поле: Стать',
            'gender.in' => 'Невідоме значення: Стать',
            'typeOfIndexation.required' => 'Незаповнене поле: Тип індексації',
            'typeOfIndexation.in' => 'Невідоме значення: Тип індексації',
            'typeOfMechanism.required' => 'Незаповнене поле: Тип механізму',
            'typeOfMechanism.in' => 'Невідоме значення: Тип механізму',
            'producer.required' => 'Незаповнене поле: Виробник',
            'producer.max:100' => 'Перевищено максимальну кількість символів (100): Виробник',
            'price.max' => 'Перевищено максимальне значення (999999): Ціна',
            'oldPrice.max' => 'Перевищено максимальне значення (999999): Стара ціна',
            'availability.required' => 'Незаповнене поле: Навність',
            'availability.in' => 'Невідоме значення: Навність',
            'hide.required' => 'Незаповнене поле: Приховати',
            'hide.boolean' => 'Невідоме значення: Приховати',
        ];
    }
}
