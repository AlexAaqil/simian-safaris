<?php

namespace App\Http\Controllers\Tours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tours\TourImage;
use Illuminate\Support\Facades\Storage;

class TourImageController extends Controller
{
    public function destroy($tour_image)
    {
        $tour_image = TourImage::where('uuid', $tour_image)->firstOrFail();

        $image_path = 'tours/images/' . $tour_image->image;

        if (Storage::disk('public')->exists($image_path)) {
            Storage::disk('public')->delete($image_path);
        }

        $tour_image->delete();

        return redirect()->back()->with('success', 'Tour image deleted successfully');
    }

    public function sort(Request $request)
    {
        if(!empty($request->photo_id)) {
            $i = 1;
            foreach($request->photo_id as $photo_id) {
                $image = TourImage::find($photo_id);
                $image->sort_order = $i;
                $image->save();

                $i++;
            }
        }

        $json['success'] = true;
        echo json_encode($json);
    }
}
