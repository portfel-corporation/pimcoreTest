<?php

	namespace App\Resources;
    Use Knp\Component\Pager\Pagination\SlidingPagination;
	class PaginatorResource extends AbstractResource
	{

		function toArray()
		{
            if(!$this->get instanceof SlidingPagination){
                return [];
            }

            return [
                    'current'=>$this->get->getCurrentPageNumber(),
                    'perPage'=>$this->get->getItemNumberPerPage(),
                    'itemsOnPage'=>$this->get->getPaginationData()['currentItemCount'],
                    'total'=>$this->get->getTotalItemCount(),
                    "last" => $this->get->getPaginationData()['last'],
                    "first" => $this->get->getPaginationData()['first'],
                    "pageCount" => $this->get->getPaginationData()['pageCount'],
                    "previous" => $this->get->getPaginationData()['pageCount'],
                    "rangeArray" => $this->get->getPaginationData()['pagesInRange'],
                ];

		}
	}
