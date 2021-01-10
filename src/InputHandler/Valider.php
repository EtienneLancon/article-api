<?php

namespace App\InputHandler;

use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use App\Exception\NotFoundException;
use App\Repository\AbstractRepository;

class Valider
{
    static public function throwOnViolation(ConstraintViolationList $violations)
    {
        if(count($violations)){
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
    }

    static public function returnFoundOrThrow(AbstractRepository $repo, int $id)
    {
        $item = $repo->find($id);
        if(!$item) throw new NotFoundException('Unable to find object with id '.$id);
        else return $item;
    }
}