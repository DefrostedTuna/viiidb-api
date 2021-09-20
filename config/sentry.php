<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data Source Name
    |--------------------------------------------------------------------------
    |
    | The DSN tells Sentry where to send events so that the events are
    | associated with the correct project. This can be found within
    | Sentry, and is required to forward application exceptions.
    |
    */

    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    /*
    |--------------------------------------------------------------------------
    | Sentry Environment
    |--------------------------------------------------------------------------
    |
    | The Sentry environment will determine which environment Sentry will use
    | use to report exceptions. This may be set explicitly by the user, or
    | implicitly by using the environment this is specified by Laravel.
    |
    */

    'environment' => env('SENTRY_ENVIRONMENT'),

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Breadcrumbs will help to add context to an exception. Enabling these
    | options will include the associated context within any exceptions
    | that may be thrown. Options may be enabled or disabled freely.
    |
    */

    'breadcrumbs' => [
        'logs' => true,
        'sql_queries' => true,
        'sql_bindings' => true,
        'queue_info' => true,
        'command_info' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracing
    |--------------------------------------------------------------------------
    |
    | Tracing will also help to add context to an exception. Tracing exceptions
    | will attempt to narrow down the cause of any exceptions that happen to
    | be thrown via the system. These options may also be toggled freely.
    |
    */

    'tracing' => [
        'queue_job_transactions' => env('SENTRY_TRACE_QUEUE_ENABLED', false),
        'queue_jobs' => true,
        'sql_queries' => true,
        'sql_origin' => true,
        'views' => true,
        'default_integrations' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Send Default PII
    |--------------------------------------------------------------------------
    |
    | If this flag is enabled, certain personally identifiable information
    | (PII) is added by active integrations. By default no such data is
    | sent. If it is possible we recommend toggling this feature on.
    |
    | https://docs.sentry.io/platforms/php/configuration/options/#send-default-pii
    |
    */

    'send_default_pii' => false,

    /*
    |--------------------------------------------------------------------------
    | Traces Sample Rate
    |--------------------------------------------------------------------------
    |
    | Configures the sample rate for error events, in the range of 0.0 to 1.0.
    | The default setting is 1.0, which means that 100% of errors are sent.
    | If set to .1 only 10% will be sent. Events are picked up randomly.
    |
    */

    'traces_sample_rate' => (float) (env('SENTRY_TRACES_SAMPLE_RATE', 0.0)),

    /*
    |--------------------------------------------------------------------------
    | Controller Base Namespace
    |--------------------------------------------------------------------------
    |
    | Performance monitoring and router breadcrumbs can report the controller
    | classname that handled the request. These names are generally longer
    | than they need to be. This is why the namespace is being removed.
    |
    */

    'controllers_base_namespace' => env('SENTRY_CONTROLLERS_BASE_NAMESPACE', 'App\\Http\\Controllers'),
];
