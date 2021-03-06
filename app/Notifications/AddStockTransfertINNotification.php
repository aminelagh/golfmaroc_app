<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddStockTransfertINNotification extends Notification
{
  use Queueable;
  protected $user;


  public function __construct($user)
  {
      $this->user=$user;
  }


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
      ->subject('Nouveau transfert de Stock vers le magasin '. \App\Models\Magasin::getLibelle($this->user->id_magasin))
      ->line('Bienvenue dans GolfMaroc-APP votre application de gestion des points de vente du groupe GolfMaroc .')
      ->line('Nous vous informons qu\'un nouveau transfert de stock a eu lieu vers le magasin '. \App\Models\Magasin::getLibelle($this->user->id_magasin))
      ->action('Vous pouvez acceder a votre application ici ', url('http://golfmaroc-001-site1.itempurl.com/public/home'))
      ->line('Merci d\'avoir utilisé notre application' );
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
