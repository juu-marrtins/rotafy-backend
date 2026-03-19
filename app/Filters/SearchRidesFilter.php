<?php

namespace App\Filters;

use Illuminate\Database\Query\Builder;

class SearchRidesFilter
{
    public function __construct(
        protected Builder $builder,
        protected array $queryParams
    ) {}

    public function applyFilter(): Builder {

        $this->search();
        $this->betweenDates();
        $this->beteweenPrices();
        
        return $this->builder;
    }

    public function search(): void {
        if($term = data_get($this->queryParams, 'term')) {
            $this->builder = $this->builder->where(function ($query) use ($term) {
                $query->whereHas('users',  function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%');
                });
                $query->orWhereHas('passengers', function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%');
                });
                $query->orWhere('destinaion_city', 'like', '%' . $term . '%')
                        ->orWhere('origin_city', 'like', '%' . $term . '%');
                });
        }
    }

    public function betweenDates(): void {
        $startDate = data_get($this->queryParams, 'start_date');
        $endDate = data_get($this->queryParams, 'end_date');

        if($startDate && $endDate) {
            $this->builder = $this->builder->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    public function beteweenPrices(): void {
        $minPrice = data_get($this->queryParams, 'min_price');
        $maxPrice = data_get($this->queryParams, 'max_price');

        if($minPrice && $maxPrice) {
            $this->builder = $this->builder->whereHas('ride_requests', function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('calculated_price', [$minPrice, $maxPrice]);
            });
        }
    }
}