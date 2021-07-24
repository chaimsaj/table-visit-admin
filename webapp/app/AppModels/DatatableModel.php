<?php


namespace App\AppModels;

use Illuminate\Support\Collection;

class DatatableModel
{
    public int $draw;
    public int $recordsTotal;
    public int $recordsFiltered;
    public Collection $data;

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }

    /**
     * @param int $draw
     */
    public function setDraw(int $draw): void
    {
        $this->draw = $draw;
    }

    /**
     * @return int
     */
    public function getRecordsTotal(): int
    {
        return $this->recordsTotal;
    }

    /**
     * @param int $recordsTotal
     */
    public function setRecordsTotal(int $recordsTotal): void
    {
        $this->recordsTotal = $recordsTotal;
    }

    /**
     * @return int
     */
    public function getRecordsFiltered(): int
    {
        return $this->recordsFiltered;
    }

    /**
     * @param int $recordsFiltered
     */
    public function setRecordsFiltered(int $recordsFiltered): void
    {
        $this->recordsFiltered = $recordsFiltered;
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    /**
     * @param Collection $data
     */
    public function setData(Collection $data): void
    {
        $this->data = $data;
    }
}
