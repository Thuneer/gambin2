<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_direction = $request->query('sort-value') == null || $request->query('sort-value') == 'asc' ? 'asc' : 'desc';
        $sort_column = $request->query('sort-type') !== null ? $request->query('sort-type') : 'name';

        if ($sort_column !== 'name')
            $sort_column = 'name';

        if ($search) {
            $items = Category::where('name', 'like', '%' . $search . '%')->orderBy($sort_column, $sort_direction)->paginate($per_page);
        } else {
            $items = Category::orderBy($sort_column, $sort_direction)->paginate($per_page);
        }

        $list_options = array(
            array(
                'title' => 'Name',
                'sort_value' => 'name',
                'sortable' => '1',
                'sort_type' => 'primary',
                'route' => '/admin/articles/categories',
                'list_type' => 'category-name'
            )

        );

        return view('admin.posts.categories', ['items' => $items, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_column' => $sort_column, 'sort_direction' => $sort_direction, 'list_options' => $list_options]);


    }
}
