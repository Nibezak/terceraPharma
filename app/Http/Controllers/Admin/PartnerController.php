<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner; // Make sure to use the correct namespace for your Partner model
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class PartnerController extends Controller
{
    public function index() {
        // Fetch all partners from the database
        $partners = Partner::all();

        // Pass the partners to the view
        return view('admin.partners.index', compact('partners'));
    }

    public function create() {
        return view('admin.partners.create');
    }

    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('partners', 'public');
        }

        // Save the partner details
        $partner = new Partner();
        $partner->name = $request->input('name');
        $partner->image = $imagePath ?? null;
        $partner->save();

        // Redirect back with a success message
        return redirect()->route('partner.index')->with('success', 'Partner added successfully!');
    }

    public function destroy(Partner $partner) {
        // Delete the partner's image from storage
        if ($partner->image_path) {
            Storage::disk('public')->delete($partner->image_path);
        }

        // Delete the partner from the database
        $partner->delete();

        // Redirect back with a success message
        return redirect()->route('partner.index')->with('success', 'Partner deleted successfully!');
    }
}
