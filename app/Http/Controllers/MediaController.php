<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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

        $sort_direction = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_column = $request->query('sort-type') !== null ? $request->query('sort-type') : 'created_at';

        if ($per_page == null && $list == 1)
            $per_page = 15;

        if ($sort_column !== 'name' && $sort_column !== 'size' && $sort_column !== 'extension' && $sort_column !== 'created_at')
            $sort_column = 'name';

        if ($search) {

            $media = Media::where('name', 'like', '%' . $search . '%')->orderBy($sort_column, $sort_direction)->paginate($per_page);

        } else {

            $media = Media::orderBy($sort_column, $sort_direction)->paginate($per_page);

        }

        $list_options = array(
            array(
                'title' => 'Name',
                'sort_value' => 'name',
                'sortable' => '1',
                'sort_type' => 'primary',
                'route' => '/admin/media',
                'list_type' => 'media-name'
            ),
            array(
                'title' => 'Extension',
                'sort_value' => 'extension',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/media',
                'list_type' => 'media-extension'
            ),
            array(
                'title' => 'Size',
                'sort_value' => 'size',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/media',
                'list_type' => 'media-size'
            ), array(
                'title' => 'Connections',
                'sort_value' => '-1',
                'sortable' => '0',
                'sort_type' => 'standard',
                'route' => '/admin/media',
                'list_type' => 'media-connections'


            ));

        return view('admin.media.media', [
            'items' => $media,
            'search' => $search,
            'per_page' => $per_page,
            'list' => $list,
            'sort_column' => $sort_column,
            'sort_direction' => $sort_direction,
            'list_options' => $list_options
        ]);

    }

    public function upload (Request $request) {

        $unique_time = time();
        $unique_id = uniqid();

        $year = date('Y');
        $month = date("m");
        $day = date('d');

        if (!file_exists('uploads') && !is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!file_exists('uploads/' . $year) && !is_dir('uploads/' . $year)) {
            mkdir('uploads/' . $year);
        }

        if (!file_exists('uploads/' . $year . '/' . $month) && !is_dir('uploads/' . $year . '/' . $month)) {
            mkdir('uploads/' . $year . '/' . $month);
        }

        if (!file_exists('uploads/' . $year . '/' . $month . '/' . $day) && !is_dir('uploads/' . $year . '/' . $month . '/' . $day)) {
            mkdir('uploads/' . $year . '/' . $month . '/' . $day);
        }

        $path = 'uploads/' . $year . '/' . $month . '/' . $day . '/' . time() . '-' . uniqid();

        $file  = $request->file('file');

        $base = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        $name = explode('.', $base)[0];
        $resolution_x =  getimagesize($file)[0];
        $resolution_y =  getimagesize($file)[1];


        $img_original = Image::make($file);

        $img_1_1_1120 = Image::make($file)->fit(1120, 1120);
        $img_1_1_740 = Image::make($file)->fit(740, 740);
        $img_1_1_550 = Image::make($file)->fit(550, 550);
        $img_1_1_360 = Image::make($file)->fit(360, 360);

        $img_4_3_1120 = Image::make($file)->fit(1120, 840);
        $img_4_3_740 = Image::make($file)->fit(740, 555);
        $img_4_3_550 = Image::make($file)->fit(550, 412);
        $img_4_3_360 = Image::make($file)->fit(360, 270);

        $img_16_9_1120 = Image::make($file)->fit(1120, 630);
        $img_16_9_740 = Image::make($file)->fit(740, 416);
        $img_16_9_550 = Image::make($file)->fit(550, 309);
        $img_16_9_360 = Image::make($file)->fit(360, 202);

        $img_21_9_1120 = Image::make($file)->fit(1120, 480);
        $img_21_9_740 = Image::make($file)->fit(740, 317);
        $img_21_9_550 = Image::make($file)->fit(550, 235);
        $img_21_9_360 = Image::make($file)->fit(360, 154);


        $img_original->save($path . '.' . $ext);

        $img_1_1_1120->save($path . '-1-1-xl.' .$ext);
        $img_1_1_740->save($path . '-1-1-lg.' .$ext);
        $img_1_1_550->save($path . '-1-1-md.' .$ext);
        $img_1_1_360->save($path . '-1-1-sm.' .$ext);

        $img_4_3_1120->save($path . '-4-3-xl.' .$ext);
        $img_4_3_740->save($path . '-4-3-lg.' .$ext);
        $img_4_3_550->save($path . '-4-3-md.' .$ext);
        $img_4_3_360->save($path . '-4-3-sm.' .$ext);

        $img_16_9_1120->save($path . '-16-9-xl.' .$ext);
        $img_16_9_740->save($path . '-16-9-lg.' .$ext);
        $img_16_9_550->save($path . '-16-9-md.' .$ext);
        $img_16_9_360->save($path . '-16-9-sm.' .$ext);

        $img_21_9_1120->save($path . '-21-9-xl.' .$ext);
        $img_21_9_740->save($path . '-21-9-lg.' .$ext);
        $img_21_9_550->save($path . '-21-9-md.' .$ext);
        $img_21_9_360->save($path . '-21-9-sm.' .$ext);


        $palette = Palette::fromFilename('./' . $path . '-16-9-sm.' .$ext);
        $extractor = new ColorExtractor($palette);
        $color_int = $extractor->extract(1)[0];
        $color = Color::fromIntToHex($color_int);

        $image = new Media();
        $image->name = $name;
        $image->size = $size;
        $image->type = 'image';
        $image->extension = $ext;
        $image->color = $color;
        $image->resolution_x = $resolution_x;
        $image->resolution_y = $resolution_y;
        $image->path = $path;
        $image->save();

        return response()->json($image, 200);
    }

    public function getImages(Request $request) {

        $search = $request->input( 'search' );

        if (strlen($search) !== 0) {
            $media = Media::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        } else {
            $media = Media::orderBy('created_at', 'DESC')->take(32)->get();
        }

        return response()->json($media);

    }

    public function editView($id) {

        $media = Media::find($id);
        return view('admin.media.edit', ['item' => $media]);

    }

    public function edit(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'column' => 'required',
            'value' => 'required'
        ]);

        $column = $request->input( 'column' );
        $value = $request->input( 'value' );

        if ($validator->fails())
            return response()->json('Validation failed', 400);
        else if($column !== 'name' && $column !== 'title' && $column !== 'alt')
            return response()->json('Values wrong', 400);

        $image = Media::find($id);

        if (!$image) {
            return response()->json('Image not found', 404);
        }

        $image[$column] = $value;
        $image->save();

        return response()->json($image, 201);
    }

    public function delete(Request $request)
    {

        $ids = $request->input('deleteIds');
        $list = $request->input('list') == null ? '0' : $request->input('list');

        $id_array = explode(',', $ids);

        if (count($id_array) == 0) {
            $request->session()->flash('message', 'Something went wrong.');
            $request->session()->flash('message-status', 'error');

            return redirect('/admin/media');
        }

        for ($i = 0; $i < count($id_array); $i++) {

            $media = Media::find($id_array[$i]);

            if (!$media) {
                $request->session()->flash('message', 'Something went wrong, please try again.');
                $request->session()->flash('message-status', 'error');

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
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/media?list=' . $list);

        } else {
            $request->session()->flash('message', '<b>' . $media->name . '</b> was successfully deleted.');
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/media?list=' . $list);
        }

    }

}
