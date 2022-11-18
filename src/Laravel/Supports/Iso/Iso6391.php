<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Validators\Iso;

class Iso6391
{

    /**
     * Array of countries with their ISO 639-1 alpha-2 codes.
     *
     **/
    public static array $alpha2 = [
        'AB' => 'Abkhazian',
        'AA' => 'Afar',
        'AF' => 'Afrikaans',
        'AK' => 'Akan',
        'SQ' => 'Albanian',
        'AM' => 'Amharic',
        'AR' => 'Arabic',
        'AN' => 'Aragonese',
        'HY' => 'Armenian',
        'AS' => 'Assamese',
        'AV' => 'Avaric',
        'AE' => 'Avestan',
        'AY' => 'Aymara',
        'AZ' => 'Azerbaijani',
        'BM' => 'Bambara',
        'BA' => 'Bashkir',
        'EU' => 'Basque',
        'BE' => 'Belarusian',
        'BN' => 'Bengali',
        'BH' => 'Bihari languages',
        'BI' => 'Bislama',
        'BS' => 'Bosnian',
        'BR' => 'Breton',
        'BG' => 'Bulgarian',
        'MY' => 'Burmese',
        'CA' => 'Catalan, Valencian',
        'KM' => 'Central Khmer',
        'CH' => 'Chamorro',
        'CE' => 'Chechen',
        'NY' => 'Chichewa, Chewa, Nyanja',
        'ZH' => 'Chinese',
        'CU' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
        'CV' => 'Chuvash',
        'KW' => 'Cornish',
        'CO' => 'Corsican',
        'CR' => 'Cree',
        'HR' => 'Croatian',
        'CS' => 'Czech',
        'DA' => 'Danish',
        'DV' => 'Divehi, Dhivehi, Maldivian',
        'NL' => 'Dutch, Flemish',
        'DZ' => 'Dzongkha',
        'EN' => 'English',
        'EO' => 'Esperanto',
        'ET' => 'Estonian',
        'EE' => 'Ewe',
        'FO' => 'Faroese',
        'FJ' => 'Fijian',
        'FI' => 'Finnish',
        'FR' => 'French',
        'FF' => 'Fulah',
        'GD' => 'Gaelic, Scottish Gaelic',
        'GL' => 'Galician',
        'LG' => 'Ganda',
        'KA' => 'Georgian',
        'DE' => 'German',
        'KI' => 'Gikuyu, Kikuyu',
        'EL' => 'Greek (Modern)',
        'KL' => 'Greenlandic, Kalaallisut',
        'GN' => 'Guarani',
        'GU' => 'Gujarati',
        'HT' => 'Haitian, Haitian Creole',
        'HA' => 'Hausa',
        'HE' => 'Hebrew',
        'HZ' => 'Herero',
        'HI' => 'Hindi',
        'HO' => 'Hiri Motu',
        'HU' => 'Hungarian',
        'IS' => 'Icelandic',
        'IO' => 'Ido',
        'IG' => 'Igbo',
        'ID' => 'Indonesian',
        'IA' => 'Interlingua (International Auxiliary Language Association)',
        'IE' => 'Interlingue',
        'IU' => 'Inuktitut',
        'IK' => 'Inupiaq',
        'GA' => 'Irish',
        'IT' => 'Italian',
        'JA' => 'Japanese',
        'JV' => 'Javanese',
        'KN' => 'Kannada',
        'KR' => 'Kanuri',
        'KS' => 'Kashmiri',
        'KK' => 'Kazakh',
        'RW' => 'Kinyarwanda',
        'KV' => 'Komi',
        'KG' => 'Kongo',
        'KO' => 'Korean',
        'KJ' => 'Kwanyama, Kuanyama',
        'KU' => 'Kurdish',
        'KY' => 'Kyrgyz',
        'LO' => 'Lao',
        'LA' => 'Latin',
        'LV' => 'Latvian',
        'LB' => 'Letzeburgesch, Luxembourgish',
        'LI' => 'Limburgish, Limburgan, Limburger',
        'LN' => 'Lingala',
        'LT' => 'Lithuanian',
        'LU' => 'Luba-Katanga',
        'MK' => 'Macedonian',
        'MG' => 'Malagasy',
        'MS' => 'Malay',
        'ML' => 'Malayalam',
        'MT' => 'Maltese',
        'GV' => 'Manx',
        'MI' => 'Maori',
        'MR' => 'Marathi',
        'MH' => 'Marshallese',
        'RO' => 'Moldovan, Moldavian, Romanian',
        'MN' => 'Mongolian',
        'NA' => 'Nauru',
        'NV' => 'Navajo, Navaho',
        'ND' => 'Northern Ndebele',
        'NG' => 'Ndonga',
        'NE' => 'Nepali',
        'SE' => 'Northern Sami',
        'NO' => 'Norwegian',
        'NB' => 'Norwegian Bokmål',
        'NN' => 'Norwegian Nynorsk',
        'II' => 'Nuosu, Sichuan Yi',
        'OC' => 'Occitan (post 1500)',
        'OJ' => 'Ojibwa',
        'OR' => 'Oriya',
        'OM' => 'Oromo',
        'OS' => 'Ossetian, Ossetic',
        'PI' => 'Pali',
        'PA' => 'Panjabi, Punjabi',
        'PS' => 'Pashto, Pushto',
        'FA' => 'Persian',
        'PL' => 'Polish',
        'PT' => 'Portuguese',
        'QU' => 'Quechua',
        'RM' => 'Romansh',
        'RN' => 'Rundi',
        'RU' => 'Russian',
        'SM' => 'Samoan',
        'SG' => 'Sango',
        'SA' => 'Sanskrit',
        'SC' => 'Sardinian',
        'SR' => 'Serbian',
        'SN' => 'Shona',
        'SD' => 'Sindhi',
        'SI' => 'Sinhala, Sinhalese',
        'SK' => 'Slovak',
        'SL' => 'Slovenian',
        'SO' => 'Somali',
        'ST' => 'Sotho, Southern',
        'NR' => 'South Ndebele',
        'ES' => 'Spanish, Castilian',
        'SU' => 'Sundanese',
        'SW' => 'Swahili',
        'SS' => 'Swati',
        'SV' => 'Swedish',
        'TL' => 'Tagalog',
        'TY' => 'Tahitian',
        'TG' => 'Tajik',
        'TA' => 'Tamil',
        'TT' => 'Tatar',
        'TE' => 'Telugu',
        'TH' => 'Thai',
        'BO' => 'Tibetan',
        'TI' => 'Tigrinya',
        'TO' => 'Tonga (Tonga Islands)',
        'TS' => 'Tsonga',
        'TN' => 'Tswana',
        'TR' => 'Turkish',
        'TK' => 'Turkmen',
        'TW' => 'Twi',
        'UG' => 'Uighur, Uyghur',
        'UK' => 'Ukrainian',
        'UR' => 'Urdu',
        'UZ' => 'Uzbek',
        'VE' => 'Venda',
        'VI' => 'Vietnamese',
        'VO' => 'Volap_k',
        'WA' => 'Walloon',
        'CY' => 'Welsh',
        'FY' => 'Western Frisian',
        'WO' => 'Wolof',
        'XH' => 'Xhosa',
        'YI' => 'Yiddish',
        'YO' => 'Yoruba',
        'ZA' => 'Zhuang, Chuang',
        'ZU' => 'Zulu',
    ];

    /**
     * Array of countries with their ISO 639-1 alpha-3 codes.
     *
     **/
    public static array $alpha3 = [
        'ABK' => 'Abkhazian',
        'AAR' => 'Afar',
        'AFR' => 'Afrikaans',
        'ALB' => 'Albanian',
        'SQI' => 'Albanian',
        'AMH' => 'Amharic',
        'ARA' => 'Arabic',
        'ARG' => 'Aragonese',
        'ARM' => 'Armenian',
        'HYE' => 'Armenian',
        'ASM' => 'Assamese',
        'AVE' => 'Avestan',
        'AYM' => 'Aymara',
        'AZE' => 'Azerbaijani',
        'BAK' => 'Bashkir',
        'BAQ' => 'Basque',
        'EUS' => 'Basque',
        'BEL' => 'Belarusian',
        'BEN' => 'Bengali',
        'BIH' => 'Bihari',
        'BIS' => 'Bislama',
        'BOS' => 'Bosnian',
        'BRE' => 'Breton',
        'BUL' => 'Bulgarian',
        'BUR' => 'Burmese',
        'MYA' => 'Burmese',
        'CAT' => 'Catalan',
        'CHA' => 'Chamorro',
        'CHE' => 'Chechen',
        'CHI' => 'Chinese',
        'ZHO' => 'Chinese',
        'CHU' => 'Church Slavic, Slavonic, Old Bulgarian',
        'CHV' => 'Chuvash',
        'COR' => 'Cornish',
        'COS' => 'Corsican',
        'HRV' => 'Croatian',
        'SCR' => 'Croatian',
        'CZE' => 'Czech',
        'CES' => 'Czech',
        'DAN' => 'Danish',
        'DIV' => 'Divehi, Dhivehi, Maldivian',
        'DUT' => 'Dutch',
        'NLD' => 'Dutch',
        'DZO' => 'Dzongkha',
        'ENG' => 'English',
        'EPO' => 'Esperanto',
        'EST' => 'Estonian',
        'FAO' => 'Faroese',
        'FIJ' => 'Fijian',
        'FIN' => 'Finnish',
        'FRE' => 'French',
        'FRA' => 'French',
        'GD'  => 'Gaelic, Scottish Gaelic',
        'GLA' => 'Gaelic, Scottish Gaelic',
        'GLG' => 'Galician',
        'GEO' => 'Georgian',
        'KAT' => 'Georgian',
        'GER' => 'German',
        'DEU' => 'German',
        'GRE' => 'Greek, Modern',
        'ELL' => 'Greek, Modern',
        'GRN' => 'Guarani',
        'GUJ' => 'Gujarati',
        'HAT' => 'Haitian, Haitian Creole',
        'HAU' => 'Hausa',
        'HEB' => 'Hebrew',
        'HER' => 'Herero',
        'HIN' => 'Hindi',
        'HMO' => 'Hiri Motu',
        'HUN' => 'Hungarian',
        'ICE' => 'Icelandic',
        'ISL' => 'Icelandic',
        'IDO' => 'Ido',
        'IND' => 'Indonesian',
        'INA' => 'Interlingua',
        'ILE' => 'Interlingue',
        'IKU' => 'Inuktitut',
        'IPK' => 'Inupiaq',
        'GLE' => 'Irish',
        'ITA' => 'Italian',
        'JPN' => 'Japanese',
        'JAV' => 'Javanese',
        'KAL' => 'Kalaallisut',
        'KAN' => 'Kannada',
        'KAS' => 'Kashmiri',
        'KAZ' => 'Kazakh',
        'KHM' => 'Khmer',
        'KIK' => 'Kikuyu, Gikuyu',
        'KIN' => 'Kinyarwanda',
        'KIR' => 'Kirghiz',
        'KOM' => 'Komi',
        'KOR' => 'Korean',
        'KUA' => 'Kuanyama, Kwanyama',
        'KUR' => 'Kurdish',
        'LAO' => 'Lao',
        'LAT' => 'Latin',
        'LAV' => 'Latvian',
        'LIM' => 'Limburgan, Limburger, Limburgish',
        'LIN' => 'Lingala',
        'LIT' => 'Lithuanian',
        'LTZ' => 'Luxembourgish, Letzeburgesch',
        'MAC' => 'Macedonian',
        'MKD' => 'Macedonian',
        'MLG' => 'Malagasy',
        'MAY' => 'Malay',
        'MSA' => 'Malay',
        'MAL' => 'Malayalam',
        'MLT' => 'Maltese',
        'GLV' => 'Manx',
        'MAO' => 'Maori',
        'MRI' => 'Maori',
        'MAR' => 'Marathi',
        'MAH' => 'Marshallese',
        'MOL' => 'Moldavian',
        'MON' => 'Mongolian',
        'NAU' => 'Nauru',
        'NAV' => 'Navaho, Navajo',
        'NDE' => 'Ndebele, North',
        'NBL' => 'Ndebele, South',
        'NDO' => 'Ndonga',
        'NEP' => 'Nepali',
        'SME' => 'Northern Sami',
        'NOR' => 'Norwegian',
        'NOB' => 'Norwegian Bokmal',
        'NNO' => 'Norwegian Nynorsk',
        'NYA' => 'Nyanja, Chichewa, Chewa',
        'OCI' => 'Occitan, Provencal',
        'ORI' => 'Oriya',
        'ORM' => 'Oromo',
        'OSS' => 'Ossetian, Ossetic',
        'PLI' => 'Pali',
        'PAN' => 'Panjabi',
        'PER' => 'Persian',
        'FAS' => 'Persian',
        'POL' => 'Polish',
        'POR' => 'Portuguese',
        'PUS' => 'Pushto',
        'QUE' => 'Quechua',
        'ROH' => 'Raeto-Romance',
        'RUM' => 'Romanian',
        'RON' => 'Romanian',
        'RUN' => 'Rundi',
        'RUS' => 'Russian',
        'SMO' => 'Samoan',
        'SAG' => 'Sango',
        'SAN' => 'Sanskrit',
        'SRD' => 'Sardinian',
        'SCC' => 'Serbian',
        'SRP' => 'Serbian',
        'SNA' => 'Shona',
        'III' => 'Sichuan Yi',
        'SND' => 'Sindhi',
        'SIN' => 'Sinhala, Sinhalese',
        'SLO' => 'Slovak',
        'SLK' => 'Slovak',
        'SLV' => 'Slovenian',
        'SOM' => 'Somali',
        'SOT' => 'Sotho, Southern',
        'SPA' => 'Spanish, Castilian',
        'SUN' => 'Sundanese',
        'SWA' => 'Swahili',
        'SSW' => 'Swati',
        'SWE' => 'Swedish',
        'TGL' => 'Tagalog',
        'TAH' => 'Tahitian',
        'TGK' => 'Tajik',
        'TAM' => 'Tamil',
        'TAT' => 'Tatar',
        'TEL' => 'Telugu',
        'THA' => 'Thai',
        'TIB' => 'Tibetan',
        'BOD' => 'Tibetan',
        'TIR' => 'Tigrinya',
        'TON' => 'Tonga',
        'TSO' => 'Tsonga',
        'TSN' => 'Tswana',
        'TUR' => 'Turkish',
        'TUK' => 'Turkmen',
        'TWI' => 'Twi',
        'UIG' => 'Uighur',
        'UKR' => 'Ukrainian',
        'URD' => 'Urdu',
        'UZB' => 'Uzbek',
        'VIE' => 'Vietnamese',
        'VOL' => 'Volapuk',
        'WLN' => 'Walloon',
        'WEL' => 'Welsh',
        'CYM' => 'Welsh',
        'FRY' => 'Western Frisian',
        'WOL' => 'Wolof',
        'XHO' => 'Xhosa',
        'YID' => 'Yiddish',
        'YOR' => 'Yoruba',
        'ZHA' => 'Zhuang, Chuang',
        'ZUL' => 'Zulu',
    ];

}
