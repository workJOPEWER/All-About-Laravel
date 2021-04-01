<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{

	/**@var BlogCategoryRepository */

	private $blogCategoryRepository;

	/**
	 * CategoryController constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->blogCategoryRepository = app( BlogCategoryRepository::class );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$paginator = $this->blogCategoryRepository->getAllWithPaginate( 5 );

		return view( 'blog.admin.categories.index', compact( 'paginator' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
//		dd( __METHOD__ );

		$item = new BlogCategory();
		$categoryList
			= $this->blogCategoryRepository->getForComboBox();

		return view( 'blog.admin.categories.edit',
			compact( 'item', 'categoryList' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param BlogCategoryCreateRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BlogCategoryCreateRequest $request)
	{
		$data = $request->input(); /* получаем данные*/

		//создаем объект и добавляем в БД
		$item = (new BlogCategory())->create( $data );

		if ($item) {
			return redirect()->route( 'blog.admin.categories.edit', [$item->id] )
				->with( ['success' => 'Успешно сохранено'] );
		} else {
			return back()->withErrors( ['msg' => 'Ошибка сохрания'] )
				->withInput();
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @param BlogCategoryRepository $categoryRepository
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$item = $this->blogCategoryRepository->getEdit( $id );
		if (empty( $item )) {
			abort( 404 );
		}
		$categoryList
			= $this->blogCategoryRepository->getForComboBox(); /*выподающий список*/

		return view( 'blog.admin.categories.edit',
			compact( 'item', 'categoryList' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  BlogCategoryUpdateRequest $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(BlogCategoryUpdateRequest $request, $id)
	{

		$item = $this->blogCategoryRepository->getEdit( $id );
		if (empty( $item )) {
			return back()
				->withErrors( ['msg' => "Запись id=[{$id}] не найдена"] )
				->withInput();
		}

		$data = $request->all();


		$request = $item->update( $data );
//			->fill( $data )
//			->save();

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
