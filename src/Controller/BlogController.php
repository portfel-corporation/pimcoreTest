<?php

	namespace App\Controller;
    use App\Resources\BlogPostResource;
    use App\Resources\CategoryResource;
    use Pimcore\Controller\FrontendController;
    use Pimcore\Model\DataObject\BlogPost;
    use Pimcore\Model\DataObject\BlogPostCategory;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    use Symfony\Component\HttpFoundation\Request;
    use Pimcore\Model\DataObject\Data\UrlSlug;

	class BlogController extends FrontendController
	{
        /**
         * @Template
         *
         * @param Request $request
         *
         * @return \Symfony\Component\HttpFoundation\Response
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

            return $this->render('blog/index.html.twig',['data'=>$renderData]);
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

        public function slugCatAction(Request $request, BlogPostCategory $object) {

            $data = new BlogPost\Listing();
            $data->filterByCategories($object);
            $getData = $data->load();

            $renderData = array_map(function($post){
                $a = new BlogPostResource($post);
                return $a->toArray();
            },$getData);

            return $this->render('blog/index.html.twig',['data'=>$renderData]);
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

	}
