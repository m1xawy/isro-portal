<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderby('id', 'desc')->limit(3);
        return view('partials.slider', compact('sliders'));
    }
}
