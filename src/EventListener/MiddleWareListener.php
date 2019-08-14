<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

use Psr\Log\LoggerInterface;
use App\CInterface\AuxToolsInterface;

/**
 * Class EventListener
 *
 * @author Constantine Nawata <const.nawata@gmail.com>
 * @package App\Service
 */
class MiddleWareListener
{

	private $logger;

	protected $tools;

    /**
     * @param LoggerInterface $logger
	 * @param AuxToolsInterface $tools
     */
    public function __construct( LoggerInterface $logger, AuxToolsInterface $tools )
    {
        $this->logger	= $logger;
        $this->tools	= $tools;
    }
//______________________________________________________________________________

    public function onKernelController( ControllerEvent $event ){
//    	$controller	= $event->getController();
//		$class	= get_class($controller[0]);
//		$method	= $controller[1];

//		$namedArguments = $event->getRequest()->attributes->all();
//		$controllerArguments = $event->getArguments();
    }
//______________________________________________________________________________

	public function onKernelControllerArguments( ControllerArgumentsEvent $event )
	{
		$args	= $event->getArguments();
		$method	= $args[0]->attributes->get('_controller');

		switch( $method ){
			case 'App\Controller\ProductController::getProductsTable':
				if( $args[0]->request->has('showSold')){
					$show_sold	= $args[0]->request->get('showSold');
					$this->tools->saveState(['showSold' => $show_sold]);
				}else{
					$state		= $this->tools->getState();
					$show_sold	= $state['showSold'] ?? $state['showSold'];
				}

				$args[0]->request->add(['showSold' => $show_sold]);
			break;
		}

		$event->setArguments( $args );
	}
//______________________________________________________________________________

	public function onKernelResponse( ResponseEvent $event )
	{
	}
//______________________________________________________________________________

}//Class end