<?php

	namespace App\Resources;

	use Pimcore\Model\DataObject\BlogPostCategory as Instance;

    class CategoryResource extends AbstractResource
	{


        public function toArray()
        {

            /*
              "dest_id" => 21
              "id" => 21
              "type" => "object"
              "subtype" => "BlogPostCategory"
              "published" => "1"
              "path" => "/Categories/Cat2"
              "index" => 1
            */
            if($this->get instanceof Instance){
                return [
                    'id'=>$this->get->getId(),
                    'name'=>$this->get->getName(),
                    'desc'=>$this->get->getDesc(),
                    'slug'=>(!empty($this->get->getSlug())) ? $this->get->getSlug()[0]->getSlug(): '',
                ];
            }else{
                return [];
            }

        }
    }
