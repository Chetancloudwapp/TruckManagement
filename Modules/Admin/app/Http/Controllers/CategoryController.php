<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Category;
use Validator;

class CategoryController extends Controller
{
    /* -- category listing -- */
    public function index()
    {
        $common = [];
        $common['title'] = 'Category';
        $common['button'] = 'Submit';
        $get_category = Category::orderBy('id','desc')->get();
        return view('admin::category.index', compact('common', 'get_category'));
    }

    /* -- add category -- */
    public function addCategory(Request $request)
    {
        $common = [];
        $common['title']         = "Category";
        $common['heading_title'] = "Add Category";
        $common['button']        = "Submit";
        $message = "Category Added Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name'  => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $category = new Category;
            $category->name = $data['name'];
            // echo "<pre>"; print_r($trips->toArray()); die;
            $category->save();
            return redirect('admin/category')->with('success_message', $message);
        }
        return view('admin::category.addCategory', compact('common'));
    }

    /* -- edit category -- */
    public function editCategory(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Category";
        $common['heading_title'] = "Edit Category";
        $common['button']        = "Submit";
        $id = decrypt($id);
        $category = Category::findOrFail($id);
        $message = "Category Updated Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name'  => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $category->name = $data['name'];
            // echo "<pre>"; print_r($trips->toArray()); die;
            $category->save();
            return redirect('admin/category')->with('success_message', $message);
        }
        return view('admin::category.editCategory', compact('common','category'));
    }

    /* --- delete category ---*/
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success_message', 'Category Deleted Successfully!');
    }
}
