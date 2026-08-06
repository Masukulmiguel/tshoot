<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->search;
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

        try {
            if ($contact->email) {
                Mail::to($contact->email)->send(new ContactReplyMail($contact, $request->admin_reply));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.contacts.show', $contact)
                ->with('warning', 'Resposta guardada, mas o email não pôde ser enviado. Verifique a configuração de email.');
        }

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Resposta enviada com sucesso por email!');
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