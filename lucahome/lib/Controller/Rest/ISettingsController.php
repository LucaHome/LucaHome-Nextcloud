<?php

namespace OCA\LucaHome\Controller\Rest;

interface ISettingsController {

	/**
     * @param string entity
	 * @return JSONResponse
	 */
	public function getSorting($entity = "");

	/**
     * @param string entity
     * @param string sorting
	 * @return JSONResponse
	 */
	public function setSorting($entity = "", $sorting = "");

	/**
     * @param string entity
	 * @return JSONResponse
	 */
	public function getViewMode($entity = "");

	/**
     * @param string entity
     * @param string sorting
	 * @return JSONResponse
	 */
	public function setViewMode($entity = "", $viewMode = "");
}