<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\Slider as Slider;

class SlidersController extends Controller
{
    public function index(Request $request)
    {
        $query = "1=1";
        $status                 = intval($request->input('status', -1));
        if($status <> -1) $query .= " AND status = {$status}";

        $sliders = Slider::whereRaw($query)->orderBy('position')->get();

        return view('backend.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.sliders.create');
    }

    public function show($id)
    {
        $slider   = Slider::find(intval($id));
        if (is_null($slider)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.sliders.index');
        }

        return view('backend.sliders.show', compact('slider'));
    }

    public function edit($id)
    {
        $slider   = Slider::find(intval($id));
        if (is_null($slider)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.sliders.index');
        }

        return view('backend.sliders.edit', compact('slider'));
    }

    public function store(Request $request)
    {
        $request->merge(['status' => $request->input('status', 0)]);
        $validator = \Validator::make($data = $request->all(), Slider::rules());
        $validator->setAttributeNames(trans('sliders'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $image  = $request->image;
        $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
        $image  = \Image::make($request->image);
        if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_SLIDER_HEIGHT/\App\Define\Constant::IMAGE_SLIDER_WIDTH) {
            Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\Constant::IMAGE_SLIDER_WIDTH ."px x " . \App\Define\Constant::IMAGE_SLIDER_HEIGHT . "px.");
            Session::flash('alert-class', 'danger');
            return back()->withInput();
        }
        \File::makeDirectory(public_path(config('upload.slider') . date('dm')), 0777, true, true);
        $fileName = str_slug($data['name']). "-" . time() . '.' .  $ext;
        $image->resize(\App\Define\Constant::IMAGE_SLIDER_WIDTH, \App\Define\Constant::IMAGE_SLIDER_HEIGHT)->save(public_path(config('upload.slider') . date('dm') . '/' . $fileName));
        $data['image'] = config('upload.slider') . date('dm') . '/' . $fileName;
        $data['created_by'] = $request->user()->id;
        $data['position']   = 1;
        $slider = Slider::create($data);
        Slider::where('id', "<>", $slider->id)->increment('position');

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.sliders.index');
    }

    public function update(Request $request, $id)
    {
        $slider   = Slider::find(intval($id));
        if (is_null($slider)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.sliders.index');
        }

        $request->merge(['status' => $request->input('status', 0)]);
        $validator = \Validator::make($data = $request->all(), Slider::rules(intval($id)));
        $validator->setAttributeNames(trans('sliders'));

        if ($validator->fails()) return back()->withErrors($validator)->withInput();
        if ($request->hasFile('image')) {
            if (\File::exists(public_path() . '/' . $slider->image)) \File::delete(public_path() . '/' . $slider->image);
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_SLIDER_HEIGHT/\App\Define\Constant::IMAGE_SLIDER_WIDTH) {
                Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\Constant::IMAGE_SLIDER_WIDTH ."px x " . \App\Define\Constant::IMAGE_SLIDER_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            \File::makeDirectory(public_path(config('upload.slider') . date('dm')), 0777, true, true);
            $fileName = str_slug($data['name']). "-" . time() . '.' .  $ext;
            $image->resize(\App\Define\Constant::IMAGE_SLIDER_WIDTH, \App\Define\Constant::IMAGE_SLIDER_HEIGHT)->save(public_path(config('upload.slider') . date('dm') . '/' . $fileName));
            $data['image'] = config('upload.slider') . date('dm') . '/' . $fileName;
        }

        $slider->update($data);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.sliders.index');
    }

    public function destroy($id)
    {
        $slider = Slider::find(intval($id));
        if (is_null($slider)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.sliders.index');
        }

        Slider::where('position', '>', $slider->position)->decrement('position');
        if (\File::exists(public_path() . '/' . $slider->image)) \File::delete(public_path() . '/' . $slider->image);
        $slider->delete();
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->route('admin.sliders.index');
    }

    public function updatePosition($id, $value)
    {
        if (!in_array($value, [-1, 1])) return back();

        $slider = Slider::find(intval($id));

        if(is_null($slider)) return back();

        // tang len 1 vi tri
        if($value == 1) {
            if ($slider->position == Slider::count())
                return back();

            Slider::where('position', $slider->position + 1)->decrement('position');
            $slider->position++;
            $slider->save();
        } elseif($value == -1) {
            if ($slider->position == 1)
                return back();

            Slider::where('position', $slider->position - 1)->increment('position');
            $slider->position--;
            $slider->save();
        }

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }
}