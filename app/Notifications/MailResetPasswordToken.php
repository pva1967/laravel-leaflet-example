<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class MailResetPasswordToken extends Notification
{
    use Queueable;
    public $name, $token, $is_Admin;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $name, $is_Admin)
    {
        //
        $this->name = $name;
        $this->token = $token;
        $this->is_Admin = $is_Admin;

    }

    /**
     * Get the notificationnames delivery channels.
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
        if ($this->is_Admin) {
            return (new MailMessage)
                ->subject('Регистрация на monitor.eduroam.ru')
                ->line("Уважаемый {$this->name}. Вы зарегистрированы на сайте monitor.eduroam.ru как администартор eduroam своей организации. Для окончания регистрации пройдите по ссылке.")
                ->action('Закончить регистрацию', url('admin/password/reset', $this->token));
        }
        else {
            return (new MailMessage)
                ->subject('Запрос на восстановление забытого пароля')
                ->line("Уважаемый {$this->name}. Вы сделали запрос на получение забытого пароля на сайте monitor.eduroam.ru ")
                ->action('Сменить пароль', url('password/reset', $this->token))
                ->line('Если вы не отправляли запрос, просто удалите это письмо. Благодарим за использование сервиса.');
        }
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
