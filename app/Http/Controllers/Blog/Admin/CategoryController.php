<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$paginator = BlogCategory::paginate( 15 );

		return view( 'blog.admin.categories.index', compact( 'paginator' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		dd( __METHOD__ );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$item = BlogCategory::findOrFail( $id ); //404
		$categoryList = BlogCategory::all();

		return view( 'blog.admin.categories.edit',
			compact( 'item', 'categoryList' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(BlogCategoryUpdateRequest $request, $id)
	{
		/*$rules = [
			'title' => 'required|min:5|max:200',
			'slug' => 'max:200',
			'description' => 'string|max:200|min:3',
			'parent_id' => 'required|integer|exists:blog_categories,id',

		];*/
		/*способы валидации данных*/

		//обратились к контролеру
		//$validateData = $this->validate($request, $rules);
		//обратились к реквесту
		//$validateData = $request->validate($rules);

		/*$validator = \Validator::make( $request->all(), $rules );
		$validateData[] = $validator->passes();
		$validateData[] = $validator->validate();
		$validateData[] = $validator->valid();
		$validateData[] = $validator->failed();
		$validateData[] = $validator->errors();
		$validateData[] = $validator->fails();

		dd( $validateData );*/

		/*dd(__METHOD__, $request->all(), $id);*/
		$item = BlogCategory::find( $id );
		if (empty( $item )) {
			return back()
				->withErrors( ['msg' => "Запись id=[{$id}] не найдена"] )
				->withInput();
		}

		$data = $request->all();
		$request = $item
			->fill( $data )
			->save();

		if ($request) {
			return redirect()
				->route( 'blog.admin.categories.edit', $item->id )
				->with( ['success' => 'Успешно сохраненно'] );
		} else {
			return back()
				->withErrors( ['msg' => 'Ошибка сохранения'] )
				->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
