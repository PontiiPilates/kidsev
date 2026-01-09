<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimetableResource;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableController extends Controller
{
    /** @var Timetable $timetable */
    private $timetable;

    /** @var int $count */
    private $count = 200;

    public function __construct()
    {
        $this->timetable = Timetable::query()
            ->where(function ($q) {
                $q->whereNull('date')
                    ->orWhere('date', '>=', now());
            })
            ->orderBy('day_id')
            ->orderBy('time_start');
    }

    public function all(Request $request): JsonResource
    {
        return TimetableResource::collection($this->timetable->paginate($this->count));
    }

    public function district(Request $request): JsonResource
    {
        $this->timetable->where('district_id', $request->id);
        return TimetableResource::collection($this->timetable->paginate($this->count));
    }

    public function organization(Request $request): JsonResource
    {
        $this->timetable->where('organization_id', $request->id);
        return TimetableResource::collection($this->timetable->paginate($this->count));
    }

    public function events(Request $request): JsonResource
    {
        $this->timetable->whereNull('program_id');
        return TimetableResource::collection($this->timetable->paginate($this->count));
    }
}
