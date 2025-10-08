<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Base;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Question;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use SEO;

class PageController extends Controller
{
    public function page($slug)
    {
        $page=Page::with('page_cat')->where('slug',$slug)->firstOrFail();
        $title=$page->title;
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($page->title);
        SEOMeta::setDescription($page->meta?$page->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$page->meta?$page->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.pages.show', compact(['user','title','helper','page']));
    }
    public function contact()
    {
        $title='ارتباط با ما';
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$helper['setting']->meta?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.pages.contact_us', compact(['user','title','helper']));

    }

    public function contactSave(ContactRequest $request)
    {
        $contact=new Contact();
        $contact->name=$request->input('name');
        $contact->mail=$request->input('mail');
        $contact->mobile=$request->input('mobile');
        $contact->subject=$request->input('subject');
        $contact->message=$request->input('message');
        $contact->ip_address=$request->ip();
        $contact->user_id=auth()->check()?auth()->user()->id:null;
        $contact->save();
        toast('اطلاعات شما با موفقیت ارسال شد.','success');
        return back();
    }

    public function about()
    {
        $title='درباره ما';
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$helper['setting']->meta?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.pages.about', compact(['user','title','helper']));

    }

    public function question()
    {
        $questions=Question::query();
        if($keyword = request('search')) {
            $questions->where('title' , 'LIKE' , "%{$keyword}%")
                ->orWhere('description','Like',"%{$keyword}%");
        }
        $questions=$questions->where('status',1)->get();
        $title='سوالات متداول';
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$helper['setting']->meta?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.pages.questions', compact(['helper','user','questions','title']));
    }

    public function aims()
    {

        $title='اهداف ما';
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$helper['setting']->meta?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        $bases=Base::where('status',true)->get();
        return view('web.pages.index', compact(['helper','user','title','bases']));
    }
}
