<?php


namespace App\Services;


use App\Models\Language;
use App\Models\State;
use App\Repositories\LanguageRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LanguageService implements LanguageServiceInterface
{
    private LanguageRepositoryInterface $repository;

    public function __construct(LanguageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?Language
    {
        return $this->repository->find($id);
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function actives(): Collection
    {
        return $this->repository->actives();
    }

    public function published(): Collection
    {
        return $this->repository->published();
    }

    public function deleteLogic($id): bool
    {
        return $this->repository->deleteLogic($id);
    }
}
