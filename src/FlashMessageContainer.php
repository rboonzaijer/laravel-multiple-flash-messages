<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class FlashMessageContainer
{
    private $messages = [];

    public function flash(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
    {
        if($message !== null && !empty(trim($message))) {
            $type = $options['type'] ?? 'default';

            $this->messages[] = new FlashMessage($message, $type, $options);
        }

        if($flashToSession) {
            $this->flashToSession();
        }
        return $this;
    }

    public function flashInfo(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
    {
        return $this->flash($message, array_merge($options, ['type' => 'info']), $flashToSession);
    }

    public function flashSuccess(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
    {
        return $this->flash($message, array_merge($options, ['type' => 'success']), $flashToSession);
    }

    public function flashWarning(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
    {
        return $this->flash($message, array_merge($options, ['type' => 'warning']), $flashToSession);
    }

    public function flashError(string $message, array $options = [], $flashToSession = true): FlashMessageContainer
    {
        return $this->flash($message, array_merge($options, ['type' => 'error']), $flashToSession);
    }

    public function toArray(): array
    {
        return Arr::map($this->messages, function($message) {
            return $message->toArray();
        });
    }

    public function flashToSession(): void
    {
        $messages = $this->toArray();

        if(!empty($messages)) {
            Session::flash('messages',  $messages);
        }
    }
}
