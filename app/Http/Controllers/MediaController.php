<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class MediaController extends Controller
{

    public function index(Request $request) {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $list = $request->query('list') == null || $request->query('list') == '0' ? '0' : '1';
        $per_page = $request->query('per-page') == null && $list == 0 ? '50' : $request->query('per-page');

        $sort_value = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_type = $request->query('sort-type') !== null ? $request->query('sort-type') : 'created_at';

        if ($sort_type !== 'name' && $sort_type !== 'size' && $sort_type !== 'extension' && $sort_type !== 'created_at')
            $sort_type = 'name';

        if ($search) {

            $media = Media::where('name', 'like', '%' . $search . '%')->orderBy($sort_type, $sort_value)->paginate($per_page);

        } else {

            $media = Media::orderBy($sort_type, $sort_value)->paginate($per_page);

        }

        return view('admin/media', ['items' => $media, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_type' => $sort_type, 'sort_value' => $sort_value]);

    }

    public function upload (Request $request) {

        $file  = $request->file('file');

        $base = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        $name = explode('.', $base)[0];

        $img_full = Image::make($file);

        $img_large = Image::make($file)->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img_medium = Image::make($file)->resize(1024, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img_small = Image::make($file)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img_thumbnail = Image::make($file)->resize(180, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img_full_path = 'uploads/' . 'full-' . time() . '-' . uniqid() . '.' . $ext;
        $img_large_path = 'uploads/' . 'large-' . time() . '-' . uniqid() . '.' . $ext;
        $img_medium_path = 'uploads/' . 'large-' . time() . '-' . uniqid() . '.' . $ext;
        $img_small_path = 'uploads/' . 'small-' . time() . '-' . uniqid() . '.' . $ext;
        $img_thumbnail_path = 'uploads/' . 'thumbnail-' . time() . '-' . uniqid() . '.' . $ext;

        $img_full->save($img_full_path);
        $img_large->save($img_large_path);
        $img_medium->save($img_medium_path);
        $img_small->save($img_small_path);
        $img_thumbnail->save($img_thumbnail_path);

        $palette = Palette::fromFilename('./' . $img_small_path);
        $extractor = new ColorExtractor($palette);
        $color_int = $extractor->extract(1)[0];
        $color = Color::fromIntToHex($color_int);

        $image = new Media();
        $image->name = $name;
        $image->size = $size;
        $image->type = 'image';
        $image->extension = $ext;
        $image->color = $color;
        $image->path_full = $img_full_path;
        $image->path_large = $img_large_path;
        $image->path_medium = $img_medium_path;
        $image->path_small = $img_small_path;
        $image->path_thumbnail = $img_thumbnail_path;
        $image->save();

        return response()->json($image, 200);
    }

    public function delete(Request $request)
    {

        $ids = $request->input('deleteIds');
        $list = $request->input('list') == null ? '0' : $request->input('list');

        $id_array = explode(',', $ids);

        if (count($id_array) == 0) {
            $request->session()->flash('message', 'Something went wrong.');
            $request->session()->flash('status', 'error');

            return redirect('/admin/media');
        }

        for ($i = 0; $i < count($id_array); $i++) {

            $media = Media::find($id_array[$i]);

            if (!$media) {
                $request->session()->flash('message', 'Something went wrong, please try again.');
                $request->session()->flash('status', 'error');

                return redirect('/admin/media');
            }

        }

        for ($i = 0; $i < count($id_array); $i++) {

            $media = Media::find($id_array[$i]);

            $path_full = public_path() . '/' . $media->path_full;
            $path_large = public_path() . '/' . $media->path_large;
            $path_medium = public_path() . '/' . $media->path_medium;
            $path_thumbnail = public_path() . '/' . $media->path_thumbnail;

            if (file_exists($path_full)) {
                unlink($path_full);
            }

            if (file_exists($path_large)) {
                unlink($path_large);
            }

            if (file_exists($path_medium)) {
                unlink($path_medium);
            }

            if (file_exists($path_thumbnail)) {
                unlink($path_thumbnail);
            }

            $media->delete();

        }

        if (count($id_array) > 1) {

            $request->session()->flash('message', count($id_array) . ' media files were successfully deleted.');
            $request->session()->flash('status', 'success');

            return redirect('/admin/media?list=' . $list);

        } else {
            $request->session()->flash('message', '<b>' . $media->name . '</b> was successfully deleted.');
            $request->session()->flash('status', 'success');

            return redirect('/admin/media?list=' . $list);
        }

    }

}
