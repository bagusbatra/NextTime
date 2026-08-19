<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->filled('search'), fn ($query) => $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->string('search')}%")
                    ->orWhere('email', 'like', "%{$request->string('search')}%");
            }))
            ->when($request->filled('status'), fn ($query) => $query->status($request->string('status')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'new' => ContactMessage::status('new')->count(),
            'read' => ContactMessage::status('read')->count(),
            'replied' => ContactMessage::status('replied')->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'counts'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact-messages.show', ['message' => $contactMessage]);
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $request->validate(['status' => ['required', 'in:new,read,replied']]);

        $contactMessage->update(['status' => $request->string('status')]);

        return back()->with('status', 'Status pesan berhasil diubah.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('status', 'Pesan berhasil dihapus.');
    }
}
