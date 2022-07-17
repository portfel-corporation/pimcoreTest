<?php

	namespace App\Resources;



    class TagResource extends AbstractResource
	{


        public function toArray()
        {

            return [
                'id'=>$this->get->getId(),
                'name'=>$this->get->getName(),
                'desc'=>$this->get->getDesc(),
                'slug'=>(!empty($this->get->getSlug())) ? $this->get->getSlug()[0]->getSlug(): '',

            ];
        }
    }
