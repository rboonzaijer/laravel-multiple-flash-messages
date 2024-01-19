# Laravel Multiple Flash Messages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rboonzaijer/laravel-multiple-flash-messages.svg?style=flat)](https://packagist.org/packages/rboonzaijer/laravel-multiple-flash-messages)
[![MIT License](https://img.shields.io/github/license/rboonzaijer/laravel-multiple-flash-messages?style=flat
)](https://github.com/rboonzaijer/laravel-multiple-flash-messages/blob/main/LICENSE.md)

[![tests](https://github.com/rboonzaijer/laravel-multiple-flash-messages/actions/workflows/tests.yml/badge.svg)](https://github.com/rboonzaijer/laravel-multiple-flash-messages/actions/workflows/tests.yml)
[![tests](https://shields.io/badge/style-8.3-green?label=php&style=flat)](https://github.com/rboonzaijer/laravel-multiple-flash-messages/actions/workflows/tests.yml)
[![tests](https://shields.io/badge/style-8.2-green?label=php&style=flat)](https://github.com/rboonzaijer/laravel-multiple-flash-messages/actions/workflows/tests.yml)
[![tests](https://shields.io/badge/style-8.1-green?label=php&style=flat)](https://github.com/rboonzaijer/laravel-multiple-flash-messages/actions/workflows/tests.yml)

- Supports flashing **multiple messages** to the session
- **Flexible messages** - fill the `$options` array with your custom data
- Helper methods that can easily be remembered and allows **clean controllers**
- **Inertia + Vue** implementation example included below
- Automated tests running on Laravel 10

## Install

```bash
composer require rboonzaijer/laravel-multiple-flash-messages:^1.0
```

## Usage

```php
class UserController
{
    public function store()
    {
        // ...

        flash('User created');

        flashWarning('User has no permissions yet');

        return to_route(...);
    }
```

## Blade view example

```blade
{{-- /resources/views/layouts/app.blade.php --}}

@include('partials.flash-messages.container')
```

```blade
{{-- /resources/views/partials/flash-messages/container.blade.php --}}

@if(session()->has('messages'))
    <div class="flash-messages">
        @foreach(session()->get('messages') as $index => $message)
            @include('partials.flash-messages.message', [
                'index' => $index,
                'message' => $message
            ])
        @endforeach
    </div>
@endif
```

```blade
{{-- /resources/views/partials/flash-messages/message.blade.php --}}

<div class="alert alert-{{ $message['type'] }}" onclick="javascript:this.remove();">
    <span>{{ $message['message'] }}</span>
</div>
```


## Flexible - Use your own message types and custom data

```php
flash('Flagged', [
    'type' => 'danger-flagged',
    'description' => 'You have been flagged for creating to many users',
    'details' => [
        'ticket' => 123,
        'urls' => [
            'https://example.com',
            'http://example.com',
        ]
    ]
]);
```

```blade
{{-- /resources/views/partials/flash-messages/message.blade.php --}}

<div class="{{ $message['type'] }}" id="flash-message-{{ $index }}">
    <span class="title">
        {{ $message['message'] }}

        @if(isset($message['details']['ticket']))
            <span>- Ticket #{{ $message['details']['ticket'] }}</span>
        @endif
    </span>

    @if(isset($message['description']))
        <p class="description">
            {{ $message['description'] }}
        </p>
    @endif

    @if(isset($message['details']['urls']))
        <ul class="urls">
            @foreach($message['details']['urls'] as $index => $url)
                <li>
                    <a href="{{ $url }}">
                        {{ $url }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
```

## Helper methods

These helper methods are available and they all use the same arguments.

- @param string $message ( required ) - Contains the message
- @param array $options ( default = [ ] ) - add additional info in the array
- @param boolean $flashToSession ( default = true ) - for special use cases (see below)

```php
flash($message, $options, $flashToSession);
flashInfo($message, $options, $flashToSession);
flashSuccess($message, $options, $flashToSession);
flashWarning($message, $options, $flashToSession);
flashError($message, $options, $flashToSession);
```

## Manually flash to the session

This can be used if you want to send the messages only if a certain condition is met, for example:

```php
flash('Saved', [], Auth::user()->hasNotificationsEnabled());
```

or

```php
flash('Saved', [], false);

// ...

if(Auth::user()->hasNotificationsEnabled()) {
    flashMessagesToSession();
}
```

## Inertia + Vue + Tailwind + DaisyUI example

- https://inertiajs.com/pages#persistent-layouts
- https://inertiajs.com/pages#default-layouts
- https://tailwindcss.com/docs/guides/laravel
- https://daisyui.com/components/toast/

```php
// app/Http/Middleware/HandleInertiaRequests.php

public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'messages' => fn () => session()->get('messages'),
    ]);
}
```

```vue
<script setup>
/* /resources/js/Shared/Layout.vue */

import FlashMessages  from '../Shared/FlashMessages.vue';
</script>

<template>
    <!-- ... -->

    <FlashMessages />

    <!-- ... -->
</template>
```

```vue
<!-- /resources/js/Shared/FlashMessages.vue -->

<template>
    <div v-if="$page.props.messages" class="toast toast-top toast-end">
        <div v-for="message, index in $page.props.messages" :key="index" class="flex justify-between alert" :class="'alert-' + message['type']">
            <span>{{ message['message'] }}</span>

            <span class="btn btn-xs" @click="$page.props.messages.splice(index, 1)">x</span>
            <!-- Note: officially you should not remove props like this, but for messages I see no issue... -->
        </div>
    </div>
</template>
```

```js
/* tailwind.config.js */
/* Don't forget to set a safelist for classes that should always be available */

safelist: [
    'toast',
    'toast-top',
    'toast-end',
    'alert',
    'alert-info',
    'alert-success',
    'alert-warning',
    'alert-error',
],
```

## Testing

```
composer run test
```
