<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Notif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $aksi, $isi, $id_user, $id_foto;
    public function __construct($aksi, $isi, $id_user, $id_foto)
    {
        $this->aksi = $aksi;
        $this->isi = $isi;
        $this->id_user = $id_user;
        $this->id_foto = $id_foto;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'aksi' => $this->aksi,
            'message' => $this->isi,
            'id_user' => $this->id_user,
            'id_foto' => $this->id_foto
        ];
    }
}
