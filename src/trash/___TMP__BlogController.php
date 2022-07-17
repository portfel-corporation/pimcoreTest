<?php

	namespace App\Controller;
    use Pimcore\Controller\FrontendController;
    use Pimcore\Model\DataObject;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    use Symfony\Component\HttpFoundation\Request;

	class BlogController extends FrontendController
	{
        /**
         * @Template
         *
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function defaultAction(Request $request)
        {
            $data = new DataObject\Post\Listing();
            $data->setLimit($request->get('recnum') ?? 10);
            $data->setOrderKey("date");
            $data->setOrder("desc");
            $getData = $data->load();
            return $this->render('blog/posts.html.twig',['posts'=>$getData]);

        }
        /**
        * @return \Symfony\Component\HttpFoundation\Response
         */
        public function slugAction(Request $request, DataObject\Post $object, DataObject\Data\UrlSlug $urlSlug) {


            return $this->render('blog/single_post.html.twig',['posts'=>$object,'slug'=>$urlSlug]);
        }
	}
