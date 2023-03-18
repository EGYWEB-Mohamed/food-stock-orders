<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowIngredientMail extends Mailable
{
    use Queueable,SerializesModels;

    public function __construct(public Ingredient $ingredient)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Low Stock For ( '.$this->ingredient->name.' ) ');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.low-ingredient');
    }

    public function attachments(): array
    {
        return [];
    }
}
