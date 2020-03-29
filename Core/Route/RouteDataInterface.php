<?php namespace Core\Route;


/**
 * Interface RouteDataInterface
 * @package Core\Route
 */
interface RouteDataInterface {

    /**
     * @return array
     */
    public function getStaticRoutes();

    /**
     * @return array
     */
    public function getVariableRoutes();

    /**
     * @return array
     */
    public function getFilters();
}
