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
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    public function index(Request $request) {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_direction = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_column = $request->query('sort-type') !== null ? $request->query('sort-type') : 'updated_at';

        if ($sort_column !== 'title' && $sort_column !== 'published')
            $sort_column = 'updated_at';

        if ($search) {
            $posts = Post::where('status', '!=', 'preview')->where('title', 'like', '%' . $search . '%')->orderBy($sort_column, $sort_direction)->paginate($per_page);
        } else {
            $posts = Post::where('status', '!=', 'preview')->orderBy($sort_column, $sort_direction)->paginate($per_page);
        }

        $list_options = array(
            array(
                'title' => 'Title',
                'sort_value' => 'title',
                'sortable' => '1',
                'sort_type' => 'primary',
                'route' => '/admin/articles',
                'list_type' => 'article-title'
            ),
            array(
                'title' => 'Author',
                'sort_value' => 'email',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/articles',
                'list_type' => 'article-author'
            ),
            array(
                'title' => 'Published',
                'sort_value' => 'published',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/articles',
                'list_type' => 'article-published'
            ),
            array(
                'title' => 'Updated',
                'sort_value' => 'updated_at',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/articles',
                'list_type' => 'article-updated'
            )
        );

        return view('admin/posts/posts', ['items' => $posts, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_column' => $sort_column, 'sort_direction' => $sort_direction, 'list_options' => $list_options]);

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
            'status' => 'required',
        ]);

        $title = $request->input('title');
        $ingress = $request->input('ingress');
        $body = $request->input('body');
        $status = $request->input('status');
        $checkedCategories = $request->input('categories');
        $selectedTags = $request->input('tags');
        $image_id = $request->input('image');
        $user = Auth::user();

        $post = new Post();
        $post->title = $title;
        $post->ingress = $ingress;
        $post->body = Purifier::clean($body);

        if ($status == 'draft' || $status == 'published')
            $post->status = $status;
        $post->user_id = $user->id;

        $post->save();

        if (Media::find($image_id)) {
            $post->images()->attach($image_id);
        }

        if ($checkedCategories != null && count($checkedCategories) > 0) {

            foreach ($checkedCategories as $id => $category) {
                if (Category::find($id))
                    $post->categories()->attach($id);
            }

        }

        if ($selectedTags != null && count($selectedTags) > 0) {

            foreach ($selectedTags as $id => $tag) {
                if (Tag::find($id))
                    $post->tags()->attach($id);
            }

        }

        $request->session()->flash('message', 'Article was created successfully.');
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
            'slug' => 'required|unique:posts,slug,' . $id,
            'status' => 'required',
        ]);

        $title = $request->input('title');
        $ingress = $request->input('ingress');
        $body = $request->input('body');
        $slug = $request->input('slug');
        $status = $request->input('status');
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
        if ($status == 'draft' || $status == 'published')
            $post->status = $status;

        if($post->slug != $slug)
            $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);

        $post->save();

        if (Media::find($image_id)) {
            $post->images()->detach();
            $post->images()->attach($image_id);
        }

        if ($checkedCategories != null && count($checkedCategories) > 0) {

            $post->categories()->detach();

            foreach ($checkedCategories as $id => $category) {
                if (Category::find($id))
                    $post->categories()->attach($id);
            }

        } else
            $post->categories()->detach();


        if ($selectedTags != null && count($selectedTags) > 0) {

            $post->tags()->detach();

            foreach ($selectedTags as $id => $tag) {
                if (Tag::find($id))
                    $post->tags()->attach($id);
            }

        } else
            $post->tags()->detach();


        $request->session()->flash('message', 'Article was successfully updated.');
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

    public function preview(Request $request) {

        $validatedData = $request->validate([
            'title' => 'required',
        ]);

        $title = $request->input('title');
        $ingress = $request->input('ingress');
        $body = $request->input('body');
        $checkedCategories = $request->input('categories');
        $selectedTags = $request->input('tags');
        $image_id = $request->input('image');
        $auth_user = Auth::user();

        $preview_post = Post::where('user_id', $auth_user->id)->where('status', 'preview')->first();

        if(!$preview_post) {
            $preview_post = new Post();
            $preview_post->title = 'Placeholder preview title';
            $preview_post->status = 'preview';
            $preview_post->user_id = $auth_user->id;
            $preview_post->save();
        }

        $preview_post->title = $title;
        $preview_post->body = $body;
        $preview_post->ingress = $ingress;
        $preview_post->save();

        if (Media::find($image_id)) {
            $preview_post->images()->attach($image_id);
        } else
            $preview_post->images()->detach();

        if ($checkedCategories != null && count($checkedCategories) > 0) {

            $preview_post->categories()->detach();

            foreach ($checkedCategories as $id => $category) {
                if (Category::find($id))
                    $preview_post->categories()->attach($id);
            }

        } else
            $preview_post->categories()->detach();


        if ($selectedTags != null && count($selectedTags) > 0) {

            $preview_post->tags()->detach();

            foreach ($selectedTags as $id => $tag) {
                if (Tag::find($id))
                    $preview_post->tags()->attach($id);
            }

        } else
            $preview_post->tags()->detach();

        return response()->json($preview_post, 200);
    }

    public function getArticles(Request $request, $amount) {

        $amount = $amount * 10;

        $articles = Post::with('images')->take($amount)->get();

        return $articles;

    }
}
