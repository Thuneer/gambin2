<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

class PageController extends Controller
{

    public function index(Request $request) {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_direction = $request->query('sort-value') == null || $request->query('sort-value') == 'asc' ? 'asc' : 'desc';
        $sort_column = $request->query('sort-type') !== null ? $request->query('sort-type') : 'title';

        if ($sort_column !== 'title' && $sort_column !== 'updated_at')
            $sort_column = 'title';

        if ($search) {
            $posts = Page::where('title', 'like', '%' . $search . '%')->orderBy($sort_column, $sort_direction)->paginate($per_page);
        } else {
            $posts = Page::orderBy($sort_column, $sort_direction)->paginate($per_page);
        }

        $list_options = array(
            array(
                'title' => 'Title',
                'sort_value' => 'title',
                'sortable' => '1',
                'sort_type' => 'primary',
                'route' => '/admin/pages',
                'list_type' => 'page-title'
            ),
            array(
                'title' => 'Permalink',
                'sort_value' => 'permalink',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/pages',
                'list_type' => 'page-permalink'
            ),
            array(
                'title' => 'Parent',
                'sort_value' => 'parent',
                'sortable' => '0',
                'sort_type' => 'standard',
                'route' => '/admin/pages',
                'list_type' => 'page-parent'
            ),
            array(
                'title' => 'Updated',
                'sort_value' => 'updated_at',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/pages',
                'list_type' => 'page-updated'
            )

        );

        return view('admin.pages.pages', ['items' => $posts, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_column' => $sort_column, 'sort_direction' => $sort_direction, 'list_options' => $list_options]);

    }

    public function newView() {

        $pages = Page::defaultOrder()->get()->toTree();

        $files = scandir(resource_path() . '/views/templates');
        $files = array_diff($files, array('.', '..'));
        $templates = [];


        foreach ($files as $file) {
            $content = file_get_contents(resource_path() . '/views/templates/' . $file);
            if (strpos($content, 'Name: ') !== false &&strpos($content, ' --}}') !== false) {

                $start = strpos($content, 'Name: ');
                $end = strpos($content, ' --}}');
                $here = substr($content, $start, $end);
                $here = preg_replace("/(Name: | --}})/", "", $here);

                array_push($templates, $here);
            }

        }


        return view('admin.pages.pages_new', ['pages' => $pages, 'templates' => $templates]);

    }

    public function create(Request $request) {

        $validatedData = $request->validate([
            'title' => 'required',
            'permalink' => 'required',
            'parent' => 'nullable|integer',
            'type' => 'integer',
            'front' => 'required|integer'
        ]);

        $title = $request->title;
        $permalink = $request->permalink;
        $pb_body = $request->pb_body;
        $summernote_body = $request->summernote_body;
        $type = $request->type;
        $parent = $request->parent;
        $template = $request->template;
        $front = $request->front;

        $page = new Page();
        $page->title = $title;

        if ($type == 0) {
            $page->body = $summernote_body;
        } else {
            $page->body = $pb_body;
        }

        if ($front == 1) {

            $p = Page::where('front_page', '=', 1)->first();
            if ($p) {
                $p->front_page = 0;
                $p->save();
            }

        }
        $page->front_page = $front;

        if($template !== '-1') {
            $page->template = $template;
        }
        $page->type = $type;

        $parent_page = Page::find($parent);
        if($parent !== null && !$parent_page) {
            return back();
        }

        if ($parent_page) {

            $temp = '';

            foreach ($parent_page->ancestors as $p) {
                 $temp .= $p->title . '/';
            }
            $permalink_short = $permalink;
            $permalink = strtolower($temp . $parent_page->title . '/' . $permalink);

            $page->parent_id = $parent;
            $page->permalink_short = $permalink_short;

        } else {
            $page->permalink_short = $permalink;
        }

        $page->permalink = $permalink;

        $page->save();

        $request->session()->flash('message', 'Page was created successfully.');
        $request->session()->flash('message-status', 'success');

        return redirect('/admin/pages');

    }

    public function editView($id) {

        $page = Page::find($id);
        $pages = Page::defaultOrder()->get()->toTree();

        $files = scandir(resource_path() . '/views/templates');
        $files = array_diff($files, array('.', '..'));
        $templates = [];


        foreach ($files as $file) {
            $content = file_get_contents(resource_path() . '/views/templates/' . $file);
            if (strpos($content, 'Name: ') !== false &&strpos($content, ' --}}') !== false) {

                $start = strpos($content, 'Name: ');
                $end = strpos($content, ' --}}');
                $here = substr($content, $start, $end);
                $here = preg_replace("/(Name: | --}})/", "", $here);

                array_push($templates, $here);
            }

        }

        return view('/admin/pages/pages_edit', ['pages' => $pages, 'page' => $page, 'templates' => $templates]);
    }

    public function edit(Request $request, $id) {

        $validatedData = $request->validate([
            'title' => 'required',
            'permalink' => 'required',
            'parent' => 'nullable|integer',
            'type' => 'integer'
        ]);

        $page = Page::find($id);

        $title = $request->title;
        $permalink = $request->permalink;
        $pb_body = $request->pb_body;
        $summernote_body = $request->summernote_body;
        $type = $request->type;
        $parent = $request->parent;
        $template = $request->template;
        $front = $request->front;

        $page->title = $title;

        if ($front == 1) {

            $front_page = Page::where('front_page', '=', 1)->first();

            if ($front_page && $page->id != $front_page->id) {
                $front_page->front_page = 0;
                $front_page->save();
            }

        }
        $page->front_page = $front;

        if ($type == 0) {
            $page->body = $summernote_body;
        } else {
            $page->body = $pb_body;
        }

        if($template !== '-1') {
            $page->template = $template;
        }
        $page->type = $type;

        $parent_page = Page::find($parent);
        if($parent !== null && !$parent_page) {
            return back();
        }

        if ($parent_page) {

            $temp = '';

            foreach ($parent_page->ancestors as $p) {
                $temp .= $p->title . '/';
            }
            $permalink_short = $permalink;
            $permalink = strtolower($temp . $parent_page->title . '/' . $permalink);

            $page->parent_id = $parent;
            $page->permalink_short = $permalink_short;

        } else {
            $page->permalink_short = $permalink;
        }

        $page->permalink = $permalink;

        $page->save();

        $request->session()->flash('message', 'Page was updated successfully.');
        $request->session()->flash('message-status', 'success');

        return redirect('/admin/pages/' . $id . '/edit');

    }

    public function permalink(Request $request) {

        $permalink = $request->permalink;
        $title = $request->title;
        $parent = $request->parent;
        $id = $request->id;
        $permalink_slug = '';

        if ($permalink == null) {
            if ($title == null) {
                return response()->json('error', 400);
            } else {
                $permalink = $title;
            }
        }

        if ($id != null) {

            if ($page = Page::where('permalink', $permalink)->first()) {
                $permalink = $page->permalink;
                $permalink_slug = 'eeeee';
            } else {
                $permalink_slug = SlugService::createSlug(Page::class, 'permalink', $permalink);
            }

        } else {
            $permalink_slug = SlugService::createSlug(Page::class, 'permalink', $permalink);
        }

        if ($p = Page::find($parent)) {

            $a = '';

            foreach ($p->ancestors as $t) {

                $a .= $t->title . '/';

            }

            $permalink = strtolower($a . $p->title . '/' . $permalink_slug);

        }

        return response()->json(['full' => $permalink, 'semi' => $permalink_slug ], 200);

    }



}
