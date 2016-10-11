<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'views/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['login'] = 'views/login';
$route['register'] = 'views/register';
$route['reset-password/(:any)'] = 'views/newPassword/$1';
$route['forgot-password'] = 'views/forgotPassword';
$route['profile/(:any)'] = 'views/profile/$1';
$route['edit/profile/(:any)'] = 'views/editProfilePage/$1';
$route['logout'] = 'user/logout';
$route['activated'] = 'views/accountActivated';
$route['new/operator'] = 'views/newOperator';
$route['operator/(:any)'] = 'views/operatorProfile/$1';
$route['edit/operator/(:any)'] = 'views/editOperatorProfile/$1';
$route['add/animal/(:any)'] = 'views/addAnimal/$1';
$route['add-animal-stock'] = 'views/addAnimalStock';
$route['edit-animal/(:any)'] = 'views/editMyAnimalType/$1';
$route['edit-animal-stock/(:any)'] = 'views/editMyAnimalStock/$1';
$route['my-animal'] = 'views/myAnimals';
$route['my-animal-stock'] = 'views/myAnimalsStock';
$route['message/(:any)'] = 'views/message/$1';
$route['product/(:any)'] = 'views/product/$1';
$route['product/ownerview/(:any)'] = 'views/productOwnerview/$1';
$route['search'] = 'views/search';
$route['home'] = 'views/home';
$route['checkout'] = 'views/checkout';
$route['incoming-orders'] = 'views/incomingOrders';
$route['my-orders'] = 'views/myOrders';
$route['orders'] = 'views/orders';
$route['traders'] = 'views/traders';
$route['operators'] = 'views/operators';
$route['faq'] = 'views/faq';
$route['edit-faq'] = 'views/editFaq';
$route['animal-bought'] = 'views/bought';
$route['about-us'] = 'views/aboutUs';

$route['test'] = 'views/test';