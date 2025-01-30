<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskExecutedNotification extends Notification
{
    protected $task;
    protected $email;
    

    public function __construct($task, $email)
    {
        $this->task = $task;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Execution Status')
            ->line('Task ID: ' . $this->task->id)
            ->line('Status: ' . $this->task->status)
            ->line('Description: ' . $this->task->status_description)
            ->line('Exception: ' . $this->task->exception ?? 'None')
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'status' => $this->task->status,
        ];
    }
}

