<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'message'   => 'required|string',
            'stars'     => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create($request->only(['user_name', 'message', 'stars']));

        return redirect()->route('admin.testimonial.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonial.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'message'   => 'required|string',
            'stars'     => 'required|integer|min:1|max:5',
        ]);

        $testimonial->update($request->only(['user_name', 'message', 'stars']));

        return redirect()->route('admin.testimonial.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonial.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}
