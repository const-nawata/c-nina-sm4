<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 *
 * @author Nawata
 *
 */
class IndexController extends AbstractController{

/**
 * @Route("/")
 */
	public function index(){
		$number = random_int(0, 100);

		return new Response(
			'<html><body>Lucky number: '.$number.'</body></html>'
		);
	}
}
