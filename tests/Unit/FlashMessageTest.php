<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages\Tests\Unit;

use Illuminate\Support\Facades\Session;
use RBoonzaijer\LaravelMultipleFlashMessages\FlashMessage;
use RBoonzaijer\LaravelMultipleFlashMessages\FlashMessageContainer;
use RBoonzaijer\LaravelMultipleFlashMessages\Tests\TestCase;

class FlashMessageTest extends TestCase
{
    /** @test */
    public function it_can_set_a_flash_message_using_a_helper()
    {
        flash('My Message');

        $this->assertEquals([['message' => 'My Message', 'type' => 'default']], Session::get('messages'));
    }

    /** @test */
    public function it_can_set_a_flash_message_using_the_container()
    {
        $container = new FlashMessageContainer();
        $container->flash('My Message');

        $this->assertEquals([['message' => 'My Message', 'type' => 'default']], Session::get('messages'));
    }

    /** @test */
    public function it_can_set_a_flash_message_using_the_app_method()
    {
        app(FlashMessageContainer::class)->flash('My Other Message');

        $this->assertEquals([['message' => 'My Other Message', 'type' => 'default']], Session::get('messages'));
    }

    /**
     * @test
     * @dataProvider provider_it_can_set_other_types_of_flash_messages_using_a_helper
     */
    public function it_can_set_other_types_of_flash_messages_using_a_helper($expected, $method)
    {
        $method('My Message');

        $this->assertEquals($expected, Session::get('messages'));
    }
    public static function provider_it_can_set_other_types_of_flash_messages_using_a_helper()
    {
        return [
            'flash()' => [       [['message' => 'My Message', 'type' => 'default']], 'flash'],
            'flashInfo()' => [   [['message' => 'My Message', 'type' => 'info']],    'flashInfo'],
            'flashSuccess()' => [[['message' => 'My Message', 'type' => 'success']], 'flashSuccess'],
            'flashWarning()' => [[['message' => 'My Message', 'type' => 'warning']], 'flashWarning'],
            'flashError()' => [  [['message' => 'My Message', 'type' => 'error']],   'flashError'],
        ];
    }

    /**
     * @test
     * @dataProvider provider_it_can_flash_a_message_with_custom_options
     */
    public function it_can_flash_a_message_with_custom_options($expected, $input)
    {
        $method = $input[0];
        $message = $input[1];
        $options = $input[2];
        
        $method($message, $options);

        $this->assertEquals($expected, Session::get('messages'));
    }
    public static function provider_it_can_flash_a_message_with_custom_options()
    {
        return [
            'flash()' => [       [['message' => 'My Message',         'type' => 'default', 'id' => 50, 'color' => 'white']],  ['flash',        'My Message',         ['id' => 50, 'color' => 'white']]],
            'flashInfo()' => [   [['message' => 'My Info Message',    'type' => 'info',    'id' => 51, 'color' => 'blue']],   ['flashInfo',    'My Info Message',    ['id' => 51, 'color' => 'blue']]],
            'flashSuccess()' => [[['message' => 'My Success Message', 'type' => 'success', 'id' => 52, 'color' => 'green']],  ['flashSuccess', 'My Success Message', ['id' => 52, 'color' => 'green']]],
            'flashWarning()' => [[['message' => 'My Warning Message', 'type' => 'warning', 'id' => 53, 'color' => 'yellow']], ['flashWarning', 'My Warning Message', ['id' => 53, 'color' => 'yellow']]],
            'flashError()' => [  [['message' => 'My Error Message',   'type' => 'error',   'id' => 54, 'color' => 'red']],    ['flashError',   'My Error Message',   ['id' => 54, 'color' => 'red']]],
        ];
    }

    /**
     * @test
     * @dataProvider provider_it_overrides_the_custom_type_when_used_any_other_method_then_the_default_flash
     */
    public function it_overrides_the_custom_type_when_used_any_other_method_then_the_default_flash($expected, $input)
    {
        $method = $input[0];
        $message = $input[1];
        $options = $input[2];
        
        $method($message, $options);

        $this->assertEquals($expected, Session::get('messages'));
    }
    public static function provider_it_overrides_the_custom_type_when_used_any_other_method_then_the_default_flash()
    {
        return [
            'flash()' => [       [['message' => 'My Message', 'type' => 'CUSTOM-WHITE']],    ['flash',        'My Message',         ['type' => 'CUSTOM-WHITE']]],
            'flashInfo()' => [   [['message' => 'My Info Message', 'type' => 'info']],       ['flashInfo',    'My Info Message',    ['type' => 'CUSTOM-INFO-OVERWRITTEN']]],
            'flashSuccess()' => [[['message' => 'My Success Message', 'type' => 'success']], ['flashSuccess', 'My Success Message', ['type' => 'CUSTOM-GREEN-OVERWRITTEN']]],
            'flashWarning()' => [[['message' => 'My Warning Message', 'type' => 'warning']], ['flashWarning', 'My Warning Message', ['type' => 'CUSTOM-YELLOW-OVERWRITTEN']]],
            'flashError()' => [  [['message' => 'My Error Message', 'type' => 'error']],     ['flashError',   'My Error Message',   ['type' => 'CUSTOM-RED-OVERWRITTEN']]],
        ];
    }

    /**
     * @test
     * @dataProvider provider_it_can_stay_in_memory_until_you_flash_to_session
     */
    public function it_can_stay_in_memory_until_you_flash_to_session($expected, $method)
    {
        $method('My Message', [], false);

        $this->assertNull(Session::get('messages'));

        flashMessagesToSession();

        $this->assertEquals($expected, Session::get('messages'));
    }
    public static function provider_it_can_stay_in_memory_until_you_flash_to_session()
    {
        return [
            'flash()' => [       [['message' => 'My Message', 'type' => 'default']], 'flash'],
            'flashInfo()' => [   [['message' => 'My Message', 'type' => 'info']],    'flashInfo'],
            'flashSuccess()' => [[['message' => 'My Message', 'type' => 'success']], 'flashSuccess'],
            'flashWarning()' => [[['message' => 'My Message', 'type' => 'warning']], 'flashWarning'],
            'flashError()' => [  [['message' => 'My Message', 'type' => 'error']],   'flashError'],
        ];
    }

    /** @test */
    public function it_can_flash_multiple_messages()
    {
        flash('My Message');
        flash('My Second Message');
        flashInfo('My Info Message');
        flashSuccess('My Success Message');
        flashWarning('My Warning Message');
        flashError('My Error Message');

        $this->assertEquals([
            ['message' => 'My Message',         'type' => 'default'],
            ['message' => 'My Second Message',  'type' => 'default'],
            ['message' => 'My Info Message',    'type' => 'info'],
            ['message' => 'My Success Message', 'type' => 'success'],
            ['message' => 'My Warning Message', 'type' => 'warning'],
            ['message' => 'My Error Message',   'type' => 'error'],
        ], Session::get('messages'));
    }

    /** @test */
    public function it_can_flash_multiple_messages_fluently()
    {
        flash('My Message')
            ->flash('My Second Message')
            ->flashInfo('My Info Message')
            ->flashSuccess('My Success Message')
            ->flashWarning('My Warning Message')
            ->flashError('My Error Message');

        $this->assertEquals([
            ['message' => 'My Message',         'type' => 'default'],
            ['message' => 'My Second Message',  'type' => 'default'],
            ['message' => 'My Info Message',    'type' => 'info'],
            ['message' => 'My Success Message', 'type' => 'success'],
            ['message' => 'My Warning Message', 'type' => 'warning'],
            ['message' => 'My Error Message',   'type' => 'error'],
        ], Session::get('messages'));
    }

    /** @test */
    public function it_can_flash_without_the_helper_methods()
    {
        app(FlashMessageContainer::class)->flash('My Message');
        app(FlashMessageContainer::class)->flash('My Second Message');
        app(FlashMessageContainer::class)->flashInfo('My Info Message');
        app(FlashMessageContainer::class)->flashSuccess('My Success Message');
        app(FlashMessageContainer::class)->flashWarning('My Warning Message');
        app(FlashMessageContainer::class)->flashError('My Error Message');

        $this->assertEquals([
            ['message' => 'My Message',         'type' => 'default'],
            ['message' => 'My Second Message',  'type' => 'default'],
            ['message' => 'My Info Message',    'type' => 'info'],
            ['message' => 'My Success Message', 'type' => 'success'],
            ['message' => 'My Warning Message', 'type' => 'warning'],
            ['message' => 'My Error Message',   'type' => 'error'],
        ], Session::get('messages'));
    }

    /** @test */
    public function it_can_flash_without_the_helper_methods_fluently()
    {
        app(FlashMessageContainer::class)->flash('My Message')
            ->flash('My Second Message')
            ->flashInfo('My Info Message')
            ->flashSuccess('My Success Message')
            ->flashWarning('My Warning Message')
            ->flashError('My Error Message');
        
        $this->assertEquals([
            ['message' => 'My Message',         'type' => 'default'],
            ['message' => 'My Second Message',  'type' => 'default'],
            ['message' => 'My Info Message',    'type' => 'info'],
            ['message' => 'My Success Message', 'type' => 'success'],
            ['message' => 'My Warning Message', 'type' => 'warning'],
            ['message' => 'My Error Message',   'type' => 'error'],
        ], Session::get('messages'));
    }

    /**
     * @test
     * @dataProvider provider_all_methods_expected_empty
     */
    public function it_can_not_flash_an_empty_message($expected, $method)
    {
        $method('');

        $this->assertNull(Session::get('messages'));
    }

    /**
     * @test
     * @dataProvider provider_all_methods_expected_empty
     */
    public function it_can_not_flash_a_whitespace_message($expected, $method)
    {
        $method(' ');

        $this->assertNull(Session::get('messages'));
    }

    public static function provider_all_methods_expected_empty()
    {
        return [
            'flash()' =>        [null, 'flash'],
            'flashInfo()' =>    [null, 'flashInfo'],
            'flashSuccess()' => [null, 'flashSuccess'],
            'flashWarning()' => [null, 'flashWarning'],
            'flashError()' =>   [null, 'flashError'],
        ];
    }

    /**
     * @test
     */
    public function it_has_internal_methods()
    {
        $message = new Flashmessage();
        $message->setMessage('My Message');
        $message->setType('success');
        $message->setOptions([
            'colors' => [
                'background' => 'green',
                'foreground' => 'white',
            ],
            'id' => 123
        ]);

        $this->assertEquals('My Message', $message->getMessage());
        $this->assertEquals('success', $message->getType());
        $this->assertEquals([
            'colors' => [
                'background' => 'green',
                'foreground' => 'white'
            ],
            'id' => 123], $message->getOptions());

        $this->assertEquals(123, $message->getOption('id'));
        $this->assertEquals(null, $message->getOption('non-existing-key'));
        $this->assertEquals([
            'background' => 'green',
            'foreground' => 'white'
        ], $message->getOption('colors'));

        $this->assertEquals('green', $message->getOption('colors.background'));

        $message->setOption('colors.background', 'blue');
        $this->assertEquals('blue', $message->getOption('colors.background'));
    }
}
