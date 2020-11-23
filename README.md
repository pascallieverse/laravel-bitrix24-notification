Laravel Bitrix24 notifications
======================

This package makes it easy to send notifications using the Bitrix Bot Platform with Laravel.

Installation
-----------------------------------

You can install the package via composer:

```php
composer require "pascallieverse/laravel-bitrix24-notification"
```

Next, you must load the service provider:

```php
// config/app.php
'providers' => [
    // ...
    PascalLieverse\Bitrix24\Bitrix24ServiceProvider::class,
],
```

And finally publish the config file:

```php
php artisan vendor:publish --provider="PascalLieverse\Bitrix24\Bitrix24ServiceProvider"
```

Setting up your Bitrix24 bot
-----------------------------------

1. Inside bitrix24 navigate to: Extensions -> Applications -> Developer resources -> Add a chat bot -> Notify employees in the chat.
2. Fill in the required fields to create the bot. The bot type should be "Chat bot, immediate response".
3. Copy the "Webhook to call REST API" url and place this value inside your env file as BITRIX_WEBHOOK_URL.
4. Copy the "Bot CLIENT_ID" and place this value inside your env as BITRIX_BOT_CLIENT_ID.

Usage
-----------------------------------
Now you can create a simple notification as follows:

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use PascalLieverse\Bitrix24\Bitrix24Notifiable;
use PascalLieverse\Bitrix24\Bitrix24Message;

class BitrixNotice extends Notification
{

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [Bitrix24Notifiable::class];
    }

    /**
     * Get the message.
     *
     * @param  mixed  $notifiable
     * @return Bitrix24Message
     */
    public function toBitrix24($notifiable)
    {
        return (new Bitrix24Message())->text("Bitrix notification message!");
    }
}
```

The notification channel expects the user or chat ID to be passed.
For example if the bitrix user ID is 1:

```php
Notification::send(new Bitrix24Notifiable('1'), new BitrixNotice());
```

Or if the chat ID is 1:

```php
Notification::send(new Bitrix24Notifiable('chat1'), new BitrixNotice());
```

License
-----------------------------------

MIT License (MIT). Freely redistributable product.