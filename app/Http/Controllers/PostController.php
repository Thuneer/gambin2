<?php

namespace App\Http\Controllers;

use App\Category;
use App\Media;
use App\Post;
use App\Tag;
use App\Taggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Spatie\Permission\Models\Role;

class PostController extends Controller
{
    public function index(Request $request) {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_value = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_type = $request->query('sort-type') !== null ? $request->query('sort-type') : 'updated_at';

        if ($sort_type !== 'title' && $sort_type !== 'published')
            $sort_type = 'updated_at';

        if ($search) {

            $posts = Post::where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->orderBy($sort_type, $sort_value)->paginate($per_page);

        } else {

            $posts = Post::orderBy($sort_type, $sort_value)->paginate($per_page);

        }

        return view('admin/posts/posts', ['items' => $posts, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_type' => $sort_type, 'sort_value' => $sort_value]);

    }

    public function newView()
    {

        $roles = Role::all();
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();

        return view('admin/posts/new', ['roles' => $roles, 'categories' => $categories, 'tags' => $tags]);

    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'title' => 'required',
            'ingress' => 'required',
            'body' => 'required',
            'published' => 'required|integer|between:0,1',
            'image' => 'required|integer'
        ]);

        $title = $request->input('title');
        $ingress = $request->input('ingress');
        $body = $request->input('body');
        $published = $request->input('published');
        $checkedCategories = $request->input('categories');
        $selectedTags = $request->input('tags');
        $image_id = $request->input('image');
        $user = Auth::user();

        $post = new Post();
        $post->title = $title;
        $post->ingress = $ingress;
        $post->body = Purifier::clean($body);
        $post->published = $published;
        $post->user_id = $user->id;
        $post->save();

        if (Media::find($image_id)) {

            $post->images()->attach($image_id);

        }

        if (count($checkedCategories) > 0) {

            foreach ($checkedCategories as $id => $category) {

                if (Category::find($id))
                    $post->categories()->attach($id);
            }

        }

        if (count($selectedTags) > 0) {

            foreach ($selectedTags as $id => $tag) {

                if (Tag::find($id))
                    $post->tags()->attach($id);
            }

        }

        $request->session()->flash('message', 'Post was created successfully.');
        $request->session()->flash('message-status', 'success');

        return redirect('/admin/articles');

    }

    public function editView($id) {

        $post = Post::find($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();

        return view('admin.posts.edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags]);

    }

    public function edit(Request $request, $id)  {

        $validatedData = $request->validate([
            'title' => 'required',
            'ingress' => 'required',
            'body' => 'required',
            'published' => 'required|integer',
            'image' => 'required|integer'
        ]);

        $title = $request->input('title');
        $ingress = $request->input('ingress');
        $body = $request->input('body');
        $published = $request->input('published');
        $checkedCategories = $request->input('categories');
        $selectedTags = $request->input('tags');
        $image_id = $request->input('image');
        $post = Post::find($id);

        if (!$post) {
            return redirect('/admin/articles');
        }

        if(!canEditArticles(Auth::user(), $post)) {

            $request->session()->flash('message', 'You do not have permission to edit articles');
            $request->session()->flash('message-status', 'error');

            return redirect('/admin');

        }


        $post = Post::find($id);
        $post->title = $title;
        $post->ingress = $ingress;
        $post->body = Purifier::clean($body);
        $post->published = $published;
        $post->save();

        if (Media::find($image_id)) {

            $post->images()->detach();
            $post->images()->attach($image_id);

        }

        if (count($checkedCategories) > 0) {

            $post->categories()->detach();

            foreach ($checkedCategories as $id => $category) {

                if (Category::find($id))
                    $post->categories()->attach($id);
            }

        } else {
            $post->categories()->detach();
        }

        if (count($selectedTags) > 0) {

            $post->tags()->detach();

            foreach ($selectedTags as $id => $tag) {

                if (Tag::find($id))
                    $post->tags()->attach($id);
            }

        } else {
            $post->tags()->detach();
        }

        $request->session()->flash('message', 'Post was successfully edited.');
        $request->session()->flash('message-status', 'success');

        return redirect()->back();

    }

    public function delete(Request $request)
    {

        $ids = $request->input('deleteIds');

        $id_array = explode(',', $ids);

        if (count($id_array) == 0) {
            $request->session()->flash('message', 'Something went wrong.');
            $request->session()->flash('message-status', 'error');

            return redirect('/admin/articles');
        }

        for ($i = 0; $i < count($id_array); $i++) {

            $post = Post::find($id_array[$i]);

            if (!$post) {
                $request->session()->flash('message', 'Something went wrong, please try again.');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin/articles');
            } else if (!canDeleteArticles(Auth::user(), $post)) {
                $request->session()->flash('message', 'You do not have permission to delete articles.');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin/articles');
            }

        }

        for ($i = 0; $i < count($id_array); $i++) {

            $post = Post::find($id_array[$i]);
            $post->images()->detach();
            $post->delete();

        }

        if (count($id_array) > 1) {

            $request->session()->flash('message', count($id_array) . ' users were successfully deleted.');
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/articles');

        } else {
            $request->session()->flash('message', '<b>' . $post->title . '</b> was successfully deleted.');
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/articles');
        }

    }
}
