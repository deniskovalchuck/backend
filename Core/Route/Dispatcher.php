<?php namespace Core\Route;

use Core\Route\Exception\HttpMethodNotAllowedException;
use Core\Route\Exception\HttpRouteNotFoundException;
use function Couchbase\basicEncoderV1;

class Dispatcher {

    private $staticRouteMap;
    private $variableRouteData;
    private $filters;
    private $handlerResolver;
    public $matchedRoute;

    /**
     * Create a new route dispatcher.
     *
     * @param RouteDataInterface $data
     * @param HandlerResolverInterface $resolver
     */
    public function __construct(RouteDataInterface $data, HandlerResolverInterface $resolver = null)
    {
        $this->staticRouteMap = $data->getStaticRoutes();

        $this->variableRouteData = $data->getVariableRoutes();
        
        $this->filters = $data->getFilters();
        
        if ($resolver === null)
        {
        	$this->handlerResolver = new HandlerResolver();
        }
        else
        {
        	$this->handlerResolver = $resolver;
        }
    }

    /**
     * Dispatch a route for the given HTTP Method / URI.
     *
     * @param $httpMethod
     * @param $uri
     * @return mixed|null
     */
    public function dispatch($httpMethod, $uri)
    {
        try {

            list($handler, $filters, $vars) = $this->dispatchRoute($httpMethod, trim($uri, '/'));

            list($beforeFilter, $afterFilter) = $this->parseFilters($filters);

            if($this->dispatchFilters($beforeFilter,$httpMethod,$uri)===false)
            {
                return false;
            }
            $resolvedHandler = $this->handlerResolver->resolve($handler);

            $response = call_user_func_array($resolvedHandler, $vars);

            return $this->dispatchFilters($afterFilter,$httpMethod,$uri, $response);
        }
        catch (\Exception $ex)
        {

            header('HTTP/1.1 401 OK');
            header('Location: http://'.$_SERVER['HTTP_HOST']);
            exit();
        }
    }

    /**
     * Dispatch a route filter.
     *
     * @param $filters
     * @param $httpMethod
     * @param null $response
     * @return mixed|null
     */
    private function dispatchFilters($filters,$httpMethod,$uri, $response = null)
    {
        while($filter = array_shift($filters))
        {
            if($filter::handle($httpMethod,$uri)==false)
            {
                return false;
            }
        }
        
        return $response;
    }

    /**
     * Normalise the array filters attached to the route and merge with any global filters.
     *
     * @param $filters
     * @return array
     */
    private function parseFilters($filters)
    {        
        $beforeFilter = array();
        $afterFilter = array();
        
        if(isset($filters[Route::BEFORE]))
        {
            $beforeFilter = array_intersect_key($this->filters, array_flip((array) $filters[Route::BEFORE]));
        }

        if(isset($filters[Route::AFTER]))
        {
            $afterFilter = array_intersect_key($this->filters, array_flip((array) $filters[Route::AFTER]));
        }
        
        return array($beforeFilter, $afterFilter);
    }

    private function dispatchRoute($httpMethod, $uri)
    {
        if (isset($this->staticRouteMap[$uri]))
        {
            return $this->dispatchStaticRoute($httpMethod, $uri);
        }
        try {
            return $this->dispatchVariableRoute($httpMethod, $uri);

        }
        catch (HttpRouteNotFoundException $exception)
        {
            if (isset($this->staticRouteMap['*']))
                return $this->dispatchStaticRoute($httpMethod, '*');
            else

                throw new HttpMethodNotAllowedException('404');

        }
    }

    /**
     * Handle the dispatching of static routes.
     *
     * @param $httpMethod
     * @param $uri
     * @return mixed
     * @throws Exception\HttpMethodNotAllowedException
     */
    private function dispatchStaticRoute($httpMethod, $uri)
    {
        $routes = $this->staticRouteMap[$uri];

        if (!isset($routes[$httpMethod]))
        {
            $httpMethod = $this->checkFallbacks($routes, $httpMethod);
        }
        return $routes[$httpMethod];
    }

    /**
     * Check fallback routes: HEAD for GET requests followed by the ANY attachment.
     *
     * @param $routes
     * @param $httpMethod
     * @throws Exception\HttpMethodNotAllowedException
     */
    private function checkFallbacks($routes, $httpMethod)
    {
        $additional = array(Route::ANY);
        
        if($httpMethod === Route::HEAD)
        {
            $additional[] = Route::GET;
        }
        
        foreach($additional as $method)
        {
            if(isset($routes[$method]))
            {
                return $method;
            }
        }
        $this->matchedRoute = $routes;
        throw new HttpMethodNotAllowedException('Allow: ' . implode(', ', array_keys($routes)));
    }

    /**
     * Handle the dispatching of variable routes.
     *
     * @param $httpMethod
     * @param $uri
     * @throws Exception\HttpMethodNotAllowedException
     * @throws Exception\HttpRouteNotFoundException
     */
    private function dispatchVariableRoute($httpMethod, $uri)
    {
        foreach ($this->variableRouteData as $data) 
        {
            if (!preg_match($data['regex'], $uri, $matches))
            {
                continue;
            }

            $count = count($matches);

            while(!isset($data['routeMap'][$count++]));
            
            $routes = $data['routeMap'][$count - 1];

            if (!isset($routes[$httpMethod]))
            {
                $httpMethod = $this->checkFallbacks($routes, $httpMethod);
            } 

            foreach (array_values($routes[$httpMethod][2]) as $i => $varName)
            {
                if(!isset($matches[$i + 1]) || $matches[$i + 1] === '')
                {
                    unset($routes[$httpMethod][2][$varName]);
                }
                else
                {
                    $routes[$httpMethod][2][$varName] = $matches[$i + 1];
                }
            }

            return $routes[$httpMethod];
        }

        throw new HttpRouteNotFoundException('Route ' . $uri . ' does not exist');
    }
}
