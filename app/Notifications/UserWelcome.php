<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcome extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
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
                    ->subject('Boas-vindas ao Practice Forms!')
                    ->greeting('Olá, ' . $notifiable->first_name)
                    ->line('A partir desse momento, você não vai mais passar trabalho para criar formulários (e coletar respostas)🥳 O [Practice Forms]('.route('index').') é uma ferramenta para ajudar com criação de perguntas e respostas online.')
                    ->line('Para acessar o [Practice Forms]('.route('index').'), visite ['. route('index').']('.route('index').') ou clique no botão abaixo:')
                    ->action('Acessar Practice Forms', route('index'))
                    ->line("Confira o que o Practice Forms tem a oferecer:")
                    ->line('- **Praticidade**: criar questionários não precisa ser complicado, almejamos o simples e fácil. 🙌')
                    ->line('- **Texto é a ferramenta**: escreva perguntas como se fosse enviar um e-mail, deixe o [Practice Forms]('.route('index').') criar o questionário digital. 🚀')
                    ->line('- **Visualização**: respostas em tempo real, com relatórios, gráficos exportáveis como figuras e mais! 🎉')
                    ->line("Que tal testar tudo e criar um questionário agora? Apostamos que criar e compartilhar leva menos de 2 minutos (estamos falando sério).")
                    ->line("Até mais,")
                    ->salutation("Equipe Practice ❤️");
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
