<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Todo;

use League\Fractal;

class TodoTransformer extends Fractal\TransformerAbstract
{
    private $jmsSerializer;

    public function __construct($jmsSerializer)
    {
        $this->jmsSerializer = $jmsSerializer;
    }

	public function transform(Todo $todo)
	{
        return json_decode($this->jmsSerializer->serialize($todo, 'json'));
	}
}
