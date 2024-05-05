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
}
