<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\TimetableResource;
use App\Models\Event;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KidsevBotController extends Controller
{
    public function timetable(Request $request): JsonResource
    {
        return TimetableResource::collection(Timetable::paginate(3));
    }
}
