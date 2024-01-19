<?php

use RBoonzaijer\LaravelMultipleFlashMessages\FlashMessageContainer;

/**
 * Flash a message to the session
 *
 * @param string $message
 * @param array $options
 * @param boolean $flashToSession
 * @return FlashMessageContainer
 */
function flash(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
{
    return app(FlashMessageContainer::class)->flash($message, $options, $flashToSession);
}

/**
 * Flash an info message to the session
 *
 * @param string $message
 * @param array $options
 * @param boolean $flashToSession
 * @return FlashMessageContainer
 */
function flashInfo(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
{
    return app(FlashMessageContainer::class)->flashInfo($message, $options, $flashToSession);
}

/**
 * Flash a success message to the session
 *
 * @param string $message
 * @param array $options
 * @param boolean $flashToSession
 * @return FlashMessageContainer
 */
function flashSuccess(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
{
    return app(FlashMessageContainer::class)->flashSuccess($message, $options, $flashToSession);
}

/**
 * Flash a warning message to the session
 *
 * @param string $message
 * @param array $options
 * @param boolean $flashToSession
 * @return FlashMessageContainer
 */
function flashWarning(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
{
    return app(FlashMessageContainer::class)->flashWarning($message, $options, $flashToSession);
}

/**
 * Flash an error message to the session
 *
 * @param string $message
 * @param array $options
 * @param boolean $flashToSession
 * @return FlashMessageContainer
 */
function flashError(string $message, array $options = [], bool $flashToSession = true): FlashMessageContainer
{
    return app(FlashMessageContainer::class)->flashError($message, $options, $flashToSession);
}

/**
 * Manually flash all in-memory messages to the session (when used 'flashToSession = false')
 * 
 * Example:
 * flash('Saved', [], false);
 * ...
 * if(Auth::user()->hasNotificationsEnabled()) {
 *   flashMessagesToSession();
 * }
 * 
 * @return void
 */
function flashMessagesToSession()
{
    return app(FlashMessageContainer::class)->flashToSession();
}
