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
            'required_packages' => 'nullable|array',
            'allowed_gateways' => 'nullable|array',
            'price' => 'nullable|numeric',
            'recaptcha' => 'nullable|boolean',
            'guest' => 'nullable|boolean',
            'can_view_submission' => 'nullable|boolean',
            'can_respond' => 'nullable|boolean',            
        ]);

        $form = Form::create([
            'name' => $request->get('name'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'slug' => $request->get('slug'),
            'notification_email' => $request->get('notification_email'),
            'max_submissions' => $request->get('max_submissions'),
            'max_submissions_per_user' => $request->get('max_submissions_per_user'),
            'required_packages' => $request->get('required_packages'),
            'allowed_gateways' => $request->get('allowed_gateways'),
            'price' => $request->get('price', 0),
            'recaptcha' => $request->get('recaptcha', false),
            'guest' => $request->get('guest', false),
            'can_view_submission' => $request->get('can_view_submission', false),
            'can_respond' => $request->get('can_respond', false),
        ]);

        return redirect()->route('admin.forms.index')->withSuccess('Form created successfully.');
    }

    public function edit(Form $form)
    {
        // dd($form->allowed_gateways);
        return view('forms::admin.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'slug' => 'required|unique:module_forms,slug,' . $form->id,
            'notification_email' => 'nullable|email',
            'max_submissions' => 'nullable|integer',
            'max_submissions_per_user' => 'nullable|integer',
            'required_packages' => 'nullable|array',
            'allowed_gateways' => 'nullable|array',
            'price' => 'nullable|numeric',
            'recaptcha' => 'boolean',
            'guest' => 'boolean',
            'can_view_submission' => 'boolean',
            'can_respond' => 'boolean',         
        ]);

        $form->update([
            'name' => $request->get('name'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'slug' => $request->get('slug'),
            'notification_email' => $request->get('notification_email'),
            'max_submissions' => $request->get('max_submissions'),
            'max_submissions_per_user' => $request->get('max_submissions_per_user'),
            'required_packages' => $request->get('required_packages', null),
            'allowed_gateways' => $request->get('allowed_gateways', null),
            'price' => $request->get('price', 0),
            'recaptcha' => $request->get('recaptcha', false),
            'guest' => $request->get('guest', false),
            'can_view_submission' => $request->get('can_view_submission', false),
            'can_respond' => $request->get('can_respond', false),
        ]);

        return redirect()->back()->withSuccess('Form updated successfully.');
    }
}
