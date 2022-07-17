<?php

	namespace App\Resources;
    use Carbon\Carbon;
    use Pimcore\Model\User;

    class BlogPostResource extends AbstractResource
	{


        public function toArray (){

            $AUTHOR = User::getById($this->get->getAuthor());
            $AUTHOR_FULL_NAME = "";
            if($AUTHOR){
                $AUTHOR_FULL_NAME = $AUTHOR->getFirstname()." ".$AUTHOR->getLastname();
            }



            $CATEGORIES_DATA = $this->get->getCategories();
;
            $CATEGORIES = array_map(function($cat){
                                    $a = new CategoryResource($cat);
                                    return $a->toArray();
                                },$CATEGORIES_DATA);

            $TAGS = $this->get->getTags();
            $TAGS = array_map(function($tag){
                                    $a =  new TagResource($tag);
                                    return $a->toArray();
                            },$TAGS);
            $RELATED_POSTS_DATA = $this->get->getRelatedPosts();
            $RELATED_POSTS = array_map(function($post){
                $a =  new BlogPostResource($post);
                return $a->toArray();
            },$RELATED_POSTS_DATA);
            /*
            * #filename: "5.1522753017.9267.jpg"
              #path: "/_default_upload_bucket/"
            */
            $IMAGE_URL = ($this->get->getImage()) ? $this->get->getImage()->getImage()->getFullPath() : '';
            $IMAGE_THUMB = ($this->get->getImage()) ? $this->get->getImage()->getImage()->getThumbnail("Post")->getHtml() : '';

            return [
                'title'=>$this->get->getTitle(),
                'short'=>$this->get->getShortDescription(),
                'content'=>$this->get->getContent(),
                'date'=>Carbon::parse($this->get->getDate())->toFormattedDateString(),
                'author'=>$AUTHOR_FULL_NAME,
                'slug'=>($this->get->getSlug()[0]) ? $this->get->getSlug()[0]->getSlug():'',
                'image_url'=>$IMAGE_URL,
                'image_thumb'=>$IMAGE_THUMB,
                'relatedPosts'=>$RELATED_POSTS,
                'tags'=>$TAGS,
                'cats'=>$CATEGORIES,
                'seoTitile'=>$this->get->getSeoTitile(),
                'seoDescription'=>$this->get->getSeoDescription(),
                'cannonicalUrl'=>$this->get->getCannonicalUrl(),
                'ogUrl'=>$this->get->getOgUrl(),
                'ogLocale'=>$this->get->getOgLocale(),
                'seoImage'=>$this->get->getSeoTitile(),
            ];
        }

	}
