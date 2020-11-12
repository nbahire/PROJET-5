<?php

namespace App\Controller\Api;

use App\Entity\Comments;
use Symfony\Component\Security\Core\Security;

class CommentCreateController
{
    private $security;

    /**
     * Class constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function __invoke(Comments $data)
    {

        $data->setUsers($this->security->getUser());

        return $data;
    }
}
