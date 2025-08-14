<?php

namespace App\Http\Controllers\Tours;

use App\Http\Controllers\Controller;
use App\Models\Tours\Tour;
use App\Models\Tours\TourCategory;
use App\Http\Requests\Tours\TourRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function create()
    {
        $categories = TourCategory::all();
        return view('pages.tours.tours.create', compact('categories'));
    }

    public function store(TourRequest $request)
    {
        $validated = $request->validated();
        $itineraries = $validated['itineraries'] ?? [];
        unset($validated['itineraries'], $validated['images']);

        DB::beginTransaction();
        try {
            $tour = Tour::create($validated);

            if (!empty($itineraries)) {
                $tour->itineraries()->createMany(
                    collect($itineraries)
                        ->sortBy('sort_order')
                        ->values()
                        ->toArray()
                );
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image_file) {
                    $file_name = Str::slug($tour->title).'-'.now()->format('dmyHis').'-'.Str::random(5).'.'.$image_file->getClientOriginalExtension();
                    $image_file->storeAs('tours/images/', $file_name, 'public');
                    $tour->images()->create(['image' => $file_name]);
                }
            }

            DB::commit();
            return redirect()->route('tours.index')->with('success', 'Tour created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create tour: '.$e->getMessage());
        }
    }

    public function edit(Tour $tour)
    {
        $categories = TourCategory::all();
        $tour->load('itineraries', 'images');
        return view('pages.tours.tours.edit', compact('tour', 'categories'));
    }

    public function update(TourRequest $request, Tour $tour)
    {
        $validated = $request->validated();
        $itineraries = $validated['itineraries'] ?? [];
        unset($validated['itineraries'], $validated['images']);

        DB::beginTransaction();
        try {
            $tour->update($validated);

            $tour->itineraries()->delete();
            if (!empty($itineraries)) {
                $tour->itineraries()->createMany(
                    collect($itineraries)
                        ->sortBy('sort_order')
                        ->values()
                        ->toArray()
                );
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image_file) {
                    $file_name = Str::slug($tour->title).'-'.now()->format('dmyHis').'-'.Str::random(5).'.'.$image_file->getClientOriginalExtension();
                    $image_file->storeAs('tours/images/', $file_name, 'public');
                    $tour->images()->create(['image' => $file_name]);
                }
            }

            DB::commit();
            return redirect()->route('tours.index')->with('success', 'Tour updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update tour: '.$e->getMessage());
        }
    }
}
