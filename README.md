# Laravel Multiple Flash Messages

- Supports multiple messages at once
- Supports any type of custom options you want (because it's just an array)
- Helper methods that can easily be remembered

## Install

```bash
composer require rboonzaijer/laravel-multiple-flash-messages:^1.0
```

## Usage

```php
class MyController
{
    public function store()
    {
        // ...

        flash('My message');
        flashWarning('My warning message', ['url' => ...]);

        return to_route( ... );
    }
}
```

## Helper methods

These helper methods are available and they all use the same arguments.

- @param string $message ( required ) - Contains the message
- @param array $options ( default = [ ] ) - add additional info in the array
- @param boolean $flashToSession ( default = true ) - optional, see further below for an example

```php
flash($message, $options, $flashToSession);
flashInfo($message, $options, $flashToSession);
flashSuccess($message, $options, $flashToSession);
flashWarning($message, $options, $flashToSession);
flashError($message, $options, $flashToSession);
```

## Blade view example

```blade
{{-- /resources/views/partials/flash-messages.blade.php --}}

@if(session()->has('messages'))
    @foreach(session()->get('messages') as $message)
        <div class="alert alert-{{ $message['type'] }}">
            <span>{{ $message['message'] }}</span>
        </div>
    @endforeach
@endif
```

```blade
{{-- /resources/views/layouts/app.blade.php --}}

<div class="flash-messages">
    @include('partials.flash-messages')
</div>
```

## Manually flash to the session

This can be useful if you want to prepare your flash messages, but only show them to the user if a condition is met, for example:

```php
flash(message: 'Saved', options: [], flashToSession: false);

// ..

if(Auth::user()->hasNotificationsEnabled()) {
    // The user wants notifications, so send the messages to the session
    flashMessagesToSession();
}

return to_route(...);
```

## Flexible - Use any type or option

```php
flash($message, [
    'type' => 'dangerous',
    'bg-color' => 'red'
]);
flash($message, [
    'type' => 'happy',
    'bg-color' => 'green'
]);
```

```blade
@foreach(session()->get('messages') as $message)
    <div class="{{ $message['type'] }} bg-{{ $message['bg-color'] }}">
        <span>{{ $message['message'] }}</span>
    </div>
@endforeach
```





### Testing

```
composer run test
```
