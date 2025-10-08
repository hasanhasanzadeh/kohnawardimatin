<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\User;

class ContactController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('contact-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.contacts');
        $contacts = Contact::query();
        if ($keyword = request('search')) {
            $contacts->where('message', 'LIKE', "%{$keyword}%")
                ->orWhere('subject', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('mail', 'LIKE', "%{$keyword}%")
                ->orWhere('ip_address', 'LIKE', "%{$keyword}%");
        }
        $contacts = $contacts->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.contact.index', compact(['contacts', 'user', 'setting','title']));
    }

    public function show(Contact $contact)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('contact-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $contact->read=1;
        $contact->save();
        return view('panel.contact.show', compact(['user', 'title', 'contact', 'setting']));
    }

    public function destroy(Contact $contact)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('contact-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $contact->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }
}
