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

    'accepted'             => 'O campo acima deve ser aceito.',
    'active_url'           => 'O campo acima não é uma URL válida.',
    'after'                => 'O campo acima deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O campo acima deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo acima só pode conter letras.',
    'alpha_dash'           => 'O campo acima só pode conter letras, números e traços.',
    'alpha_num'            => 'O campo acima só pode conter letras e números.',
    'array'                => 'O campo acima deve ser uma matriz.',
    'before'               => 'O campo acima deve ser uma data anterior :date.',
    'before_or_equal'      => 'O campo acima deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo acima deve ser entre :min e :max.',
        'file'    => 'O campo acima deve ser entre :min e :max kilobytes.',
        'string'  => 'O campo acima deve ser entre :min e :max caracteres.',
        'array'   => 'O campo acima deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo acima deve ser verdadeiro ou falso.',
    'confirmed'            => 'O campo acima de confirmação não confere.',
    'date'                 => 'O campo acima não é uma data válida.',
    'date_format'          => 'O campo acima não corresponde ao formato :format.',
    'different'            => 'Os campos acima e :other devem ser diferentes.',
    'digits'               => 'O campo acima deve ter :digits dígitos.',
    'digits_between'       => 'O campo acima deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O campo acima tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo acima campo tem um valor duplicado.',
    'email'                => 'O campo acima deve ser um endereço de e-mail válido.',
    'exists'               => 'O campo acima selecionado é inválido.',
    'file'                 => 'O campo acima deve ser um arquivo.',
    'filled'               => 'O campo acima deve ter um valor.',
    'image'                => 'O campo acima deve ser uma imagem.',
    'in'                   => 'O campo acima selecionado é inválido.',
    'in_array'             => 'O campo acima não existe em :other.',
    'integer'              => 'O campo acima deve ser um número inteiro.',
    'ip'                   => 'O campo acima deve ser um endereço de IP válido.',
    'ipv4'                 => 'O campo acima deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O campo acima deve ser um endereço IPv6 válido.',
    'json'                 => 'O campo acima deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => 'O campo acima não pode ser superior a :max.',
        'file'    => 'O campo acima não pode ser superior a :max kilobytes.',
        'string'  => 'O campo acima não pode ser superior a :max caracteres.',
        'array'   => 'O campo acima não pode ter mais do que :max itens.',
    ],
    'mimes'                => 'O campo acima deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O campo acima deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo acima deve ser pelo menos :min.',
        'file'    => 'O campo acima deve ter pelo menos :min kilobytes.',
        'string'  => 'O campo acima deve ter pelo menos :min caracteres.',
        'array'   => 'O campo acima deve ter pelo menos :min itens.',
    ],
    'not_in'               => 'O campo acima selecionado é inválido.',
    'numeric'              => 'O campo acima deve ser um número.',
    'present'              => 'O campo acima deve estar presente.',
    'regex'                => 'O campo acima tem um formato inválido.',
    'required'             => 'O campo acima é obrigatório.',
    'required_if'          => 'O campo acima é obrigatório quando :other for :value.',
    'required_unless'      => 'O campo acima é obrigatório exceto quando :other for :values.',
    'required_with'        => 'O campo acima é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo acima é obrigatório quando :values está presente.',
    'required_without'     => 'O campo acima é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo acima é obrigatório quando nenhum dos :values estão presentes.',
    'same'                 => 'Os campos acima e :other devem corresponder.',
    'size'                 => [
        'numeric' => 'O campo acima deve ser :size.',
        'file'    => 'O campo acima deve ser :size kilobytes.',
        'string'  => 'O campo acima deve ser :size caracteres.',
        'array'   => 'O campo acima deve conter :size itens.',
    ],
    'string'               => 'O campo acima deve ser uma string.',
    'timezone'             => 'O campo acima deve ser uma zona válida.',
    'unique'               => 'O campo acima já está sendo utilizado.',
    'uploaded'             => 'Ocorreu uma falha no upload do campo acima.',
    'url'                  => 'O campo acima tem um formato inválido.',

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

    'custom' => [],

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

    'attributes' => [
        'location_id' => 'Local de realização',
        'title'       => 'Título',
        'description' => 'Descrição',
        'category_id' => 'Categoria'
    ],

];