<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Todo;

use League\Fractal;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\Serializer;

class TodoTransformer extends Fractal\TransformerAbstract
{
	public function transform(Todo $todo)
	{
        $serializer = new Serializer(array(new ObjectNormalizer()));

        return $serializer->normalize($todo);
	}
}
