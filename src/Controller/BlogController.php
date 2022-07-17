<?php

	namespace App\Controller;
    use App\Resources\BlogPostResource;
    use App\Resources\CategoryResource;
    use App\Resources\PaginatorResource;
    use Pimcore\Controller\FrontendController;
    use Pimcore\Model\DataObject\BlogPost;
    use Pimcore\Model\DataObject\BlogPostCategory;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    use Symfony\Component\HttpFoundation\Request;

    Use Knp\Component\Pager\PaginatorInterface;

	class BlogController extends FrontendController
	{
        /**
         * @Template
         *
         * @param Request $request
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction(Request $request, PaginatorInterface $paginator)
        {
            $data = new BlogPost\Listing();
            $data->setOrderKey("date");
            $data->setOrder("desc");
            return $this->renderWithPaginator($paginator, $data, $request);
        }
        /**
         * @Template
         */
        public function blogPostAction (Request $request){

            if ('object' === $request->get('type')) {
                $post = BlogPost::getById($request->get('id'));
                $res = new BlogPostResource($post);
                return [
                    'data'=>$res->toArray(),
                ];
            }

            return [];
        }
        public function slugAction(Request $request, BlogPost $object) {

            $res = new BlogPostResource($object);
            return $this->render('blog/show.html.twig',['data'=>$res->toArray()]);
        }

        public function slugCatAction(Request $request, BlogPostCategory $object, PaginatorInterface $paginator) {

            $data = new BlogPost\Listing();
            $data->filterByCategories($object);
            return $this->renderWithPaginator($paginator, $data, $request);
        }
        /**
         * @Template
         *
         * @param Request $request
         *
         * @return array
         */
        public function categorySnippetAction (Request $request){
            $res = new BlogPostCategory\Listing();
            $getData = $res->load();
            $renderData = array_map(function($cat){
                $a = new CategoryResource($cat);
                return $a->toArray();
            },$getData);
            return ['data'=>$renderData];
        }

        /**
         * @param PaginatorInterface $paginator
         * @param BlogPost\Listing $data
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function renderWithPaginator(PaginatorInterface $paginator, BlogPost\Listing $data, Request $request): \Symfony\Component\HttpFoundation\Response
        {
            $paginator = $paginator->paginate($data, $request->get('page', 1), 10);

            $renderData = array_map(function ($post) {
                $a = new BlogPostResource($post);
                return $a->toArray();
            }, (array)$paginator->getItems());
            $paginationData = new PaginatorResource($paginator);

            return $this->render('blog/index.html.twig', ['data' => $renderData, 'pagination' => $paginationData->toArray()]);
        }

    }
