<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\NewsCategory as NewsCategory;
use App\News as News;

class NewsCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = "1=1";
        $status         = intval($request->input('status', -1));
        $onQuickLink    = intval($request->input('view_all', -1));
        $visible        = intval($request->input('visible', -1));
        $ref            = intval($request->input('ref'));

        if($status <> -1) $query .= " AND status = {$status}";
        if($onQuickLink <> -1) $query .= " AND view_all = {$onQuickLink}";
        // if($ref) $query .= " AND id = {$ref}";
        if($ref)
            $categories = NewsCategory::where('id', $ref)->where('parent_id', 0)->whereRaw($query)->orderBy('position')->get();
        else
            $categories = NewsCategory::where('parent_id', 0)->whereRaw($query)->orderBy('position')->get();

        if ($visible == -1 || $visible == 1) {
            for ($i = 0; $i < $categories->count(); $i++) {
                $categories{$i}->children = NewsCategory::where('parent_id', $categories{$i}->id)->whereRaw($query)->orderBy('position')->get();
                if ($visible == -1) {
                    for ($j = 0; $j < $categories{$i}->children->count(); $j++) {
                        $categories{$i}->children{$j}->children = NewsCategory::where('parent_id', $categories{$i}->children{$j}->id)->whereRaw($query)->orderBy('position')->get();
                    }
                }
            }
        }

        return view('backend.news-categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = NewsCategory::where('parent_id', 0)->where('status', 1)->orderBy('position')->pluck('name', 'id')->toArray();
        return view('backend.news-categories.create', compact('categories'));
    }

    public function show($id)
    {
        $newsCategory   = NewsCategory::find(intval($id));
        if (is_null($newsCategory)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news-categories.index');
        }

        $categories = NewsCategory::where('parent_id', 0)->orderBy('position')->pluck('name', 'id')->toArray();

        if ($newsCategory->parent_id) {

            // find parent
            $parentCategory = NewsCategory::find($newsCategory->parent_id);
            if ($parentCategory->parent_id) {
                $rootCategoryId     = $parentCategory->parent_id;
                $level1Categories = NewsCategory::where('parent_id', $parentCategory->parent_id)->whereRaw("status = 1 OR id = {$newsCategory->parent_id}")->orderBy('position')->pluck('name', 'id')->toArray();
            } else {
                $rootCategoryId     = $parentCategory->id;
                $level1Categories   = [ $newsCategory->parent_id => trans('news_categories.root')];
            }
        } else {
            $rootCategoryId     = 0;
            $level1Categories   = [ $newsCategory->parent_id => trans('news_categories.root')];
        }

        return view('backend.news-categories.show', compact('newsCategory', 'categories', 'level1Categories', 'rootCategoryId'));
    }

    public function edit($id)
    {
        $newsCategory   = NewsCategory::find(intval($id));
        if (is_null($newsCategory)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news-categories.index');
        }

        $categories = NewsCategory::where('parent_id', 0)->orderBy('position')->pluck('name', 'id')->toArray();

        if ($newsCategory->parent_id) {

            // find parent
            $parentCategory = NewsCategory::find($newsCategory->parent_id);
            if ($parentCategory->parent_id) {
                $rootCategoryId     = $parentCategory->parent_id;
                $level1Categories = NewsCategory::where('parent_id', $parentCategory->parent_id)->whereRaw("status = 1 OR id = {$newsCategory->parent_id}")->orderBy('position')->pluck('name', 'id')->toArray();
            } else {
                $rootCategoryId     = $parentCategory->id;
                $level1Categories   = [ $newsCategory->parent_id => trans('news_categories.root')];
            }
        } else {
            $rootCategoryId     = 0;
            $level1Categories   = [ $newsCategory->parent_id => trans('news_categories.root')];
        }

        return view('backend.news-categories.edit', compact('newsCategory', 'categories', 'level1Categories', 'rootCategoryId'));
    }

    public function store(Request $request)
    {
        $request->merge(['status' => $request->input('status', 0), 'view_all' => $request->input('view_all', 0), 'show_menu' => $request->input('show_menu', 0)]);
        $validator = \Validator::make($data = $request->all(), NewsCategory::rules());
        $validator->setAttributeNames(trans('news_categories'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT/\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH) {
                Session::flash('message', "Ảnh phải có kích thước là " . \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH ."px x " . \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            \File::makeDirectory(public_path(config('upload.news_category') . date('dm')), 0777, true, true);
            $fileName = str_slug($data['name']). "-" . time() . '.' .  $ext;
            $image->resize(\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH, \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT)->save(public_path(config('upload.news_category') . date('dm') . '/' . $fileName));
            $data['image'] = config('upload.news_category') . date('dm') . '/' . $fileName;
        }

        $data['parent_id'] = $data['level1'];
        $data['created_by'] = $request->user()->id;
        $data['position']   = NewsCategory::where('parent_id', $data['parent_id'])->count() + 1;
        $newsCategory = NewsCategory::create($data);

        // cap nhat danh muc viewall
        if ($newsCategory->view_all) {
            $ids = $newsCategory->getChildrenIds() . ',' . $newsCategory->getParentsIds() . ',' . $newsCategory->getSiblingsIds();
            $ids = explode(',', $ids);
            NewsCategory::where('id', '<>', $newsCategory->id)->whereIn("id", $ids)->update(['view_all' => 0]);
        }


        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.news-categories.index');
    }

    public function update(Request $request, $id)
    {
        $newsCategory = NewsCategory::find(intval($id));
        if (is_null($newsCategory)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news-categories.index');
        }

        $request->merge(['status' => $request->input('status', 0), 'view_all' => $request->input('view_all', 0), 'show_menu' => $request->input('show_menu', 0)]);
        $validator = \Validator::make($data = $request->except(['position', 'parent_id']), NewsCategory::rules(intval($id)));
        $validator->setAttributeNames(trans('news_categories'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();
        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT/\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH) {
                Session::flash('message', "Ảnh phải có kích thước là " . \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH ."px x " . \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            if (\File::exists(public_path() . '/' . $newsCategory->image)) \File::delete(public_path() . '/' . $newsCategory->image);
            \File::makeDirectory(public_path(config('upload.news_category') . date('dm')), 0777, true, true);
            $fileName = str_slug($data['name']). "-" . time() . '.' .  $ext;
            $image->resize(\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH, \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT)->save(public_path(config('upload.news_category') . date('dm') . '/' . $fileName));
            $data['image'] = config('upload.news_category') . date('dm') . '/' . $fileName;
        }

        // cap nhat danh muc viewall
        if ($data['view_all'] && 0 == $newsCategory->view_all) {
            $ids = $newsCategory->getChildrenIds() . ',' . $newsCategory->getParentsIds() . ',' . $newsCategory->getSiblingsIds();
            $ids = explode(',', $ids);
            NewsCategory::where('id', '<>', $newsCategory->id)->whereIn("id", $ids)->update(['view_all' => 0]);
        }

        $newsCategory->update($data);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.news-categories.index', ['ref' => $newsCategory->getRoot()->id]);
    }

    public function destroy($id)
    {
        $newsCategory   = NewsCategory::find(intval($id));
        if (is_null($newsCategory)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news-categories.index');
        }

        if ($newsCategory->news()->count()) {
            Session::flash('message', "Danh mục đã có bài viết, cần xoá bỏ bài viết thuộc danh mục trước");
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.news-categories.index');
        }
        // update position
        NewsCategory::where('parent_id', $newsCategory->parent_id)->where('position', '>', $newsCategory->position)->decrement('position');
        if (\File::exists(public_path() . '/' . $newsCategory->image)) \File::delete(public_path() . '/' . $newsCategory->image);
        $newsCategory->delete();

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->route('admin.news-categories.index');
    }

    public function updatePosition($id, $value)
    {
        if (!in_array($value, [-1, 1])) return back();

        $newsCategory = NewsCategory::find(intval($id));

        if(is_null($newsCategory)) return back();

        // tang len 1 vi tri
        if($value == 1) {
            if ($newsCategory->position == NewsCategory::where('parent_id', $newsCategory->parent_id)->count())
                return back();

            NewsCategory::where('parent_id', $newsCategory->parent_id)->where('position', $newsCategory->position + 1)->decrement('position');
            $newsCategory->position++;
            $newsCategory->save();
        } elseif($value == -1) {
            if ($newsCategory->position == 1)
                return back();

            NewsCategory::where('parent_id', $newsCategory->parent_id)->where('position', $newsCategory->position - 1)->increment('position');
            $newsCategory->position--;
            $newsCategory->save();
        }

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }

    public function getChildrenById(Request $request)
    {
        $response = [ 'message' => trans('system.have_an_error') ];
        $statusCode = 200;
        if($request->ajax()) {
            try {
                $pCategories = NewsCategory::where('status', 1)->where('parent_id', intval($request->parent_id))->orderBy('position')->pluck('name', 'id')->toArray();

                $response['message'] = $pCategories;
            } catch (\Exception $e) {
                if ($statusCode == 200) $statusCode = 500;
                $response['message'] = $e->getMessage();
            } finally {
                return response()->json($response, $statusCode);
            }
        } else {
            $statusCode = 405;
            return response()->json($response, $statusCode);
        }
    }
}