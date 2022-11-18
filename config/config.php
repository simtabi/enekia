<?php

use App\Models\User;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Fetcher\DefaultDomainFetcher as DomainFetcher;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Fetcher\DefaultPhoneNumberFetcher as EmailFetcher;

return [
    'base64'              => [

        /*
        |--------------------------------------------------------------------------
        | Replace rule validation message
        |--------------------------------------------------------------------------
        |
        | If set true will be used validation messages for standard
        | file validation rules (for base64min - validation.min.file message, etc)
        | for using own messages set this property to false and define message
        | replacement for each rule you use in afforded by framework way
        |
        */
        'replace_validation_messages' => true,
    ],

    'username'            => [
        /*
        | --------------------------------------------------------
        | Overrides
        | --------------------------------------------------------
        | Any words you enter here will pass validation.
        | Separate words with commas and no spaces.
        */
        'whitelisted' => [

        ],

        /*
        | --------------------------------------------------------
        | Additional Disallowed Words
        | --------------------------------------------------------
        | You can add your own disallowed usernames, which
        | will be merged and checked. Separate words with
        | commas and no spaces
        */
        'blacklisted' => [

        ],


        /*
        |
        | The base list of disallowed
        | usernames. Feel free to customize,
        | or add your own rules above.
        | This list was take from the following
        | repos:
        | - https://github.com/dsignr/disallowed-usernames/
        | - https://gist.github.com/ryanlewis/a37739d710ccdb4b406d
        |
        */
        'base' => [
            "json",
            "rss",
            "wellknown",
            "xml",
            "about",
            "abuse",
            "access",
            "account",
            "accounts",
            "activate",
            "ad",
            "add",
            "address",
            "adm",
            "admin",
            "administration",
            "administrator",
            "ads",
            "adult",
            "advertising",
            "affiliate",
            "affiliates",
            "ajax",
            "analytics",
            "android",
            "anon",
            "anonymous",
            "api",
            "app",
            "apps",
            "archive",
            "atom",
            "auth",
            "authentication",
            "avatar",
            "backup",
            "bad",
            "banner",
            "banners",
            "best",
            "beta",
            "billing",
            "bin",
            "blackberry",
            "blog",
            "blogs",
            "board",
            "bot",
            "bots",
            "business",
            "cache",
            "calendar",
            "campaign",
            "career",
            "careers",
            "cart",
            "cdn",
            "cgi",
            "chat",
            "chef",
            "client",
            "clients",
            "code",
            "codes",
            "commercial",
            "compare",
            "config",
            "connect",
            "contact",
            "contact-us",
            "contest",
            "cookie",
            "corporate",
            "create",
            "crossdomain",
            "crossdomain.xml",
            "css",
            "customer",
            "dash",
            "dashboard",
            "data",
            "database",
            "db",
            "delete",
            "demo",
            "design",
            "designer",
            "dev",
            "devel",
            "developer",
            "developers",
            "development",
            "dir",
            "directory",
            "dmca",
            "doc",
            "docs",
            "documentation",
            "domain",
            "download",
            "downloads",
            "ecommerce",
            "edit",
            "editor",
            "email",
            "embed",
            "enterprise",
            "facebook",
            "faq",
            "favorite",
            "favorites",
            "favourite",
            "favourites",
            "feed",
            "feedback",
            "feeds",
            "file",
            "files",
            "follow",
            "font",
            "fonts",
            "forum",
            "forums",
            "free",
            "ftp",
            "gadget",
            "gadgets",
            "games",
            "gift",
            "good",
            "google",
            "group",
            "groups",
            "guest",
            "help",
            "helpcenter",
            "home",
            "homepage",
            "host",
            "hosting",
            "hostname",
            "html",
            "http",
            "httpd",
            "https",
            "image",
            "images",
            "imap",
            "img",
            "index",
            "indice",
            "info",
            "information",
            "intranet",
            "invite",
            "ipad",
            "iphone",
            "irc",
            "java",
            "javascript",
            "job",
            "jobs",
            "js",
            "json",
            "knowledgebase",
            "legal",
            "license",
            "list",
            "lists",
            "log",
            "login",
            "logout",
            "logs",
            "mail",
            "manager",
            "manifesto",
            "marketing",
            "master",
            "me",
            "media",
            "message",
            "messages",
            "messenger",
            "mine",
            "mob",
            "mobile",
            "msg",
            "must",
            "mx",
            "my",
            "mysql",
            "name",
            "named",
            "net",
            "network",
            "new",
            "newest",
            "news",
            "newsletter",
            "notes",
            "oembed",
            "old",
            "oldest",
            "online",
            "operator",
            "order",
            "orders",
            "page",
            "pager",
            "pages",
            "panel",
            "password",
            "password1",
            "password2",
            "password3",
            "password4",
            "password5",
            "password6",
            "password7",
            "password8",
            "password9",
            "password10",
            "perl",
            "photo",
            "photos",
            "php",
            "pic",
            "pics",
            "plan",
            "plans",
            "plugin",
            "plugins",
            "pop",
            "pop3",
            "post",
            "postfix",
            "postmaster",
            "posts",
            "press",
            "pricing",
            "privacy",
            "privacy-policy",
            "profile",
            "project",
            "projects",
            "promo",
            "pub",
            "public",
            "python",
            "random",
            "recipe",
            "recipes",
            "register",
            "registration",
            "remove",
            "request",
            "reset",
            "robots",
            "robots.txt",
            "rss",
            "root",
            "ruby",
            "sale",
            "sales",
            "sample",
            "samples",
            "save",
            "script",
            "scripts",
            "search",
            "secure",
            "security",
            "send",
            "service",
            "services",
            "setting",
            "settings",
            "setup",
            "shop",
            "shopping",
            "signin",
            "signup",
            "site",
            "sitemap",
            "sitemap.xml",
            "sites",
            "smtp",
            "sql",
            "ssh",
            "stage",
            "staging",
            "start",
            "stat",
            "static",
            "stats",
            "status",
            "store",
            "stores",
            "subdomain",
            "subscribe",
            "support",
            "surprise",
            "svn",
            "sys",
            "sysop",
            "system",
            "tablet",
            "tablets",
            "talk",
            "task",
            "tasks",
            "tech",
            "telnet",
            "terms",
            "terms-of-use",
            "test",
            "test1",
            "test2",
            "test3",
            "tests",
            "theme",
            "themes",
            "tmp",
            "todo",
            "tools",
            "top",
            "trust",
            "tv",
            "twitter",
            "twittr",
            "unsubscribe",
            "update",
            "upload",
            "url",
            "usage",
            "user",
            "username",
            "users",
            "video",
            "videos",
            "visitor",
            "web",
            "weblog",
            "webmail",
            "webmaster",
            "website",
            "websites",
            "welcome",
            "wiki",
            "win",
            "ww",
            "wws",
            "www",
            "www1",
            "www2",
            "www3",
            "www4",
            "www5",
            "www6",
            "www7",
            "wwws",
            "wwww",
            "xml",
            "xpg",
            "xxx",
            "yahoo",
            "you",
            "yourdomain",
            "yourname",
            "yoursite",
            "yourusername",
            "4r5e",
            "5h1t",
            "5hit",
            "a55",
            "anal",
            "anus",
            "ar5e",
            "arrse",
            "arse",
            "ass",
            "ass-fucker",
            "asses",
            "assfucker",
            "assfukka",
            "asshole",
            "assholes",
            "asswhole",
            "a_s_s",
            "b!tch",
            "b00bs",
            "b17ch",
            "b1tch",
            "ballbag",
            "balls",
            "ballsack",
            "bastard",
            "beastial",
            "beastiality",
            "bellend",
            "bestial",
            "bestiality",
            "bi+ch",
            "biatch",
            "bitch",
            "bitcher",
            "bitchers",
            "bitches",
            "bitchin",
            "bitching",
            "bloody",
            "blowjob",
            "blowjob",
            "blowjobs",
            "boiolas",
            "bollock",
            "bollok",
            "boner",
            "boob",
            "boobs",
            "booobs",
            "boooobs",
            "booooobs",
            "booooooobs",
            "breasts",
            "buceta",
            "bugger",
            "bum",
            "bunnyfucker",
            "butt",
            "butthole",
            "buttmuch",
            "buttplug",
            "c0ck",
            "c0cksucker",
            "carpetmuncher",
            "cawk",
            "chink",
            "cipa",
            "cl1t",
            "clit",
            "clitoris",
            "clits",
            "cnut",
            "cock",
            "cock-sucker",
            "cockface",
            "cockhead",
            "cockmunch",
            "cockmuncher",
            "cocks",
            "cocksuck",
            "cocksucked",
            "cocksucker",
            "cocksucking",
            "cocksucks",
            "cocksuka",
            "cocksukka",
            "cok",
            "cokmuncher",
            "coksucka",
            "coon",
            "cox",
            "crap",
            "cum",
            "cummer",
            "cumming",
            "cums",
            "cumshot",
            "cunilingus",
            "cunillingus",
            "cunnilingus",
            "cunt",
            "cuntlick",
            "cuntlicker",
            "cuntlicking",
            "cunts",
            "cyalis",
            "cyberfuc",
            "cyberfuck",
            "cyberfucked",
            "cyberfucker",
            "cyberfuckers",
            "cyberfucking",
            "d1ck",
            "damn",
            "dick",
            "dickhead",
            "dildo",
            "dildos",
            "dink",
            "dinks",
            "dirsa",
            "dlck",
            "dog-fucker",
            "doggin",
            "dogging",
            "donkeyribber",
            "doosh",
            "duche",
            "dyke",
            "ejaculate",
            "ejaculated",
            "ejaculates",
            "ejaculating",
            "ejaculatings",
            "ejaculation",
            "ejakulate",
            "fuck",
            "fucker",
            "f4nny",
            "fag",
            "fagging",
            "faggitt",
            "faggot",
            "faggs",
            "fagot",
            "fagots",
            "fags",
            "fanny",
            "fannyflaps",
            "fannyfucker",
            "fanyy",
            "fatass",
            "fcuk",
            "fcuker",
            "fcuking",
            "feck",
            "fecker",
            "felching",
            "fellate",
            "fellatio",
            "fingerfuck",
            "fingerfucked",
            "fingerfucker",
            "fingerfuckers",
            "fingerfucking",
            "fingerfucks",
            "fistfuck",
            "fistfucked",
            "fistfucker",
            "fistfuckers",
            "fistfucking",
            "fistfuckings",
            "fistfucks",
            "flange",
            "fook",
            "fooker",
            "fuck",
            "fucka",
            "fucked",
            "fucker",
            "fuckers",
            "fuckhead",
            "fuckheads",
            "fuckin",
            "fucking",
            "fuckings",
            "fuckingshitmotherfucker",
            "fuckme",
            "fucks",
            "fuckwhit",
            "fuckwit",
            "fudgepacker",
            "fudgepacker",
            "fuk",
            "fuker",
            "fukker",
            "fukkin",
            "fuks",
            "fukwhit",
            "fukwit",
            "fux",
            "fux0r",
            "f_u_c_k",
            "gangbang",
            "gangbanged",
            "gangbangs",
            "gaylord",
            "gaysex",
            "goatse",
            "God",
            "god-dam",
            "god-damned",
            "goddamn",
            "goddamned",
            "hardcoresex",
            "hell",
            "heshe",
            "hoar",
            "hoare",
            "hoer",
            "homo",
            "hore",
            "horniest",
            "horny",
            "hotsex",
            "jack-off",
            "jackoff",
            "jap",
            "jerk-off",
            "jism",
            "jiz",
            "jizm",
            "jizz",
            "kawk",
            "knob",
            "knobead",
            "knobed",
            "knobend",
            "knobhead",
            "knobjocky",
            "knobjokey",
            "kock",
            "kondum",
            "kondums",
            "kum",
            "kummer",
            "kumming",
            "kums",
            "kunilingus",
            "l3i+ch",
            "l3itch",
            "labia",
            "lmfao",
            "lust",
            "lusting",
            "m0f0",
            "m0fo",
            "m45terbate",
            "ma5terb8",
            "ma5terbate",
            "masochist",
            "master-bate",
            "masterb8",
            "masterbat*",
            "masterbat3",
            "masterbate",
            "masterbation",
            "masterbations",
            "masturbate",
            "mo-fo",
            "mof0",
            "mofo",
            "mothafuck",
            "mothafucka",
            "mothafuckas",
            "mothafuckaz",
            "mothafucked",
            "mothafucker",
            "mothafuckers",
            "mothafuckin",
            "mothafucking",
            "mothafuckings",
            "mothafucks",
            "motherfucker",
            "motherfuck",
            "motherfucked",
            "motherfucker",
            "motherfuckers",
            "motherfuckin",
            "motherfucking",
            "motherfuckings",
            "motherfuckka",
            "motherfucks",
            "muff",
            "mutha",
            "muthafecker",
            "muthafuckker",
            "muther",
            "mutherfucker",
            "n1gga",
            "n1gger",
            "nazi",
            "nigg3r",
            "nigg4h",
            "nigga",
            "niggah",
            "niggas",
            "niggaz",
            "nigger",
            "niggers",
            "nob",
            "nobjokey",
            "nobhead",
            "nobjocky",
            "nobjokey",
            "numbnuts",
            "nutsack",
            "orgasim",
            "orgasims",
            "orgasm",
            "orgasms",
            "p0rn",
            "pawn",
            "pecker",
            "penis",
            "penisfucker",
            "phonesex",
            "phuck",
            "phuk",
            "phuked",
            "phuking",
            "phukked",
            "phukking",
            "phuks",
            "phuq",
            "pigfucker",
            "pimpis",
            "piss",
            "pissed",
            "pisser",
            "pissers",
            "pisses",
            "pissflaps",
            "pissin",
            "pissing",
            "pissoff",
            "poop",
            "porn",
            "porno",
            "pornography",
            "pornos",
            "prick",
            "pricks",
            "pron",
            "pube",
            "pusse",
            "pussi",
            "pussies",
            "pussy",
            "pussys",
            "rectum",
            "retard",
            "rimjaw",
            "rimming",
            "shit",
            "s.o.b.",
            "sadist",
            "schlong",
            "screwing",
            "scroat",
            "scrote",
            "scrotum",
            "semen",
            "sex",
            "sh!+",
            "sh!t",
            "sh1t",
            "shag",
            "shagger",
            "shaggin",
            "shagging",
            "shemale",
            "shi+",
            "shit",
            "shitdick",
            "shite",
            "shited",
            "shitey",
            "shitfuck",
            "shitfull",
            "shithead",
            "shiting",
            "shitings",
            "shits",
            "shitted",
            "shitter",
            "shitters",
            "shitting",
            "shittings",
            "shitty",
            "skank",
            "slut",
            "sluts",
            "smegma",
            "smut",
            "snatch",
            "son-of-a-bitch",
            "spac",
            "spunk",
            "s_h_i_t",
            "t1tt1e5",
            "t1tties",
            "teets",
            "teez",
            "testical",
            "testicle",
            "tit",
            "titfuck",
            "tits",
            "titt",
            "tittie5",
            "tittiefucker",
            "titties",
            "tittyfuck",
            "tittywank",
            "titwank",
            "tosser",
            "turd",
            "tw4t",
            "twat",
            "twathead",
            "twatty",
            "twunt",
            "twunter",
            "v14gra",
            "v1gra",
            "vagina",
            "viagra",
            "vulva",
            "w00se",
            "wang",
            "wank",
            "wanker",
            "wanky",
            "whoar",
            "whore",
            "willies",
            "willy",
            "xrated",
            "xxx",
        ],
    ],

    'password'            => [

        'history'    => [
            /**
             * The table name to save your password histories.
             */
            'table'      => 'enekia_password_reset_histories',

            /**
             * The shows the number of password you want to keep and check for the current user.
             */
            'max_count'  => 100,

            /**
             * The models to be observed on and your password column name.
             */
            'observer'   => [
                'model'  =>  User::class,
                'column' => 'password',
            ],
        ],

        'zxcvbn'     => [
            'min_score' => env('ENEKIA_ZXCVBN_MIN_SCORE', 4),
        ]
    ],

    'remote_rule'         => [
        /*
        |--------------------------------------------------------------------------
        | Config model
        |--------------------------------------------------------------------------
        |
        | Here you may specify the fully qualified class name of the config model.
        |
        */

        'config_model' => Simtabi\Enekia\Laravel\Models\RemoteRuleConfig::class,

        /*
        |--------------------------------------------------------------------------
        | Attribute cast
        |--------------------------------------------------------------------------
        |
        | Here you may specify the cast type for all model attributes who contain
        | sensitive data.
        | All attributes listed below will be encrypted by default when creating or
        | updating a model instance. You can disable this behaviour by removing
        | the attribute cast from the array.
        |
        */

        'attribute_cast' => [
            'url' => 'encrypted',
            'method' => 'encrypted',
            'headers' => 'encrypted:array',
            'json' => 'encrypted:array',
        ],

        /*
        |--------------------------------------------------------------------------
        | Debug mode
        |--------------------------------------------------------------------------
        |
        | Here you may enable or disable the debug mode. If enabled, the rule will
        | throw an exception instead of validating the attribute.
        |
        */

        'debug' => false,
    ],

    'email_domain'        => [
        /*
        |--------------------------------------------------------------------------
        | Email Domain model
        |--------------------------------------------------------------------------
        |
        | Here you may specify the fully qualified class name of the email domain model.
        |
        */

        'model' => Simtabi\Enekia\Laravel\Models\EmailDomain::class,

        /*
        |--------------------------------------------------------------------------
        | Email Domain wildcard
        |--------------------------------------------------------------------------
        |
        | Here you may specify the character used as wildcard for all email domains.
        |
        */

        'wildcard' => '*',
    ],

    'disposable'          => [
        'domain' => [
            /*
            |--------------------------------------------------------------------------
            | JSON Source URL
            |--------------------------------------------------------------------------
            |
            | The source URL yielding a list of disposable email domains. Change this
            | to whatever source you like. Just make sure it returns a JSON array.
            |
            | A sensible default is provided using jsDelivr's services. jsDelivr is
            | a free service, so there are no uptime or support guarantees.
            |
            */

            'source' => 'https://cdn.jsdelivr.net/gh/disposable/disposable-email-domains@master/domains.json',

            /*
            |--------------------------------------------------------------------------
            | Fetch class
            |--------------------------------------------------------------------------
            |
            | The class responsible for fetching the contents of the source url.
            | The default implementation makes use of file_get_contents and
            | json_decode and will probably suffice for most applications.
            |
            | If your application has different needs (e.g. behind a proxy) then you
            | can define a custom fetch class here that carries out the fetching.
            | Your custom class should implement the Fetcher contract.
            |
            */

            'fetcher' => DomainFetcher::class,

            /*
            |--------------------------------------------------------------------------
            | Storage Path
            |--------------------------------------------------------------------------
            |
            | The location where the retrieved domains list should be stored locally.
            | The path should be accessible and writable by the web server. A good
            | place for storing the list is in the framework's own storage path.
            |
            */

            'storage' => storage_path('framework/enekia/disposable/domains.json'),

            /*
            |--------------------------------------------------------------------------
            | Cache Configuration
            |--------------------------------------------------------------------------
            |
            | Here you may define whether the disposable domains list should be cached.
            | If you disable caching or when the cache is empty, the list will be
            | fetched from local storage instead.
            |
            | You can optionally specify an alternate cache connection or modify the
            | cache key as desired.
            |
            */

            'cache' => [
                'enabled' => true,
                'store'   => 'default',
                'key'     => 'disposable_domain:domains',
            ],

            /*
            |--------------------------------------------------------------------------
            | Database storing
            |--------------------------------------------------------------------------
            |
            | Decide whether the requested domains & email addresses should be
            | stored to the database.
            |
            */

            // Database storage enabled
            'store_checks' => true,

            // Database table name
            'checks_table' => 'enekia_validator_mailcheck_api',

            /*
            |--------------------------------------------------------------------------
            | Caching
            |--------------------------------------------------------------------------
            |
            | It is recommended to cache requests due to API rate limitations.
            |
            */

            // Cache enabled (recommended)
            'cache_checks' => true,

            // Duration in minutes to keep the query in cache
            'cache_duration' => 30,


            // Determine which decision should be given if the rate limit is exceeded [allow / deny]
            'decision_rate_limit' => 'allow',

            // Determine which decision should be given if the domain has no MX DNS record [allow / deny]
            'decision_no_mx'      => 'allow',

            // Makes use of the API key
            'key'                 => env('VALIDATOR_MAILCHEK_API_KEY'), // https://www.mailcheck.ai/
        ],
        'phone'  => [
            /*
            |--------------------------------------------------------------------------
            | JSON Source URL
            |--------------------------------------------------------------------------
            |
            | The source URL yielding a list of disposable phone numbers. Change this
            | to whatever source you like. Just make sure it returns a JSON array.
            |
            | A sensible default is provided using jsDelivr's services. jsDelivr is
            | a free service, so there are no uptime or support guarantees.
            |
            */

            'source' => 'https://cdn.jsdelivr.net/gh/iP1SMS/disposable-phone-numbers@master/number-list.json',

            /*
            |--------------------------------------------------------------------------
            | Fetch class
            |--------------------------------------------------------------------------
            |
            | The class responsible for fetching the contents of the source url.
            | The default implementation makes use of file_get_contents and
            | json_decode and will probably suffice for most applications.
            |
            | If your application has different needs (e.g. behind a proxy) then you
            | can define a custom fetch class here that carries out the fetching.
            | Your custom class should implement the Fetcher contract.
            |
            */

            'fetcher' => EmailFetcher::class,

            /*
            |--------------------------------------------------------------------------
            | Storage Path
            |--------------------------------------------------------------------------
            |
            | The location where the retrieved numbers list should be stored locally.
            | The path should be accessible and writable by the web server. A good
            | place for storing the list is in the framework's own storage path.
            |
            */

            'storage' => storage_path('framework/enekia/disposable/phone-numbers.json'),

            /*
            |--------------------------------------------------------------------------
            | Cache Configuration
            |--------------------------------------------------------------------------
            |
            | Here you may define whether the disposable numbers list should be cached.
            | If you disable caching or when the cache is empty, the list will be
            | fetched from local storage instead.
            |
            | You can optionally specify an alternate cache connection or modify the
            | cache key as desired.
            |
            */

            'cache' => [
                'enabled' => true,
                'store'   => 'default',
                'key'     => 'disposable_phone.numbers',
            ],
        ]
    ],
];