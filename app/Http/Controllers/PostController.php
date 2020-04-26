<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\PostCategory;
use Validator;
use Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts    = Post::with('category')->get();
        $category = Category::all();
        return view('home', ['posts' => $posts,'category' => $category]);
    }

    /**
     * Show the post list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loadPost(Request $request)
    {
        $input     = $request->all();
        $createdAt = $input['created_at'];

        $posts = Post::with('category');

        if (!empty($createdAt)) {
            $posts->whereDate('created_at', $createdAt);
        }

        $allPost = $posts->get();
        return view('load_post', ['posts' => $allPost]);
    }

    public function create($id = 0)
    {
        $post = [];
        if (!empty($id)) {
            $post = Post::with(['category'=>function($q){$q->select('category_id');}])->where('id',$id)->first();
        }
        $category = Category::all();
        return view('post_frm', ['post' => $post, 'category' => $category]);
    }

    /**
     * @name save
     *
     * @description TO create or update post of current user
     *
     */
    public function save(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'sort_description' => 'required',
        ]);

        if ($validator->fails()) {
            $result['status'] = 'validation';
            $result['title'] = $validator->errors()->first('title');
            $result['sort_description'] = $validator->errors()->first('sort_description');
        } else {

            $user = auth()->user();

            $file = $request->file('image');

            if (!empty($file)) {
                $image = str_slug($file->getClientOriginalName(), "-") . time() . "." . $file->getClientOriginalExtension();
                //Move Uploaded File
                $destinationPath = public_path('images/post');
                $file->move($destinationPath, $image);
            } else {
                $image = $input['old_image'];
            }

            if (empty($image)) {
                $result['status'] = 'validation';
                $result['image'] = "please upload image";
            } else {

                if (!empty($input['id'])) {
                    $post = Post::find($input['id']);
                } else {
                    $post = new  Post();
                }

                $post->title            = $input['title'];
                $post->sort_description = $input['sort_description'];
                $post->description      = $input['description'];
                $post->image            = $image;
                $post->user_id          = $user->id;

                if ($post->save()) {
                    PostCategory::where('post_id',$post->id)->delete();

                    if (!empty($input['category'])) {
                        $date         = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                        $postCategory = [];
                        foreach ($input['category'] as $cat) {
                            
                            if (!empty($cat)) {
                                $postCategory[] = [
                                    'post_id'     => $post->id,
                                    'category_id' => $cat,
                                    'created_at'  => $date,
                                    'updated_at'  => $date
                                ];
                            }

                        }
                        PostCategory::insert($postCategory);
                    }

                    $result = [
                        'status' => "success",
                        'message' => "Post save Successfully",
                    ];
                } else {
                    $result = [
                        'status' => "error",
                        'message' => "Something went wrong",
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    public function delete ($id) {

            $user = auth()->user();

            if(!empty($id)) {
                $post = Post::find($id);

                if(!empty($post) && $post->user_id == $user->id && $post->delete() ){
                    $result = [
                        'status'  => "success",
                        'message' => "Post removed Successfully",
                    ];
                }else{
                    $result = [
                        'status'  => "error",
                        'message' => "Something went wrong",
                    ];
                }
            }
        
        echo json_encode($result);
    }
}
