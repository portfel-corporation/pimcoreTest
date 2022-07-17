<?php

	namespace App\Resources;



    abstract class AbstractResource
	{
        protected object|null|array $get;

        public function __construct($data)
        {
            $this->get = $data;
            if (is_null($this->get) || empty($this->get)) {
                return [];
            }
            return is_array($this->get)
                ? $this->get
                : $this->toArray();

        }
        abstract function toArray();
	}
