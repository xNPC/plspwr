<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contacts', [
            'page' => Page::where('section', 'contacts')->first(),
        ]);
    }
}
