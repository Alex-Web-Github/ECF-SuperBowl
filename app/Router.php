<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\NoConfigurationException;


class Router
{
  public function __invoke(RouteCollection $routes)
  {
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());

    // On crée un objet UrlMatcher qui va permettre de "matcher" les routes
    $matcher = new UrlMatcher($routes, $context);

    try {
      $arrayUri = explode('?', $_SERVER['REQUEST_URI']);
      $matcher = $matcher->match($arrayUri[0]);

      // On convertit les paramètres en entiers s'ils sont numériques (number ou string)
      array_walk($matcher, function (&$param) {
        if (is_numeric($param)) {
          $param = (int) $param;
        }
      });

      $className = '\\App\\Controllers\\' . $matcher['controller'];
      $classInstance = new $className();

      // On ajoute les routes à la collection de routes
      $params = array_merge(array_slice($matcher, 2, -1), array('routes' => $routes));

      // On appelle la méthode de la classe correspondante
      call_user_func_array(array($classInstance, $matcher['method']), array_values($params));
    } catch (\Exception $e) {
      header('Location: ' . $routes->get('404')->getPath());
      exit();
    }
  }
}

// Je crée une instance de la classe Router et je lui passe en paramètre la collection de routes
$router = new Router();
$router($routes);
