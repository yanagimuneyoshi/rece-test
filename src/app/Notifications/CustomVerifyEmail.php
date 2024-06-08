<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends Notification
{
  public static $toMailCallback;

  public function via($notifiable)
  {
    return ['mail'];
  }

  protected function verificationUrl($notifiable)
  {
    return URL::temporarySignedRoute(
      'verification.verify',
      Carbon::now()->addMinutes(60),
      ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
    );
  }

  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable);
    }

    $verificationUrl = $this->verificationUrl($notifiable);

    return (new MailMessage)
      ->subject(Lang::get('Verify Email Address'))
      ->line(Lang::get('Click the button below to verify your email address.'))
      ->action(Lang::get('Verify Email Address'), $verificationUrl)
      ->line(Lang::get('If you did not create an account, no further action is required.'));
  }

  public static function toMailUsing($callback)
  {
    static::$toMailCallback = $callback;
  }
}
