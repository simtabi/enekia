<?php

return [
    // v2
    'hexcolor'                    => 'The :attribute must be a valid hexadecimal color code.',
    'creditcard'                  => 'The :attribute must be a valid creditcard number.',
    'isbn'                        => ':attribute must be a valid International Standard Book Number (ISBN).',
    'username'                    => 'The value :attribute must be a valid username.',
    'htmlclean'                   => 'The value :attribute contains forbidden HTML code.',
    'jwt'                         => 'The value :attribute does not correspond to the JSON Web Token Format',
    'imei'                        => 'The value :attribute must be a valid Mobile Equipment Identity (IMEI).',
    'semver'                      => 'The value :attribute is no version number using Semantic Versioning.',
    'luhn'                        => 'The value :attribute cannot be verified using the Luhn algorithm.',
    'base64'                      => [
        'image'    => 'The :attribute must be a valid Base64 encoded image.',
        'string'   => 'The :attribute must be a valid Base64 encoded string.',
        'max_size' => 'The :attribute size cannot exceed :max_size.',
    ],



    'issn'                        => 'The value :attribute must be a valid International Standard Serial Number (ISSN).',

    'datauri'                     => 'The :attribute must be a valid data url.',
    'ulid'                        => 'The :attribute is not a valid ULID.',
    'ean'                         => 'The :attribute is not a valid European Article Number (EAN).',
    'postalcode'                  => 'The value :attribute must be a valid postal code.',
    'mimetype'                    => 'The value :attribute does not contain a valid Internet Media Type (MIME-Type).',

    'citizen_identification'      => 'The :attribute must be a valid form of identification.',
    'country'                     => [
        'code' => 'The :attribute must be a valid ISO 3166-1 2/3 digit country code'
    ],
    'decimal'                     => 'The :attribute must be an appropriately formatted decimal e.g. :decimal',
    'encoded_image'               => 'The :attribute must be a valid :encoded_image image',
    'file_exists'                 => 'The file specified for :attribute does not exist',
    'language_code'               => 'The :attribute must be a valid ISO 639-1 :language_code language code',
    'location_coordinates'        => 'The :attribute must be a valid set of latitude and longitude coordinates, with a limit of 8 digits after a decimal point',


    'telephone_number'            => [
        'dutch_phone' => 'The :attribute must be a valid dutch phone number',
        'general'     => 'The :attribute must be a valid telephone number (7 - 15 digits in length)',
    ],



    'date_and_time'              => [
        'after_or_equal'          => 'The :attribute must be after or equal to :after_or_equal',
        'before_or_equal'         => 'The :attribute must be before or equal to :before_or_equal',
        'has_specific_minutes'    => 'The :attribute must have one of :minutes minutes',
        'positive_interval'       => 'The :attribute must be a positive interval',
        'maximum_hour_difference' => 'The start and end date differ more then :difference hours',
        'interval'                => 'The :attribute must be a valid time/date interval',
    ],
    'dutch_postal_code'           => 'The :attribute must be a valid dutch post code',
    'password'                    => [
        'uppercase_character_required'                          => 'The :attribute must be at least :length characters and contain at least one uppercase character.',
        'number_required'                                       => 'The :attribute must be at least :length characters and contain at least one number.',
        'special_character_required'                            => 'The :attribute must be at least :length characters and contain at least one special character.',
        'uppercase_character_number_required'                   => 'The :attribute must be at least :length characters and contain at least one uppercase character and one number.',
        'uppercase_character_special_character_required'        => 'The :attribute must be at least :length characters and contain at least one uppercase character and one special character.',
        'uppercase_character_number_special_character_required' => 'The :attribute must be at least :length characters and contain at least one uppercase character, one number, and one special character.',
        'number_special_character_required'                     => 'The :attribute must be at least :length characters and contain at least one special character and one number.',
        'length'                                                => 'The :attribute must be at least :length characters.',
        'weak_password'                                         => 'The :attribute must be :min - :max characters, and include a number, a symbol, a lower and a upper case letter',
        'is_exposed'                                            => 'The :attribute has been exposed in a data breach.',
        'has_been_used'                                         => 'The :attribute has been used previously.',
    ],
    'crypto_currency_address'     => [
        'bitcoin'  => 'The :attribute must be a valid BTC address.',
        'ethereum' => 'The :attribute must be an Ethereum address.',
    ],
    'divisible_by'                => 'The :attribute must be divisible by :number.',
    'number'                      => [
        'float' => 'The :attribute must be a float number.',
        'odd'   => 'The :attribute must be an odd number',
        'even'  => 'The :attribute must be an even number',
    ],
    'hash'                        => 'The :attribute must be a hash of :algorithm algorithm.',
    'url'                         => [
        'image'  => 'The :attribute must be a valid image URL.',
        'secure' => 'The value :attribute must be a valid secure url.',
    ],
    'name'                        => 'The :attribute must be a valid name.',
    'enum'                        => 'The :attribute is not a valid value.',
    'delimited'                   => [
        'unique' => 'You may not specify duplicates.',
        'min'    => 'You must specify at least :min :item',
        'max'    => 'You can only specify :max :item',
    ],


    'eloquent_model'              => [
        'action_not_authorized_on_model' => 'You are not authorized to use this value on the given model.',
        'not_a_record_owner'             => 'You do not have permission to interact with this resource',
        'missing_from_db'                => 'The :attribute already exists',
        'model_not_found'                => 'The given model could not be found.',
        'ids_not_found'                  => 'Some of the given ids do not exist.',
    ],
    'profanity'                   => 'The :attribute contains vulgar content',
    'remote_rule'                 => 'The :attribute must be valid.',
    'email'                       => [
        'domain_restricted' => 'The :attribute must be an email address ending with any of the following :plural: :domains',
        'domain_on_system'  => 'The selected :attribute does not have a valid domain, based on system settings.',
        'domain'            => 'The selected :attribute must be one of the following: domains.',
        'multiple'          => 'The selected :attribute is not valid because of: :errors.',
        'disposable'        => 'The :attribute can not have a disposable email/email domain.',
    ],
    'barcode'                     => [
        'asin'   => ':attribute does not have a valid ASIN number',
        'ean5'   => ':attribute does not contain a valid EAN-5 code',
        'ean8'   => ':attribute does not contain a valid EAN-8 code',
        'ean13'  => ':attribute does not contain a valid EAN-13 code',
        'isbn10' => ':attribute does not contain a valid ISBN10 number',
        'isbn13' => ':attribute does not have a valid ISBN13 number',
        'ismn'   => ':attribute does not have a valid ISMN number',
        'jan'    => ':attribute does not contain a valid JAN code',
        'upc_a'  => ':attribute does not contain a valid UPC(-A) code',
        'upc_e'  => ':attribute does not contain a valid UPC(-E) code',
    ],
    'color'                       => [
        'hex'  => 'The :attribute does not contain a valid hex color',
        'rgb'  => ':attribute does not contain a valid RGB color',
        'rgba' => ':attribute does not contain a valid RGBA color',
    ],
    'database'                    => [
        'less_than_or_equal_value'  => 'The column (:column) can not be less than or same as the :value',
        'less_than_value'           => 'The column (:column) can not be less than :value',
        'more_than_or_equal_value'  => 'The column (:column) can not be more than or same as the :value',
        'more_than_value'           => 'The column (:column) can not be more than :value',
        'must_be_equal_value'       => 'The found value (:found_value) does not match the given :posted_value',
    ],
    'date_and_time'                 => [
        'extended_rfc3339' => 'The :attribute is not a valid RFC3339 (https://tools.ietf.org/html/rfc3339)',
        'time_12_hour'     => 'The :attribute does not contain a valid time. It needs be in the following format: :format',
        'time_24_hour'     => 'The :attribute does not contain a valid time. It needs be in the following format: :format',
        'timezone_abbr'    => 'The :attribute does not contain a valid timezone abbreviation',
        'unix_time'        => 'The :attribute does not contain a valid UNIX timestamp',
    ],
    'network'                       => [
        'cidr_number' => 'The :attribute must be a valid CIDR notation.',
        'mac_address' => 'The :attribute does not contain a valid MAC address',
        'domain'      => 'The :attribute must be a valid and well formed domain name without an http protocol e.g. google.com, www.google.com',
        'subdomain'   => 'The :attribute must be a valid subdomain, or is not available',
        'hostname'    => 'The :attribute must be a valid hostname',
        'ip_address'  => [
            'not_valid' => 'The :attribute must be a valid IP address',
            'private'   => 'The :attribute must be a valid private IP address',
            'public'    => 'The :attribute must be a valid public IP address',
            'ipv4'      => 'The :attribute does not contain a valid IP address',
            'ipv6'      => 'The :attribute does not contain a valid IPv6 address',
        ],
    ],
    'banking'                       => [
        'iban_number'     => 'The :attribute must be a valid International Bank Account Number (IBAN).',
        'bic_number'      => 'The :attribute is not a valid Business Identifier Code (BIC).',
        'isin'            => 'The :attribute must be a valid International Securities Identification Number (ISIN).',
        'vat_number'      => 'The :attribute must be a valid VAT number',
        'price'           => [
            'general'        => 'The :attribute must be a valid price like `10,95` or `10.50`',
            'custom_decimal' => 'The :attribute must be a valid price like :custom_decimal `95`',
        ],
        'gtin'            => 'The :attribute is not a valid Global Trade Item Number (GTIN).',
        'monetary_figure' => 'The :attribute must be a monetary figure e.g. :monetary_figure',
        'currency'        => [
            'numeric' => 'The :attribute must be a valid numeric currency symbol',
            'symbol'  => 'The :attribute must be a valid currency symbol figure e.g. :example',
            'code'    => 'The :attribute must be a valid ISO4217 currency.',
        ],
        'credit_card'     => [
            'cvc_invalid'                    => 'The :attribute is not a valid card CVC',
            'expiration_month_invalid'       => 'The :attribute is not a valid card expiration month',
            'expiration_year_invalid'        => 'The :attribute is not a valid card expiration year',
            'expiration_date_invalid'        => 'The :attribute is not a valid card expiration date',
            'expiration_date_format_invalid' => 'The :attribute is not a valid card expiration date format',

            'invalid_card'                   => 'Invalid card',
            'invalid_pattern'                => 'Invalid card pattern',
            'invalid_length'                 => 'Invalid card length',
            'invalid_checksum'               => 'Invalid card checksum',
        ],
    ],
    'salutation'                    => 'The :attribute must be a valid salutation',
    'str'                           => [
        'ascii'                       => 'The :attribute must contain ASCII chars only.',
        'slug'                        => 'The value :attribute is no SEO-friendly short text (slug).',
        'lowercase'                   => 'The content :attribute may only consist of lowercase letters.',
        'uppercase'                   => 'The content :attribute may only consist of uppercase letters.',
        'titlecase'                   => 'All words from :attribute must begin with capital letters.',
        'snakecase'                   => 'The content :attribute must be formatted in Snake case.',
        'kebabcase'                   => 'The content :attribute must be formatted in Kebab case.',
        'camelcase'                   => 'The content :attribute must be formatted in Camel case.',

        'without_whitespace'          => 'The :attribute must be an unbroken string of text, it cannot include spaces',
        'max_words'                   => 'The :attribute cannot be longer than :limit words.',
        'contains'                    => 'The :attribute must contain :contains',
        'not_contains'                => 'The :attribute must not contain :needle',
        'not_ends_with'               => 'The :attribute must not end with :needle',
        'not_starts_with'             => 'The :attribute must not start with :needle',
        'string_contains'             => [
            'strict' => 'The :attribute must contain all of the following phrases: :phrases',
            'loose'  => 'The :attribute must contain at least one of the following phrases: :phrases',
        ],
    ],









    /// v1
    'isin'                             => 'The :attribute must be a valid International Securities Identification Number (ISIN).',
    'iban'                             => 'The :attribute must be a valid International Bank Account Number (IBAN).',
    'bic'                              => 'The :attribute is not a valid Business Identifier Code (BIC).',
    'isbn'                             => ':attribute must be a valid (ISBN 10 or ISBN 13) International Standard Book Number (ISBN).',
    'username'                         => [
        'blacklisted'    => 'The supplied :attribute is not allowed list and can not be used. Chose different one.',
        'too_short'      => 'The supplied :attribute is too short.',
        'too_long'       => 'The supplied :attribute is too long.',
        'invalid'        => 'The supplied :attribute is invalid. Should contain alpha-numeric (a-z, A-Z, 0-9),
         underscore and minus starts with an letter (alpha) underscores and minus are not allowed at the beginning or end
         multiple underscores and minus are not allowed (-- or _____).',
    ],
    'html_clean'                       => 'The value :attribute contains forbidden HTML code.',
    'domain_name'                      => ':attribute must be a well formed domain name.',
    'jwt'                              => 'The value :attribute does not correspond to the JSON Web Token Format',
    'imei'                             => 'The value :attribute must be a valid Mobile Equipment Identity (IMEI).',
    'slug'                             => 'The value :attribute is no SEO-friendly short text.',
    'semver'                           => 'The value :attribute is no version number using Semantic Versioning.',
    'luhn'                             => 'The value :attribute cannot be verified using the Luhn algorithm.',
    'base64'                           => 'The value :attribute is not Base64 encoded.',
    'issn'                             => 'The value :attribute must be a valid International Standard Serial Number (ISSN).',
    'lower_case'                       => 'The content :attribute may only consist of lowercase letters.',
    'upper_case'                       => 'The content :attribute may only consist of uppercase letters.',
    'title_case'                       => 'All words from :attribute must begin with capital letters.',
    'snake_case'                       => 'The content :attribute must be formatted in Snake case.',
    'kebab_case'                       => 'The content :attribute must be formatted in Kebab case.',
    'camelcase'                        => 'The content :attribute must be formatted in Camel case.',
    'cidr'                             => 'The :attribute must be a valid CIDR notation.',
    'data_uri'                         => 'The :attribute must be a valid data url.',
    'ulid'                             => 'The :attribute is not a valid ULID.',
    'ean'                              => 'The :attribute is not a valid European Article Number (EAN).',
    'gtin'                             => 'The :attribute is not a valid Global Trade Item Number (GTIN).',
    'postal_code'                      => 'The value :attribute must be a valid postal code.',
    'mimetype'                         => 'The value :attribute does not contain a valid Internet Media Type (MIME-Type).',

    'location_coordinates'             => 'The :attribute must be a valid set of latitude and longitude coordinates, with a limit of 8 digits after a decimal point',
    'odd_number'                       => 'The value :attribute is not a valid odd number.',
    'even_number'                      => 'The value :attribute is not a valid even number.',
    'phone_number'                     => [
        'digits'             => ':attribute must be in digits only phone format',
        'e123'               => ':attribute must be in E.123 phone format',
        'e124'               => ':attribute must be in E.164 phone format',
        'nanp'               => ':attribute must be in the NANP phone format',
        'format'             => 'Incorrect phone number format.',
        'us_number'          => 'The :attribute must be a valid United States telephone number (10 digits in length)',
        'uk_mobile_number'   => 'The :attribute must be a valid UK mobile number',
        'dutch_phone_number' => 'The :attribute must be a valid dutch phone number',
    ],
    'file_exists'                      => 'The file specified for :attribute does not exist',
    'disposable_email'                 => 'The :attribute must be a valid, non-disposable domain',
    'decimal'                          => 'The :attribute is not a properly formatted decimal number',
    'equals'                           => 'The value :attribute is not equal/identical',
    'ends_with'                        => 'The value :attribute does not end with the given value',
    'no_whitespace'                    => 'The :attribute must be an unbroken string of text, and it cannot contain spaces',
    'does_not_exist'                   => 'The :attribute does not exist',


    'max_words'                        => 'The :attribute cannot be longer than the required words.',
    'excludes_html'                    => 'The :attribute contains html',
    'includes_html'                    => 'The :attribute must contain html',
    'base64_encoded_string'            => 'The :attribute must be a valid base64 encoded string',
    'coordinate'                       => 'The :attribute must be a valid set of comma separated coordinates i.e. 27.666530,_97.367170',
    'domain_restricted_email'          => 'The :attribute must be an email address ending with any of the following :plural: :domains',
    'number_parity'                    => [
        'even' => 'The :attribute must be an even number',
        'odd'  => 'The :attribute must be an odd number',
    ],
    'password'                         => [
        'exposed'  => 'The :attribute has been exposed in a data breach.',
        'secure'   => [
            'base'      => 'The :attribute has failed the security checks and must be',
            'min'       => 'at least :length characters long',
            'uppercase' => 'include an uppercase letter',
            'lowercase' => 'include a lowercase letter',
            'numbers'   => 'include numbers',
            'special'   => 'include at least one special character (:characters)',
        ],
        'strength' => [
            'invalid_score'      => 'The required password score must be between 0 and 4',
            'suggestion'         => 'Add another word or two. Uncommon words are better',
            'bruteforce'         => 'This password is easy to brute-force. Use different character classes (letters, numbers, special characters).',
            'predictable'        => 'Predictable substitutions such as "@" for "a" or "$" for "s" are easy to guess',
            'sequence'           => 'Sequences like "ABC" or "123" are easy to guess',
            'repeat'             => 'Repeating characters like "AAA" or "111" are easy to guess',
            'date'               => 'Dates are often easy to guess',
            'year'               => 'Recent years are easy to guess',
            'straight_spatial'   => 'Short keyboard patterns are easy to guess',
            'spatial_with_turns' => 'Straight rows of keys are easy to guess',
            'names'              => 'Names are easy to guess',
            'common'             => 'This is similar to a commonly used password',
            'very_common'        => 'This is a very common password',
            'top_10'             => 'This is in the top-10 most common passwords',
            'top_100'            => 'This is in the top-100 most common passwords',
            'digits'             => 'Adding a series of digits does not improve security',
            'reused'             => 'Re-using information such as your name, username or email in the password is not secure',
            'weak'               => 'Weak :attribute. You must chose a stronger one.',
        ]
    ],

    'hex_colour_code'                  => [
        'base'   => 'The :attribute must be a valid :length length hex colour code',
        'prefix' => ', prefixed with the "#" symbol',
    ],

    'vat_number'                       => 'The :attribute must be a valid VAT number',
    'contains'                         => 'The :attribute must contain `%s`',

    'date_after_or_equal'              => 'The :attribute must be after or equal to `%s`',
    'date_before_or_equal'             => 'The :attribute must be before or equal to `%s`',
    'has_specific_minutes'        => 'The :attribute must have one of :minutes minutes',
    'timezone'                         => 'The given :attribute is not a valid timezone.',
    'country'                          => [
        'iso2'    => 'The given :attribute is not a valid ISO3166-A2 country code. e.g USA.',
        'iso3'    => 'The given :attribute is not a valid ISO3166-A3 country code. e.g USA.',
        'name'    => 'The given :attribute is not a valid ISO3166-A3 country code. e.g USA.',
        'numeric' => 'The given :attribute is not a valid ISO3166-A3 country code. e.g USA.',
    ],

    'interval'                          => 'The :attribute must be an interval',

    'not_contains'                      => 'The :attribute must not contain `%s`',
    'not_ends_with'                     => 'The :attribute must not end with `%s`',
    'not_starts_with'                   => 'The :attribute must not start with `%s`',
    'price'                             => [
        'base'           => 'The :attribute must be a valid price like `10,95` or `10.50`',
        'custom_decimal' => 'The :attribute must be a valid price like `10%s95`',
    ],
    'secure_url'                        => 'The :attribute must be a HTTPS url',
    'postal_code_dutch'                 => 'The :attribute must be a valid dutch post code',
    'is_offensive_word'                 => 'The given :attribute word is not allowed, and is offensive.',
    'is_a_state_in_north_america'       => [
        'abbr' => 'The given :attribute must be valid abbreviation for a valid State in North America',
        'full' => 'The given :attribute must the full name of a valid State in North America.',
    ],
    'exists_in_model'                   => 'Some of the given ids do not exist.',
    'multiple_emails'                   => 'Email address isn\'t valid: :emails',
    'authorized'                        => 'You are not authorized to use this value.',
    'delimited'                         => [
        'unique' => 'You may not specify duplicates.',
        'min'    => 'You must specify at least :min :item',
        'max'    => 'You can only specify :max :item',
    ],
    'enum'                              => 'This is not a valid value.',
    'language'                          => [
        'name'      => 'The :attribute is not a valid language name.',
        'alpha2'    => 'The :attribute is not a valid ISO639-1 alpha2 language code.',
        'iso639_1'  => 'The :attribute is not a valid ISO639-1 language code.',
        'iso639_2B' => 'The :attribute is not a valid ISO639-2B language code.',
        'iso639_2T' => 'The :attribute is not a valid ISO639-2T language code.',
    ],
    'encoded_image'                     => 'The :attribute must be a valid :mimes image.',
    'citizenship_identification_number' => 'The :attribute must be a valid form of identification',
    'credit_card'                       => [
        'basic' => 'The :attribute must be a valid credit card number.'
    ],
    'color'                             => [
        'invalid_color' => 'The :attribute is not a valid color code/name (hexadecimal, RGB, RGBA or CSS color name).',
        'invalid_hex'   => 'The :attribute must be a valid 3 or 6 digit hexadecimal color code.',
        'invalid_rgb'   => 'The :attribute is not a valid RGB color.',
        'invalid_rgba'  => 'The :attribute is not a valid RGBA color.',
        'invalid_name'  => 'The :attribute is not a valid color name.',
        'invalid_hsl'   => 'The :attribute is not a valid HSL color.',
        'invalid_hsla'  => 'The :attribute is not a valid HSLA color.',
        'prefixed_hex'  => 'The :attribute must be prefixed with the "#" symbol',
    ],
];
