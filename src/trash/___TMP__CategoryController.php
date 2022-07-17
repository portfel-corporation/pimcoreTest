<?php

	namespace App\Controller;
    namespace App\Controller;
    use Pimcore\Controller\FrontendController;
    use Pimcore\Model\DataObject;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    use Symfony\Component\HttpFoundation\Request;

	class CategoryController extends FrontendController
	{

        /**
         * @Template
         *
         * @param Request $request
         *
         * @return array
         */
        public function defaultAction(Request $request)
        {
              return [];
        }
        /**
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function slugAction(Request $request, DataObject\Categorie $object, DataObject\Data\UrlSlug $urlSlug) {
            $data = new DataObject\Post\Listing();
            $data->filterByCategorie($object);
            $getData = $data->load();
            return $this->render('blog/posts.html.twig',['posts'=>$getData,'slug'=>$urlSlug]);
        }
	}
