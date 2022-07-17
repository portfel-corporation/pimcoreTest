<?php

	namespace App\Controller;
    use App\Resources\BlogPostResource;
    use Pimcore\Controller\FrontendController;
    use Pimcore\Model\DataObject\BlogPost;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
	class HomeController extends FrontendController
	{
        /**
         * @Template
         *
         * @param Request $request
         *
         * @return Response
         */
        public function indexAction(Request $request)
        {
            $data = new BlogPost\Listing();
            $data->setLimit($request->get('recnum') ?? 10);
            $data->setOrderKey("date");
            $data->setOrder("desc");
            $getData = $data->load();
            $renderData = array_map(function($post){
                $a = new BlogPostResource($post);
                return $a->toArray();
            },$getData);

            return $this->render('home/index.html.twig',['data'=>$renderData]);
        }

        /**
         * @route("/search")
         * @return Response
         */
        public function searchAction(Request $request){
            $keyword = $request->get('keyword');
            $renderData = [];

            if(strlen($keyword)>3){
                $data = new BlogPost\Listing();
                $data->setLimit($request->get('recnum') ?? 10);
                $data->setCondition("title LIKE :keyword OR content LIKE :keyword", ["keyword" => "%".$keyword."%"]);
                $data->setOrderKey("date");
                $data->setOrder("desc");
                $getData = $data->load();
                $renderData = array_map(function($post){
                    $a = new BlogPostResource($post);
                    return $a->toArray();
                },$getData);
            }



            return $this->render('home/search.html.twig',['data'=>$renderData]);
        }
	}
