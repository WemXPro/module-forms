<?php
namespace Modules\Forms\Http\Controllers\Client;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Modules\Forms\Entities\Form;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function view(Form $form)
    {
        return view('forms::client.view-form', compact('form'));
    }
}
