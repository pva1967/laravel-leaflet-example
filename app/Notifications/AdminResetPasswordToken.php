<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordToken extends Notification
{
    use Queueable;
    public $name, $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $name)
    {
        $this->token=$token;
        $this->name=$name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Уважаемый {$this->name}. Вы сделали запрос на получение забытого пароля суперадмина на сайте monitor.eduroam.ru ")
            ->action('Сменить пароль', url('admin/password/reset', $this->token))
            ->line('Если вы не отправляли запрос, просто удалите это письмо. Благодарим за использование сервиса.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
