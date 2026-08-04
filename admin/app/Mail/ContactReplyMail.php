<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Contact $contact,
        public string $reply
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resposta da TSHOOT Soluções Tecnológicas - ' . $this->contact->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    private function buildHtml(): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 0; padding: 40px 20px; color: #333; }
                .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
                .header { background: linear-gradient(135deg, #1B2A41, #243652); padding: 30px; text-align: center; }
                .header img { height: 50px; margin-bottom: 10px; }
                .header h1 { color: #D4A11D; font-size: 20px; margin: 0; }
                .header p { color: #94A3B8; font-size: 12px; margin: 5px 0 0; }
                .body { padding: 30px; }
                .greeting { font-size: 16px; color: #1B2A41; margin-bottom: 20px; }
                .message-box { background: #f8f9fa; border-left: 4px solid #D4A11D; padding: 20px; margin: 20px 0; border-radius: 0 8px 8px 0; }
                .message-box p { margin: 0; line-height: 1.7; color: #555; }
                .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #eee; }
                .footer p { margin: 5px 0; font-size: 12px; color: #888; }
                .footer a { color: #D4A11D; text-decoration: none; }
                .divider { height: 1px; background: #eee; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>TSHOOT</h1>
                    <p>Soluções Tecnológicas</p>
                </div>
                <div class="body">
                    <p class="greeting">Olá <strong>' . htmlspecialchars($this->contact->name) . '</strong>,</p>
                    <p>Obrigado por entrar em contacto connosco. A sua mensagem foi recebida e eis a nossa resposta:</p>
                    <div class="message-box">
                        <p><strong>Assunto:</strong> ' . htmlspecialchars($this->contact->subject) . '</p>
                    </div>
                    <div class="message-box">
                        <p>' . nl2br(htmlspecialchars($this->reply)) . '</p>
                    </div>
                    <div class="divider"></div>
                    <p style="color:#666; font-size:14px;">Se tiver mais alguma dúvida, não hesite em contactar-nos.</p>
                </div>
                <div class="footer">
                    <p><strong>TSHOOT Soluções Tecnológicas</strong></p>
                    <p>Major Kanhangulo, Prédio da Suave, 3º Andar, Luanda, Angola</p>
                    <p>📞 (+244) 933 189 868 | ✉ <a href="mailto:comercial@tshoot-angola.com">comercial@tshoot-angola.com</a></p>
                    <p style="margin-top:15px; color:#aaa;">© ' . date('Y') . ' TSHOOT Soluções Tecnológicas. Todos os direitos reservados.</p>
                </div>
            </div>
        </body>
        </html>';
    }
}
