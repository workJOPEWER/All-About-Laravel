<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

/**
 * Управление статьями блога
 *
 * @package App\Http\Controllers\Blog\Admin
 */
class PostController extends BaseController
{
	/**
	 * @var BlogPostRepository;
	 */
	private $blogPostRepository;

	private $blogCategoryRepository;

	/**
	 *PostController constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->blogPostRepository = app( BlogPostRepository::class );
		$this->blogCategoryRepository = app( BlogCategoryRepository::class );
	}

	public function index()
	{
		$paginator = $this->blogPostRepository->getAllWithPaginate();
		return view( 'blog.admin.posts.index', compact( 'paginator' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$item = new BlogPost();
		$categoryList = $this->blogCategoryRepository->getForComboBox();

		return view( 'blog.admin.posts.edit',
			compact( 'item', 'categoryList' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  BlogPostCreateRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BlogPostCreateRequest $request)
	{
		$data = $request->input();
		$item = (new BlogPost())
			->create( $data );

		if ($item) {
			return redirect()->route( 'blog.admin.posts.edit', [$item->id] )
				->with( ['success' => ' Vse okeushki'] );
		} else {
			return back()
				->withErrors( ['msg' => 'Oshibochka'] )
				->withInput();
		}
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
//        dd(__METHOD__, $id);
		$item = $this->blogPostRepository->getEdit( $id );
		if (empty( $item )) {
			abort( 404 );
		}
		$categoryList
			= $this->blogCategoryRepository->getForComboBox(); /*выподающий список*/

		return view( 'blog.admin.posts.edit',
			compact( 'item', 'categoryList' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  BlogPostUpdateRequest $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(BlogPostUpdateRequest $request, $id)
	{
		$item = $this->blogPostRepository->getEdit( $id );

		if (empty( $item )) {
			return back()
				->withErrors( ['msg' => "Запись id=[{$id}] не найдена"] )
				->withInput();
		}

		$data = $request->all();

		$result = $item->update( $data );

		if ($result) {
			return redirect()
				->route( 'blog.admin.posts.edit', $item->id )
				->with( ['success' => 'Vse okeushki'] );
		} else {
			return back()
				->withErrors( ['msg' => 'Ai, ai, ai mistake on update'] )
				->withInput();

		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $request)
	{
		dd( __METHOD__, $request->all(), $id );
	}
}
