<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ' :attribute должен быть принят.',
    'active_url' => ' :attribute не является допустимым URL-адресом.',
    'after' => ' :attribute должен быть датой после :date.',
    'after_or_equal' => ' :attribute должен быть датой после или равной дате.',
    'alpha' => ' :attribute может содержать только буквы.',
    'alpha_dash' => ' :attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => ' :attribute может содержать только буквы и цифры.',
    'array' => ' :attribute должен быть массивом.',
    'before' => ' :attribute должен быть датой перед :date.',
    'before_or_equal' => ' :attribute должен быть датой до или равной дате.',
    'between' => [
        'numeric' => ' :attribute должен находиться в диапазоне от :min до :max.',
        'file' => ' :attribute должен находиться в диапазоне от :min до :max килобайт.',
        'string' => ' :attribute должен содержать символы :min и :max.',
        'array' => ' :attribute должен содержать от :min до :max элементов.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'date' => ' :attribute не является допустимой датой.',
    'date_equals' => ' :attribute должен быть датой, равной :date.',
    'date_format' => ' :attribute не соответствует формату:format.',
    'different' => ' :attribute attribute и :other должны отличаться.',
    'digits' => ' :attribute должен быть :digits цифрами.',
    'digits_between' => ' :attribute должен быть между :min и :max цифрами.',
    'dimensions' => ' :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'email' => ' :attribute должен быть действующим адресом электронной почты.',
    'ends_with' => ' :attribute должен заканчиваться одним из следующих: :values.',
    'exists' => 'Выбранный :attribute недействителен.',
    'file' => ' :attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'numeric' => ' :attribute должен быть больше, чем :value.',
        'file' => ' :attribute должен быть больше :value в килобайтах.',
        'string' => ' :attribute должен содержать больше символов :value.',
        'array' => ' :attribute должен содержать более :values элементов.',
    ],
    'gte' => [
        'numeric' => ' :attribute должен быть больше или равен :value.',
        'file' => ' :attribute должен быть больше или равен :value в килобайтах.',
        'string' => ' :attribute должен быть больше или равен символам :value.',
        'array' => ' :attribute должен иметь элементы :value или больше.',
    ],
    'image' => ' :attribute должен быть изображением.',
    'in' => 'Атрибут selected: недействителен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ' :attribute должен быть целым числом.',
    'ip' => ' :attribute должен быть действительным IP-адресом.',
    'ipv4' => ' :attribute должен быть действительным IPv4-адресом.',
    'ipv6' => ' :attribute должен быть действительным адресом IPv6.',
    'json' => ' :attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => ' :attribute должен быть меньше :value.',
        'file' => ' :attribute должен быть меньше :value килобайт.',
        'string' => ' :attribute должен содержать меньше символов :value.',
        'array' => ' :attribute должен содержать меньше :values элементов.',
    ],
    'lte' => [
        'numeric' => ' :attribute должен быть меньше или равен :value.',
        'file' => ' :attribute должен быть меньше или равен :value в килобайтах.',
        'string' => ' :attribute должен быть меньше или равен символам :value.',
        'array' => ' :attribute не может содержать более :values элементов.',
    ],
    'max' => [
        'numeric' => ' :attribute не может быть больше, чем :max.',
        'file' => ' :attribute не может быть больше :max килобайт.',
        'string' => ' :attribute не может содержать больше символов :max.',
        'array' => ' :attribute не может содержать более :max элементов.',
    ],
    'mimes' => ' :attribute должен быть файлом типа: :values.',
    'mimetypes' => ' :attribute должен быть файлом типа: :values.',
    'min' => [
        'numeric' => ' :attribute должен быть не меньше: мин.',
        'file' => ' :attribute должен быть не меньше :min килобайт.',
        'string' => ' :attribute должен содержать не менее :min символов.',
        'array' => ' :attribute должен содержать как минимум :min элементов.',
    ],
    'multiple_of' => ' :attribute должен быть кратным :value.',
    'not_in' => 'Атрибут selected: недействителен.',
    'not_regex' => 'Формат :attribute недействителен.',
    'numeric' => ' :attribute должен быть числом.',
    'password' => 'Пароль неверен.',
    'present' => 'Поле :attribute должно присутствовать.',
    'regex' => 'Формат :attribute недействителен.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_if' => 'Поле :attribute необходимо, когда :other :value.',
    'required_unless' => 'Поле :attribute является обязательным, если :other не входит в :values.',
    'required_with' => 'Поле :attribute является обязательным, если присутствует :values.',
    'required_with_all' => 'Поле :attribute является обязательным, если присутствуют :value.',
    'required_without' => 'Поле :attribute является обязательным, если :values ​​отсутствует.',
    'required_without_all' => 'Поле :attribute является обязательным, если нет ни одного из :values.',
    'same' => ' :attribute attribute и :other должны совпадать.',
    'size' => [
        'numeric' => ' :attribute должен быть размером :size.',
        'file' => ' :attribute должен быть размером в килобайтах.',
        'string' => ' :attribute должен содержать символы :size.',
        'array' => ' :attribute должен содержать элементы :size.',
    ],
    'starts_with' => ' :attribute должен начинаться с одного из следующих: :values.',
    'string' => ' :attribute должен быть строкой.',
    'timezone' => ' :attribute должен быть допустимой зоной.',
    'unique' => ' :attribute уже занят.',
    'uploaded' => ' :attribute не удалось загрузить.',
    'url' => 'Формат :attribute недействителен.',
    'uuid' => ' :attribute должен быть действительным UUID.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
