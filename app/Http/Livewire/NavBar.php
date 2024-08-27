<?php

namespace App\Http\Livewire;

use App\Category;
use Livewire\Component;
use App\About;


class NavBar extends Component
{
    public function render()
    {
    	$navCategories = Category::all();
         $about = About::firstOrFail();

        return view('livewire.nav-bar', compact('navCategories', 'about'));
    }
}
