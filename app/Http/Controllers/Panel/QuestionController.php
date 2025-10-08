<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Setting;
use App\Models\User;

class QuestionController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.questions');
        $questions = Question::query();
        if ($keyword = request('search')) {
            $questions->where('title', 'LIKE', "%{$keyword}%");
        }
        $questions = $questions->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.question.index', compact(['questions', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.question.create', compact(['user', 'title', 'setting']));
    }

    public function store(QuestionRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $question = new Question();
        $question->title = $request->title;
        $question->description = $request->description;
        $question->status = $request->status;
        $question->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('questions.index');
    }


    public function show(Question $question)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show').' '.__('dashboard.question');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.question.show', compact(['user', 'title', 'question', 'setting']));
    }


    public function edit(Question $question)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit').' '.__('dashboard.question');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.question.edit', compact(['user', 'title', 'question', 'setting']));
    }


    public function update(QuestionRequest $request, Question $question)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $question->title = $request->title;
        $question->description = $request->description;
        $question->status = $request->status;
        $question->save();
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('questions.index');
    }

    public function destroy(Question $question)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('question-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $question->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }
}
