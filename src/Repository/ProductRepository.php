<?php
namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductCategory;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
	protected $logger;

	public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
    	$this->logger	= $logger;
		parent::__construct($registry, Product::class);
	}

	/**
	 * @param integer $id
	 * @return array: Product data including categories
	 */
	public function getProductFormData( $id=0 ): ?array
	{
		if( $id > 0){
			$product = $this->find($id);
		}else{
			$product = new Product();
			$product->setInPack(0);
			$product->setPacks(0);
			$product->setOutPack(0);
			$product->setPrice(0.0);
			$product->setTradePrice(0.0);
		}

		$categories	= $this->_em->getRepository(ProductCategory::class)->findBy([],['name'=>'ASC']);

		$form_categories	= [];

		foreach ( $categories as $cat )
			$form_categories[$cat->getName()]	= $cat->getId();

		return [
			'product'			=> $product,
			'form_categories'	=> $form_categories
		];
	}
//______________________________________________________________________________

	private function processProductCategories( Product $product, $formCategories ){

		$old_categories	= (empty( $product->getId()) ) ? [] : $product->getCategories();

		foreach( $old_categories as $old_category )
			$product->removeCategory( $old_category );

		foreach( $formCategories as $ategory_id )
			$product->addCategory($this->_em->getRepository(ProductCategory::class)->find($ategory_id));

		return $product;
	}
//______________________________________________________________________________

	private function replaceProductImage( $oldId, $newId ){
		$path	= __DIR__.'/../../public/images/uploads/';

		file_exists($path.'temp/product_image_'.$oldId)
			? rename($path.'temp/product_image_'.$oldId, $path.'product_image_'.$newId):null;
	}
//______________________________________________________________________________

	public function saveProductFormData( $post ){
		$product	= ( $post['id'] > 0 )
			? $this->find( $post['id'] )
			: new Product();

		$form_categories	= empty($post['formCategories']) ? [] : $post['formCategories'];
		$this->processProductCategories( $product, $form_categories );

		$product->setName($post['name']);
		$product->setPrice(str_replace(',', '.', $post['price']));
		$product->setTradePrice(str_replace(',', '.', $post['tradePrice']));
		$product->setPacks($post['packs']);
		$product->setInPack($post['inPack']);
		$product->setOutPack($post['outPack']);
		$product->setArticle($post['article']);
		$product->setIsActive(true);	//TODO: Must be checked the previous value for editing process.

		$this->_em->persist($product);
		$this->_em->flush();

		$this->replaceProductImage( $post['id'], $product->getId() );
	}
//______________________________________________________________________________

}
