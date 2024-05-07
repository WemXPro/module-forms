<?php
namespace Modules\Forms\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Modules\Forms\Entities\Form;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function index()
    {
        $forms = Form::paginate(10);
        return view('forms::admin.index', compact('forms'));
    }

    public function create()
    {
        return view('forms::admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'slug' => 'required|unique:module_forms',
            'notification_email' => 'nullable|email',
            'max_submissions' => 'nullable|integer',
            'max_submissions_per_user' => 'nullable|integer',
            'recaptcha' => 'nullable|boolean',
            'guest' => 'nullable|boolean',
            'can_view_submission' => 'nullable|boolean',
            'can_respond' => 'nullable|boolean',            
        ]);

        $form = Form::create($request->all());

        return redirect()->route('admin.forms.index')->withSuccess('Form created successfully.');
    }

    public function edit(Form $form)
    {
        return view('forms::admin.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'slug' => 'required|unique:module_forms,slug,' . $form->id,
            'notification_email' => 'nullable|email',
            'max_submissions' => 'nullable|integer',
            'max_submissions_per_user' => 'nullable|integer',
            'recaptcha' => 'nullable|boolean',
            'guest' => 'nullable|boolean',
            'can_view_submission' => 'nullable|boolean',
            'can_respond' => 'nullable|boolean',            
        ]);

        $form->update($request->all());

        return redirect()->back()->withSuccess('Form updated successfully.');
    }
}
