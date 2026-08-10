<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_\\');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'archived' => Contact::where('status', 'archived')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'counts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['status'] = 'new';

        Contact::create($validated);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contacto criado com sucesso!');
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:new,read,replied,archived',
        ]);

        $contact->update($validated);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contacto actualizado com sucesso!');
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate(['admin_reply' => 'required|string']);

        $contact->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        $apiKey = config('services.resend.key');
        if ($apiKey && $contact->email) {
            try {
                $html = $this->buildReplyHtml($contact, $request->admin_reply);
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.resend.com/emails', [
                    'from' => 'TSHOOT <comercial@tshoot-angola.com>',
                    'to' => [$contact->email],
                    'subject' => 'Resposta da TSHOOT - ' . str_replace(["\r", "\n"], '', $contact->subject ?? 'Contacto'),
                    'html' => $html,
                ]);
            } catch (\Exception $e) {
                return redirect()->route('admin.contacts.show', $contact)
                    ->with('warning', 'Resposta guardada, mas o email não pôde ser enviado.');
            }
        }

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Resposta enviada com sucesso por email!');
    }

    private function buildReplyHtml(Contact $contact, string $reply): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"><style>
            body { font-family: "Segoe UI", Tahoma, sans-serif; background: #f4f6f9; margin: 0; padding: 40px 20px; color: #333; }
            .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
            .header { background: linear-gradient(135deg, #1B2A41, #243652); padding: 30px; text-align: center; }
            .header h1 { color: #D4A11D; font-size: 20px; margin: 0; }
            .header p { color: #94A3B8; font-size: 12px; margin: 5px 0 0; }
            .body { padding: 30px; }
            .greeting { font-size: 16px; color: #1B2A41; margin-bottom: 20px; }
            .message-box { background: #f8f9fa; border-left: 4px solid #D4A11D; padding: 20px; margin: 20px 0; border-radius: 0 8px 8px 0; }
            .message-box p { margin: 0; line-height: 1.7; color: #555; }
            .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #eee; }
            .footer p { margin: 5px 0; font-size: 12px; color: #888; }
            .divider { height: 1px; background: #eee; margin: 20px 0; }
        </style></head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>TSHOOT</h1>
                    <p>Soluções Tecnológicas</p>
                </div>
                <div class="body">
                    <p class="greeting">Olá <strong>' . htmlspecialchars($contact->name) . '</strong>,</p>
                    <p>Obrigado por entrar em contacto connosco. Eis a nossa resposta:</p>
                    <div class="message-box">
                        <p><strong>Assunto:</strong> ' . htmlspecialchars($contact->subject ?? 'Contacto') . '</p>
                    </div>
                    <div class="message-box">
                        <p>' . nl2br(htmlspecialchars($reply)) . '</p>
                    </div>
                    <div class="divider"></div>
                    <p style="color:#666; font-size:14px;">Se tiver mais alguma dúvida, não hesite em contactar-nos.</p>
                </div>
                <div class="footer">
                    <p><strong>TSHOOT Soluções Tecnológicas</strong></p>
                    <p>Major Kanhangulo, Prédio da Suave, 3º Andar, Luanda, Angola</p>
                    <p>📞 (+244) 933 189 868 | ✉ comercial@tshoot-angola.com</p>
                </div>
            </div>
        </body>
        </html>';
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate(['status' => 'required|in:new,read,replied,archived']);
        $contact->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contacto eliminado.');
    }
}