<?php

namespace App\OutputHandler;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class MetaAdder{
    private $data;
    private $meta;

    public function __construct(Pagerfanta $data){
        $this->data = $data->getCurrentPageResults();
        $this->setMeta('limit', $data->getMaxPerPage());
        $this->setMeta('current_items', count($data->getCurrentPageResults()));
        $this->setMeta('total_items', $data->getNbResults());
        $this->setMeta('offset', $data->getCurrentPageOffsetStart());
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}