<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchRidesFilter
{
    public function __construct(
        protected Builder $builder,
        protected array $queryParams
    ) {}

    public function applyFilter(): Builder {

        $this->search();
        $this->seats();

        return $this->builder;
    }

    public function search(): void {
        $destination = data_get($this->queryParams, 'destination');
        $origin = data_get($this->queryParams, 'origin');

        if($destination && $origin) {
            $this->builder = $this->builder->where(function ($query) use ($destination, $origin) {
                $query->where('destination_city', 'like', '%' . $destination . '%')
                        ->orWhere('origin_city', 'like', '%' . $origin . '%');
            });
        }
    }

    public function seats(): void {
        $this->builder = $this->builder->where('avaliable_seats', '!=', 0);
    }
}
