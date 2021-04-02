<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCatalogMainJob extends AbstractJob

{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->debug( 'start' );

		//сначало кэшируем продукты
		GenerateCatalogChacheJob::dispatchNow();

		//Затем создаем цепочку заданий формирования файлов с ценами
		$chainPrices = $this->getChainPrices();

		//Основные подзадачи
		$chainMain = [
			new GenerateCategoriesJob(), //генерация категорий
			new GenerateDeliveriesJob(), //Генерация способов доставки
			new GeneratePointsJob(), //Генерация пунктов выдачи
		];

		//Подзадачи которые должны выполняться самыми последними

		$chainLast = [
			//Архивирование файлов и перенос архива в публичную папку
			new AchiveUploadsJob,
			//Отправка уведомления сторонниму сервису о том, что можно скачать новый файл каталога товара
			new SendPriceRequestJob,
		];

		$chain = array_merge( $chainPrices, $chainMain, $chainLast );

		GenerateGoodsFileJob::withChain( $chain )->dispatch();
//		GenerateGoodsFileJob::dispatch()->chain($chain);

		$this->debug( 'finish' );
	}

	/**
	 * Формирование цепочек подзадач по генерации файлов с ценами
	 *
	 * @return array
	 */
	private function getChainPrices()
	{
		$result = [];
		$products = collect( [1, 2, 3, 4, 5] );
		$fileNum = 1;

		foreach ($products->chunk( 1 ) as $chunk) {
			$result[] = new GeneratePricesFileChunkJob( $chunk, $fileNum );
			$fileNum ++;
		}

		return $result;
	}
}
