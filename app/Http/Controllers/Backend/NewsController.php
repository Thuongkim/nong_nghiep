<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\News as News;
use App\Comment as Comment;
use App\NewsCategory as NewsCategory;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
	public function index(Request $request)
	{
		$query = '1=1';
        $title           		= $request->input('title');
        $status         		= intval($request->input('status', -1));
        $featured               = intval($request->input('featured', -1));
        $category               = intval($request->input('category_id', -1));
        $date_range             = $request->input('date_range');
        $page_num        		= intval($request->input('page_num', \App\Define\Constant::PAGE_NUM_20));

        if( $title ) $query .= " AND title like '%" . $title . "%'";
        if($status <> -1) $query .= " AND status = {$status}";
        if($featured <> -1) $query .= " AND featured = {$featured}";
        if($category <> -1) {
            $children = NewsCategory::where('parent_id', $category)->select('id')->get();
            $children = implode(',', array_column($children->toArray(), 'id'));
            $category = ($children ? $category . ',' . $children : $category);
            $query .= " AND category_id IN({$category})";
        }

        if ($date_range)
            $date_range = explode(' - ', $date_range);
        if (isset($date_range[0]) && isset($date_range[1]))
            $query .= " AND created_at >= '" . date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', ($date_range[0] == '' ? '1/1/2015' : $date_range[0]) ))) . "' AND updated_at <= '" . date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', ($date_range[1] == '' ? date("d/m/Y") : $date_range[1]) ))) . "'";

        $categories = [];
        $tmp = NewsCategory::where('parent_id', 0)->get();
        foreach ($tmp as $category) {
            $categories[$category->id] = $category->name;
            $children = NewsCategory::where('parent_id', $category->id)->get();
            foreach ($children as $child) {
                $categories[$child->id] = '|__ ' . $child->name;

                $grandChildren = NewsCategory::where('parent_id', $child->id)->get();
                foreach ($grandChildren as $ch) {
                    $categories[$ch->id] = '|____ ' . $ch->name;
                }
            }
        }

        $news = News::whereRaw($query)->orderBy('updated_at', 'DESC')->paginate($page_num);
        return view('backend.news.index', compact('news', 'categories'));
	}

	public function create(Request $request)
	{
        $categories = [];
        $tmp = NewsCategory::where('parent_id', 0)->where('status', 1)->get();
        foreach ($tmp as $category) {
            $categories[$category->id] = $category->name;
            $children = NewsCategory::where('parent_id', $category->id)->where('status', 1)->get();
            foreach ($children as $child) {
                $categories[$child->id] = '|__ ' . $child->name;

                $grandChildren = NewsCategory::where('parent_id', $child->id)->where('status', 1)->get();
                foreach ($grandChildren as $ch) {
                    $categories[$ch->id] = '|____ ' . $ch->name;
                }
            }
        }

        return view('backend.news.create', compact('categories'));
	}

	public function store(Request $request)
	{
        $request->merge(['featured' => intval($request->featured), 'status' => intval($request->status)]);
        $validator = Validator::make($data = $request->only('category', 'title', 'image', 'seo_description', 'seo_keywords', 'content', 'summary', 'status', 'featured'), News::rules());
		$validator->setAttributeNames(trans('news'));
		if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $data['created_by']   = \Auth::guard('admin')->user()->id;
        $data['category_id'] = $request->input('category');

        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height() <> \App\Define\News::IMAGE_NEWS_HEIGHT || $image->width() <> \App\Define\News::IMAGE_NEWS_WIDTH) {
                Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\News::IMAGE_NEWS_WIDTH ."px x " . \App\Define\News::IMAGE_NEWS_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }

            \File::makeDirectory(config('upload.news') .  date('dm'), 0775, true, true);
            $timestamp = time();
            $image->save(config('upload.news') .  date('dm') . '/' . str_slug($data['title']). "_" . $timestamp . '.' .  $ext);
            $data['image'] = date('dm') . '/' . str_slug($data['title']). "_" . $timestamp . '.' .  $ext;
        }
        News::create($data);

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.news.index');
	}

	public function show(Request $request, $id)
	{
        $news = News::find($id);
        if (is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news.index');
        }

        if (!$request->user()->ability(['system', 'admin'], []) && $news->created_by <> $request->user()->id) {
            return redirect()->route('admin.403');
        }

        $categories = [];
        $tmp = NewsCategory::where('parent_id', 0)->whereRaw("(status=1 OR id={$news->category_id})")->get();
        foreach ($tmp as $category) {
            $categories[$category->id] = $category->name;
            $children = NewsCategory::where('parent_id', $category->id)->whereRaw("(status=1 OR id={$news->category_id})")->get();
            foreach ($children as $child) {
                $categories[$child->id] = '-- ' . $child->name;
            }
        }
        $comments = $news->comments()->orderBy('id', 'DESC')->get();

        return view('backend.news.show', compact('news', 'categories', 'comments'));
	}

    public function edit(Request $request, $id)
    {
        $news = News::find($id);
        if (is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }
        $categories = [];
        $tmp = NewsCategory::where('parent_id', 0)->whereRaw("(status=1 OR id={$news->category_id})")->get();
        foreach ($tmp as $category) {
            $categories[$category->id] = $category->name;
            $children = NewsCategory::where('parent_id', $category->id)->whereRaw("(status=1 OR id={$news->category_id})")->get();
            foreach ($children as $child) {
                $categories[$child->id] = '|__ ' . $child->name;

                $grandChildren = NewsCategory::where('parent_id', $child->id)->whereRaw("(status=1 OR id={$news->category_id})")->get();
                foreach ($grandChildren as $ch) {
                    $categories[$ch->id] = '|____ ' . $ch->name;
                }
            }
        }

        return view('backend.news.edit', compact( 'news', 'categories' ) );
    }

    public function update(Request $request, $id)
    {
        $id = intval($id);
        $news = News::find($id);
        if (is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }

        $request->merge(['featured' => intval($request->featured), 'status' => intval($request->status)]);
        if ($request->hasFile('image')) {
            $validator = Validator::make($data = $request->only('category', 'title', 'image', 'seo_description', 'seo_keywords', 'content', 'summary', 'status', 'featured'), News::rules($id));
        } else {
            $validator = Validator::make($data = $request->only('category', 'title', 'seo_description', 'seo_keywords', 'content', 'summary', 'status', 'featured'), News::rules($id));
        }

        $validator->setAttributeNames(trans('news'));
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $data['category_id'] = $request->input('category');
        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height() <> \App\Define\News::IMAGE_NEWS_HEIGHT || $image->width() <> \App\Define\News::IMAGE_NEWS_WIDTH) {
                Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\News::IMAGE_NEWS_WIDTH ."px x " . \App\Define\News::IMAGE_NEWS_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            \File::makeDirectory(config('upload.news') .  date('dm'), 0775, true, true);
            $timestamp = time();
            $image->save(config('upload.news') .  date('dm') . '/' . str_slug($data['title']). "_" . $timestamp . '.' .  $ext);
            $data['image'] = date('dm') . '/' . str_slug($data['title']). "_" . $timestamp . '.' .  $ext;
        }

        $news->update($data);

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.news.index');
    }

    public function destroy(Request $request, $id)
    {
        $news = News::find($id);
        if (is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }

        $news->deleted_by = $request->user()->id;
        $news->save();
        $news->delete();

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.news.index');
    }

    public function updateBulk(Request $request)
    {
        if ($request->ajax()) {
            $return = [ 'error' => true, 'message' => trans('system.have_an_error') ];

            if (!$request->user()->ability(['system', 'admin'], ['news.approve'])) {
                return response()->json($return, 401);
            }

            $ids = json_decode($request->input('ids'));
            if(empty($ids)) return response()->json(['error' => true, 'message' => trans('system.no_item_selected')]);

            switch ($request->input('action')) {
                case 'delete':
                    foreach ($ids as $id) {
                        foreach ($ids as $id) {
                            $news = News::where('id', intval($id))->first();
                            if (is_null($news)) continue;
                            $news->deleted_by = $request->user()->id;
                            $news->save();
                            $news->delete();
                        }
                    }
                    break;
                case 'active':
                    $return = ['error' => true, 'message' => trans('system.update') . ' ' . trans('system.success')];
                    foreach ($ids as $id) {
                        News::where('id', intval($id))->update(['status' => 1]);
                    }
                    break;
                case 'deactive':
                    $return = ['error' => true, 'message' => trans('system.update') . ' ' . trans('system.success')];
                    foreach ($ids as $id) {
                        News::where('id', intval($id))->update(['status' => 0]);
                    }
                    break;
                case 'category':
                    $return             = ['error' => true, 'message' => trans('system.update') . ' ' . trans('system.success')];
                    $category_id        = intval($request->input('category_id', 0));
                    $category           = NewsCategory::find($category_id);
                    if (is_null($category) || !$category->status) {
                        $return['message'] = 'Danh mục bạn chọn không cho phép thao tác này.';
                        return response()->json($return);
                    }

                    foreach ($ids as $id) {
                        News::where('id', intval($id))->update(['category_id' => $category_id]);
                    }
                    break;
                default:
                    $return['message']  = trans('system.no_action_selected');
                    return response()->json($return);
            }

            $return['error']    = false;
            $return['message']  = trans('system.success');
            Session::flash('message', $return['message']);
            Session::flash('alert-class', 'success');
            return response()->json($return);
        }
    }

    public function approveComment(Request $request, $id, $commentId)
    {
        $comment = Comment::where('news_id', intval($id))->where('id', intval($commentId))->where('status', 0)->first();
        $news = News::find(intval($id));
        if (is_null($comment) || is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return back();
        }
        $comment->update(['status' => 1]);
        $news->count_comment = ($news->count_comment + 1);
        $news->save();

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }

    public function disapproveComment(Request $request, $id, $commentId)
    {
        $comment = Comment::where('news_id', intval($id))->where('id', intval($commentId))->where('status', 1)->first();
        $news = News::find(intval($id));
        if (is_null($comment) || is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return back();
        }
        if ($news->count_comment > 0) {
            $news->count_comment = ($news->count_comment - 1);
        } else {
            $news->count_comment = 0;
        }
        $news->save();

        $comment->update(['status' => 0]);

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }

    public function deleteComment(Request $request, $id, $commentId)
    {
        $comment = Comment::where('news_id', intval($id))->where('id', intval($commentId))->first();
        $news = News::find(intval($id));
        if (is_null($comment) || is_null($news)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return back();
        }

        if ($comment->status) {
            if ($news->count_comment > 0) {
                $news->count_comment = ($news->count_comment - 1);
            } else {
                $news->count_comment = 0;
            }
            $news->save();
        }
        $comment->delete();
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }
}