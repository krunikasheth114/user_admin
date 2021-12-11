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

    'accepted' => 'L attribut : doit être accepté.',
    'accepted_if' => 'Le :attribute doit être accepté lorsque :other vaut :value.',
    'active_url' => 'Le :attribute n est pas une URL valide.',
    'after' => 'Le :attribute doit être une date postérieure à :date.',
    'after_or_equal' => 'Le :attribute doit être une date postérieure ou égale à :date.',
    'alpha' => 'Le :attribute ne doit contenir que des lettres.',
    'alpha_dash' => 'Le :attribute ne doit contenir que des lettres, des chiffres, des tirets et des traits de soulignement.',
    'alpha_num' => 'Le :attribute ne doit contenir que des lettres et des chiffres.',
    'array' => 'Le :attribute doit être un tableau.',
    'before' => 'Le :attribute doit être une date antérieure à :date.',
    'before_or_equal' => 'Le :attribute doit être une date antérieure ou égale à :date.',
    'between' => [
        'numeric' => 'Le :attribute doit être compris entre :min et :max.',
        'file' => 'Le :attribute doit être compris entre :min et :max kilo-octets.',
        'string' => 'Le :attribute doit être compris entre les caractères :min et :max.',
        'array' => 'Le :attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le :attribute n est pas une date valide.',
    'date_equals' => 'Le :attribute doit être une date égale à :date.',
    'date_format' => 'Le :attribute ne correspond pas au format :format.',
    'different' => 'Le :attribute et :other doivent être différents.',
    'digits' => 'Le :attribute doit être :digits digits.',
    'digits_between' => 'Le :attribute doit être compris entre :min et :max chiffres.',
    'dimensions' => 'Le :attribute a des dimensions d0 image non valides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'email' => 'Le :attribute doit être une adresse e-mail valide.',
    'ends_with' => 'Le :attribute doit se terminer par l un des éléments suivants : :values.',
    'exists' => 'Le :attribut sélectionné n est pas valide.',
    'file' => 'Le :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'numeric' => 'Le :attribute doit être supérieur à :value.',
        'file' => 'Le :attribute doit être supérieur à :value kilo-octets.',
        'string' => 'Le :attribute doit être supérieur aux caractères :value.',
        'array' => 'Le :attribute doit avoir plus de :value éléments.',
    ],
    'gte' => [
        'numeric' => 'Le :attribute doit être supérieur ou égal à :value.',
        'file' => 'Le :attribute doit être supérieur ou égal à :value kilo-octets.',
        'string' => 'Le :attribute doit être supérieur ou égal aux caractères :value.',
        'array' => 'Le :attribute doit avoir des éléments :value ou plus.',
    ],
    'image' => 'Le :attribute doit être une image.',
    'in' => 'Le :attribut sélectionné n est pas valide.',
    'in_array' => 'Le champ :attribute n existe pas dans :other.',
    'integer' => 'Le :attribute doit être un entier.',
    'ip' => 'Le :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => 'Le :attribute doit être inférieur à :value.',
        'file' => 'Le :attribute doit être inférieur à :value kilo-octets.',
        'string' => 'Le :attribute doit être inférieur aux caractères :value.',
        'array' => 'Le :attribute doit avoir moins d éléments :value.',
    ],
    'lte' => [
        'numeric' => 'Le :attribute doit être inférieur ou égal à :value.',
        'file' => 'Le :attribute doit être inférieur ou égal à :value kilo-octets.',
        'string' => 'Le :attribute doit être inférieur ou égal aux caractères :value.',
        'array' => 'Le :attribute ne doit pas avoir plus de :value éléments.',
    ],
    'max' => [
        'numeric' => 'Le :attribute ne doit pas être supérieur à :max.',
        'file' => 'Le :attribute ne doit pas être supérieur à :max kilo-octets.',
        'string' => 'Le :attribute ne doit pas être supérieur à :max caractères.',
        'array' => 'Le :attribute ne doit pas contenir plus de :max éléments.',
    ],
    'mimes' => 'Le :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file' => 'L attribut :attribut doit être d au moins :min kilo-octets.',
        'string' => 'Le :attribute doit contenir au moins :min caractères.',
        'array' => 'Le :attribute doit avoir au moins des éléments :min.',
    ],
    'multiple_of' => 'Le :attribute doit être un multiple de :value.',
    'not_in' => 'Le :attribut sélectionné n est pas valide.',
    'not_regex' => 'Le format :attribute n est pas valide.',
    'numeric' => 'Le :attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format :attribute n est pas valide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other vaut :value.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values ​​est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values ​​sont présentes.',
    'required_without' => 'Le champ :attribute est obligatoire lorsque :values ​​n est pas présent.',
    'required_without_all' => 'Le champ :attribute est obligatoire lorsqu aucune des valeurs :values ​​n est présente.',
    'prohibited' => 'Le champ :attribute est interdit.',
    'prohibited_if' => 'Le champ :attribute est interdit lorsque :other vaut :value.',
    'prohibited_unless' => 'Le champ :attribute est interdit sauf si :other est dans :values.',
    'prohibits' => 'Le champ :attribute interdit la présence de :other.',
    'same' => 'Les :attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => 'Le :attribute doit être :size.',
        'file' => 'Le :attribute doit être :size kilo-octets.',
        'string' => 'Le :attribute doit être :size caractères.',
        'array' => 'Le :attribute doit contenir des éléments :size.',
    ],
    'starts_with' => 'Le :attribute doit commencer par l un des éléments suivants : :values.',
    'string' => 'Le :attribute doit être une chaîne.',
    'timezone' => 'Le :attribute doit être un fuseau horaire valide.',
    'unique' => 'Le :attribute a déjà été pris.',
    'uploaded' => 'Le :attribute n a pas pu être téléchargé.',
    'url' => 'Le :attribute n a pas pu être téléchargé.',
    'uuid' => 'Le :attribute doit être un UUID valide.',
    

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
            'required' => 'Le champ :attribute est obligatoire.'
        
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

    'attributes' => [        
    ],

];
