<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The routes file is where you define your URL structure, which is an important part of the
 * [information architecture](http://en.wikipedia.org/wiki/Information_architecture) of your
 * application. Here, you can use _routes_ to match up URL pattern strings to a set of parameters,
 * usually including a controller and action to dispatch matching requests to. For more information,
 * see the `Router` and `Route` classes.
 *
 * @see lithium\net\http\Router
 * @see lithium\net\http\Route
 */
use lithium\net\http\Router;
use lithium\core\Environment;

Router::connect('/', 'Collections::index');

Router::connect('/{:controller}/{:action}/{:id}.{:type}', array('id' => null));
Router::connect('/{:controller}/{:action}/{:id}');
Router::connect('/{:controller}/{:action}/{:id}/{:args}');

Router::connect('/pages/{:args}', 'Pages::view');

Router::connect('/{:controller}/{:action}/{:args}');

?>