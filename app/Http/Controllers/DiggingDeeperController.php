<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateCatalog\GenerateCatalogMainJob;
use App\Jobs\ProcessVideoJob;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
	/**
	 * Базовая информация:
	 * @url https://laravel.com/docs/8.x/collections
	 *
	 * Справочная информация:
	 * @url https://laravel.com/api/8.x/Illuminate/Support/Collection.html
	 *
	 * Вариант коллекции для моделей
	 * @url https://laravel.com/api/8.x/Illuminate/Database/Eloquent/Collection.html
	 *
	 * Билдер запросов - то с чем можно перепутать коллекции:
	 * @url https://laravel.com/docs/8.x/queries
	 *
	 */

	public function collections()
	{
		$result = [];

		/**
		 * @var \Illuminate\Database\Eloquent\Collection $eloquentCollection
		 */
		$eloquentCollection = BlogPost::withTrashed()->get();

		//dd( __METHOD__, $eloquentCollection, $eloquentCollection->toArray() );

		/**
		 * @var \Illuminate\Database\Eloquent\Collection $eloquentCollection
		 */
		//$collection = collect() //empty collection
		$collection = collect( $eloquentCollection->toArray() );

//		dd( get_class( $eloquentCollection ),
//			get_class( $collection ),
//			$collection
//		);

//		$result['first'] = $collection->first();
//		$result['last'] = $collection->last();

//		$result['where'] ['data'] = $collection
//			->where('category_id', 10)
//			->values()
//			->keyBy('id');
//		dd($result);

		//работаем с выборкой
//		$result['where'] ['count'] =$result['where'] ['data']->count();
//		$result['where'] ['isEmpty'] =$result['where'] ['data']->isEmpty();
//		$result['where'] ['isNotEmpty'] =$result['where'] ['data']->isNotEmpty();
//		dd($result);

//		//не очень красиво
//		if($result['where']['count']) {
//			//.....
//		}
//
//		//так лучше
//		if($result['where']['data']->isNotEmpty()) {
//			//...
//	}

		//получаем элемент по заданным условиям
//		$result['where_first'] = $collection
//			->firstWhere('create_at', '>', '2019-01-17 01:35:11');

		//Базовая переменная не измениттся. Просто вернется измененная версия.
//		$result['map']['all'] = $collection->map(function (array $item) {
//			$newItem = new \stdClass();
//			$newItem -> item_id = $item['id'];
//			$newItem -> item_name = $item['title'];
//			$newItem -> exists = is_null($item['deleted_at']);
//
//			return $newItem;
//		});

		//получаем список не существующих = удаленных записей
//		$result['map']['not_exists'] = $result['map']['all']
//			->where('exists', '=', false);

//		dd($result);


		//Базовая переменная изменяется (трансформируется) старая пропадает.
//		$collection->transform(function (array $item) {
//			$newItem = new \stdClass();
//			$newItem -> item_id = $item['id'];
//			$newItem -> item_name = $item['title'];
//			$newItem -> exists = is_null($item['deleted_at']);
//			$newItem -> created_at = Carbon::parse($item['created_at']);
//
//			return $newItem;
//		});

//		dd($collection);


		$newItem = new \stdClass();
		$newItem->id = 9999;

		$newItem2 = new \stdClass();
		$newItem2->id = 8888;

		//Установить элемент в начало коллекции
//		$newsItemFirst = $collection->prepend( $newItem )->first();
//		$newsItemLast = $collection->push( $newItem2 )->last();
//		$pulledItem = $collection->pull( 1 ); //забрать элемент
//
//		dd( compact( 'collection', 'newsItemFirst', 'newsItemLast', 'pulledItem' ) );

		//Фильтрация. Замена  orWhere()
//		$filtered = $collection->filter( function ($item) {
//			$byDay = $item->created_at->isFriday();
//			$byDate = $item->created_at->day == 11;

//			$result = $item->created_at->isFriday() && ($item->created_at->day == 11);

//			$result = $byDay && $byDate;
//
//			return $result;
//		} );
//
//		dd( compact( 'filtered' ) );

//		//сортировочка
//		$sortedSimpleCollection = collect( [5, 3, 1, 2, 4] )->sort();
//		$sortedAscCollection = $collection->sortBy( 'created_at' );
//		$sortedDescCollection = $collection->sortByDesc( 'item_id' );

//		dd( compact( 'sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection' ) );

	}

	public function processVideo()
	{
		ProcessVideoJob::dispatch()
			//Отсрочка выполнения задания от момента посещения в очередь.
			//не влияет на паузу между попытками выполнять задачу.
			//->delay(10)
			//->onQueue('name_of_queue")
		;
	}

	/**
	 *
	 */

	public function prepareCatalog()
	{
		GenerateCatalogMainJob::dispatch();
	}
}
