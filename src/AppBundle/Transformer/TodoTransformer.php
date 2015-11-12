<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Todo;
use League\Fractal;

class TodoTransformer extends Fractal\TransformerAbstract
{
	public function transform(Todo $todo)
	{
	    return array(
	        'id' => (int) $todo->getId(),
	        'title' => (string) $todo->getTitle(),
	        'isCompleted' => (string) $todo->getIsCompleted(),
        );
	}
}
