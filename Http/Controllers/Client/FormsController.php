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
        if(!$form->guest && auth()->guest()) {
            return redirect()->route('login')->withError('You must be logged in to view this page.');
        }

        if($form->required_packages AND is_array($form->required_packages) AND auth()->user()) {
            $hasOrder = auth()->user()->orders()->where('status', 'active')->whereIn('package_id', $form->required_packages)->exists();
            if(!$hasOrder) {
                return redirect()->route('dashboard')->withError('You must have the required package to view this page.');
            }
        }
        
        return view('forms::client.view-form', compact('form'));
    }

    public function submit(Request $request, Form $form)
    {
        if(!$form->guest && auth()->guest()) {
            return redirect()->route('login')->withError('You must be logged in to view this page.');
        }

        if($form->required_packages AND is_array($form->required_packages) AND auth()->user()) {
            $hasOrder = auth()->user()->orders()->where('status', 'active')->whereIn('package_id', $form->required_packages)->exists();
            if(!$hasOrder) {
                return redirect()->route('dashboard')->withError('You must have the required package to view this page.');
            }
        }

        if($form->max_submissions AND $form->submissions()->count() >= $form->max_submissions) {
            return redirect()->back()->withError('This form has reached the maximum number of submissions.');
        }

        if($form->max_submissions_per_user AND auth()->user()) {
            $userSubmissions = $form->submissions()->where('user_id', auth()->id())->count();
            if($userSubmissions >= $form->max_submissions_per_user) {
                return redirect()->back()->withError('You have reached the maximum number of submissions for this form.');
            }
        }

        $request->validate(array_merge($form->fieldRules(), ['guest_email' => 'sometimes|email']));

        $data = $request->only(array_merge($form->fieldNames(), ['guest_email']));

        $submission = $form->submissions()->create([
            'user_id' => auth()->id() ?? null,
            'guest_email' => auth()->guest() ? $request->get('guest_email', null) : null,
            'status' => $form->isPaid() ? 'awaiting_payment' : 'open',
            'data' => $data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'paid' => false,
        ]);

        if($form->can_view_submission) {
            return redirect()->route('forms.view-submission', $submission->token)->withSuccess('Form submitted successfully.');
        }

        return redirect()->back()->withSuccess('Form submitted successfully.');
    }

    public function viewSubmission(Submission $submission)
    {
        return view('forms::client.view-submission', compact('submission'));
    }
}
