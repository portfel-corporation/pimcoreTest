<?php

	namespace App\Controller;
    use App\Resources\BlogPostResource;
    use App\Resources\PaginatorResource;
    use Knp\Component\Pager\PaginatorInterface;
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
        public function indexAction(Request $request, PaginatorInterface $paginator)
        {
            $data = new BlogPost\Listing();
            $data->setOrderKey("date");
            $data->setOrder("desc");
            return $this->renderWithPaginator($paginator, $data, $request,'home/index.html.twig');
        }

        /**
         * @route("/search")
         * @return Response
         */
        public function searchAction(Request $request , PaginatorInterface $paginator){
            $keyword = $request->get('keyword');
            $data = [];

            if(strlen($keyword)>3){
                $data = new BlogPost\Listing();
                $data->setLimit($request->get('recnum') ?? 10);
                $data->setCondition("title LIKE :keyword OR content LIKE :keyword", ["keyword" => "%".$keyword."%"]);
                $data->setOrderKey("date");
                $data->setOrder("desc");
                return $this->renderWithPaginator($paginator, $data, $request,'home/search.html.twig');
            }
            return $this->render('home/search.html.twig',['data'=>[]]);

        }


        /**
         * @param PaginatorInterface $paginator
         * @param BlogPost\Listing $data
         * @param Request $request
         * @param string $TEMPLATE
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function renderWithPaginator(
            PaginatorInterface $paginator,
            BlogPost\Listing $data,
            Request $request,
            string $TEMPLATE = "default/default.html.twig"
        ): Response
        {
            $paginator = $paginator->paginate($data, $request->get('page', 1), 10);

            $renderData = array_map(function ($post) {
                $a = new BlogPostResource($post);
                return $a->toArray();
            }, (array)$paginator->getItems());
            $paginationData = new PaginatorResource($paginator);

            return $this->render($TEMPLATE, ['data' => $renderData, 'pagination' => $paginationData->toArray()]);
        }


	}
