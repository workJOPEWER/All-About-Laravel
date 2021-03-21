<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/**
 *Базовый контроллер для всех контроллеров управления
 * блогом и панели администрирования.
 *
 * Должен быть родителем всез контроллеров управления блогом.
 *
 * @package App\Http\Controllers\Blog|Admin
 */
abstract class BaseController extends GuestBaseController
{
	public function __construct()
	{
		//Инициализация общих моментов для админки.
	}
}
