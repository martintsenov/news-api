<?php

namespace NewsApp\Repository;

interface RepositoryInterface
{
    public function data(int $resultPerPage): array;
}
