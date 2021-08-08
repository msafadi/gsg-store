<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Throwable;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        SELECT categories.*, parents.name as parent_name FROM
        categories LEFT JOIN categories as parents
        ON parents.id = categories.parent_id
        WHERE ststus = 'active'
        ORDER BY created_at DESC, name ASC
        */
        // return collection of Category model object
        /* $entries = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            //->where('categories.status', '=', 'active')
            ->orderBy('categories.created_at', 'DESC')
            ->orderBy('categories.name', 'ASC')
            ->withTrashed()
            ->get();
*/
        // return collection of stdObj object
        /*$entries = DB::table('categories')
            ->where('status', '=', 'active')
            ->orderBy('created_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();*/


        /*$categories = [];
        if ($categories instanceof Traversable) {
            echo 'Yes';
            return;
        }*/

        $entries = Category::with('parent')
            ->withCount('products as count')
            /*->has('parent')
            ->whereHas('products', function($query) {
                $query->where('price', '<', 200);
            })*/
            ->simplePaginate(10);

        //dd($categories);
        $success = session()->get('success');
        //session()->forget('success');

        return view('admin.categories.index', [
            'categories' => $entries,
            'title' => 'Categories List',
            'success' => $success,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('admin.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255|min:3|unique:categories',
            'parent_id' => 'required|int|exists:categories,id',
            'description' => 'nullable|min:5',
            'status' => 'required|in:active,draft',
            'image' => 'image|max:512000|dimensions:min_width=300,min_height=300',
        ];
        /*$clean = $request->validate($rules, [
            'required' => 'The :attribute required!',
            'parent_id.required' => 'The parent is required!',
        ]);*/
        //$clean = $this->validate($request, $rules, []);

        /*$data = $request->all();
        $validator = Validator::make($data, $rules, []);
        //$clean = $validator->validate();
        try {
            $clean = $validator->validated();
        } catch (Throwable $e) {
            //return $validator->failed();
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }*/

        /*if ($validator->fails()) {
            //$errors = $validator->errors();
            return redirect()->back()->withErrors($validator);
        }*/

        // Request Merge
        $request->merge([
            'slug' => Str::slug($request->name),
            'status' => 'active',
        ]);

        // return array of all form fields
        // $request->all();
        // dd($request->all());

        // // return single field value
        // $request->description;
        // $request->input('description');
        // $request->get('description');
        // $request->post('description');
        // $request->query('description'); // ?description=value

        // Method #1
        // $category = new Category();
        // $category->name = $request->post('name');
        // $category->slug = Str::slug($request->post('name'));
        // $category->parent_id = $request->post('parent_id');
        // $category->description = $request->post('description');
        // $category->status = $request->post('status', 'active');
        // $category->save();        

        // Method #2: Mass assignment
        $category = Category::create($request->all());

        // Method #3: Mass assignment
        // $category = new Category([
        //     'name' => $request->post('name'),
        //     'slug' => Str::slug($request->post('name')),
        //     'parent_id' => $request->post('parent_id'),
        //     'description' => $request->post('description'),
        //     'status' => $request->post('status', 'active'),
        // ]);
        //$category->save();

        // PRG
        return redirect()->route('categories.index')
            ->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category->load([
            'parent',
            'products' => function($query) {
                $query->orderBy('price', 'ASC')->where('status', 'active');
            }
        ]);
        // SELECT * FROM products WHERE category_id = ? ORDER BY price ASC
        return $category->products()
            ->with('category:id,name,slug')
            ->where('price', '>', 150)
            ->orderBy('price', 'ASC')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$category = Category::where('id', '=', $id)->first();
        $category = Category::findOrFail($id);
        if (!$category) {
            abort(404);
        }
        $parents = Category::withTrashed()->where('id', '<>', $category->id)->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //$request->route('id');
        /*$rules = [
            'name' => ['required', 'string', 'max:255', 'min:3',
                'unique:categries,id,' . $id,
                Rule::unique('categories', 'id')->ignore($id),
                (new Unique('categories', 'id'))->ignore($id),
            ],
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'nullable|min:5',
            'status' => 'required|in:active,draft',
            'image' => 'image|max:512000|dimensions:min_width=300,min_height=300',
        ];
        $clean = $request->validate($rules);*/

        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        // Mass assignemnt
        //Category::where('id', '=', $id)->update( $request->all() );

        //
        $category = Category::find($id);

        // Method #1
        /*$category->name = $request->post('name');
        $category->parent_id = $request->post('parent_id');
        $category->description = $request->post('description');
        $category->status = $request->post('status');
        $category->save();*/

        # Method #2: Mass assignemnt
        $category->update($request->all());

        # Method #3: Mass assignment
        //$category->fill( $request->all() )->save();

        // PRG
        return redirect()->route('categories.index')
            ->with('success', 'Category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Method #1
        // $category = Category::find($id);
        // $category->delete();

        // Method #2
        Category::destroy($id);

        // Method #3
        // Category::where('id', '=', $id)->delete();

        // Write into session
        //Session::put();
        //session()->put('success', 'Category deleted');
        // session([
        //     'success' => 'Category deleted!',
        // ]);

        //session()->flash('success', 'Category deleted');

        // PRG
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted');
    }

}
