<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages;

use Illuminate\Support\Arr;

class FlashMessage
{
    private string $message;
    private string $type;
    private array $options = [];

    public function __construct($message = '', $type = 'default', $options = [])
    {
        $this->message = $message;
        $this->type = $type;
        $this->options = $options;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage($message): FlashMessage
    {
        $this->message = $message;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): FlashMessage
    {
        $this->type = $type;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): FlashMessage
    {
        $this->options = (array)$options;

        return $this;
    }

    public function getOption(string $key): mixed
    {
        return Arr::get($this->options, $key);
    }

    public function setOption(string $key, string $value): FlashMessage
    {
        Arr::set($this->options, $key, $value);

        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->options, [
            'message' => $this->message,
            'type' => $this->type,
        ]);
    }
}
