<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class CustomVerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $timeLimit = 30;
        $verificationCode = $this->generateVerificationCode();
        $expiration = now()->addMinutes(Config::get('auth.verification.expire', $timeLimit));

        
        // Save the verification code and expiration in the database
        \DB::table('verification_codes')->insert([
            'code' => $verificationCode,
            'expiration' => $expiration,
            'email' => $notifiable->email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Greetings Voters!')
            ->line('Thanks for signing up. Please use the verification code below to verify your email address.')
           
            ->line(new HtmlString('Verification Code: <span style="font-size:  20px; color:#e8eaed; font-weight: bold;">' . $verificationCode . '</span>'))
            ->line('This code will expire on ' . $timeLimit . ' minutes.')
            ->line('If you did not create an account, no further action is required.');
    }

    /**
     * Generate a random verification code.
     *
     * @return string
     */
    protected function generateVerificationCode(): string
    {
        // Customize the code generation logic as per your requirements
        return substr(md5(uniqid()), 0, 6);
    }

    public function from($notifiable)
    {
        return [
            'address' => 'marlonpadilla1593@gmail.com',
            'name' => 'Voting.com',
        ];

        
    }
    protected function verificationUrl($notifiable)
{
    return route('verification.verify', [
        'email' => $notifiable->email,
        'code' => $this->verificationCode,
    ]);
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
