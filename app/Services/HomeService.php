<?php

namespace App\Services;

use App\Repositories\HomeRepository;

class HomeService
{
    private $homeRepository;
    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getCategories()
    {
        return $this->homeRepository->getCategories();
    }

    public function storeNewsletter(array $newsLetterInput)
    {
        $this->homeRepository->storeNewsletter($newsLetterInput);
    }

    public function getSliders()
    {
        return $this->homeRepository->getSliders();
    }

    public function getSimpleAdvertises()
    {
        return $this->homeRepository->getSimpleAdvertises();
    }
}
