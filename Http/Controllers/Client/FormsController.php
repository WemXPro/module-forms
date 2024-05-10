<?php
namespace Modules\Forms\Http\Controllers\Client;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Modules\Forms\Entities\Form;
use Modules\Forms\Entities\Submission;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function view(Form $form)
    {
        return view('forms::client.view-form', compact('form'));
    }

    public function submit(Request $request, Form $form)
    {
        $request->validate(array_merge($form->fieldRules(), ['guest_email' => 'sometimes|email']));

        $data = $request->only(array_merge($form->fieldNames(), ['guest_email']));

        $submission = $form->submissions()->create([
            'user_id' => auth()->id() ?? null,
            'guest_email' => auth()->guest() ? $request->get('guest_email', null) : null,
            'status' => 'open',
            'data' => $data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'paid' => false,
        ]);

        return redirect()->back()->withSuccess('Form submitted successfully.');
    }

    public function viewSubmission(Submission $submission)
    {
        return view('forms::client.view-submission', compact('submission'));
    }
}
