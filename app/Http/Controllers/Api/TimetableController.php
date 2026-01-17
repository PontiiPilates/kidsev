<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimetableResource;
use App\Models\Organization;
use App\Models\Timetable;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class TimetableController extends Controller
{
    /** @var Timetable $timetable */
    private $timetable;

    /** @var int $count */
    private $count = 10;

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

    public function all(Request $request): JsonResponse
    {
        $list = $this->timetable
            ->with('day')
            ->with('program')
            ->with('event')
            ->with('organization')
            ->paginate($this->count);

        $template = '';
        foreach ($list->items() as $key => $item) {
            $day = $item->day->name;
            $title = $item->program->name ?? $item->event->name;
            $prefix = $item->program ? '🔸' : '🔹';


            $time = $item->time_end
                ? Carbon::parse($item->time_start)->format('G:i') . '-' . Carbon::parse($item->time_end)->format('G:i')
                : Carbon::parse($item->time_start)->format('G:i');

            $time = $item->event ? $item->date . ' ' . $time : $time;


            $template .= '⌚️ ' . $day . ' ' . $time . "\n";
            $template .= $prefix . ' ' . $title . "\n";
            $template .= '🗺 ' . $item->organization->address . ', ' . $item->organization->short_name . "\n";

            if ($key < $list->count() - 1) {
                $template .= "\n";
            }
        }

        return response()->json([
            'data' => $template,
            'meta' => [
                'last_page' => $list->lastPage(),
                'current_page' => $list->currentPage(),
            ]
        ]);
    }

    public function district(Request $request): JsonResponse
    {
        $list = $this->timetable
            ->where('district_id', $request->id)
            ->with('day')
            ->with('program')
            ->with('event')
            ->with('organization')
            ->paginate($this->count);

        $template = '';
        foreach ($list->items() as $key => $item) {
            $day = $item->day->name;
            $title = $item->program->name ?? $item->event->name;
            $prefix = $item->program ? '🔸' : '🔹';


            $time = $item->time_end
                ? Carbon::parse($item->time_start)->format('G:i') . '-' . Carbon::parse($item->time_end)->format('G:i')
                : Carbon::parse($item->time_start)->format('G:i');

            $time = $item->event ? $item->date . ' ' . $time : $time;


            $template .= '⌚️ ' . $day . ' ' . $time . "\n";
            $template .= $prefix . ' ' . $title . "\n";
            $template .= '🗺 ' . $item->organization->address . ', ' . $item->organization->short_name . "\n";

            if ($key < $list->count() - 1) {
                $template .= "\n";
            }
        }

        return response()->json([
            'data' => $template,
            'meta' => [
                'last_page' => $list->lastPage(),
                'current_page' => $list->currentPage(),
            ]
        ]);
    }

    public function organizations(Request $request): JsonResponse
    {
        $list = Organization::orderBy('district_id')->paginate($this->count);

        $template = '';
        foreach ($list->items() as $key => $item) {
            $template .= '🏷 ' . $item->code . ' ' . $item->short_name . "\n";
            $template .= '🗺 ' . $item->address . "\n";

            if ($key < $list->count() - 1) {
                $template .= "\n";
            }
        }

        return response()->json([
            'data' => $template,
            'meta' => [
                'last_page' => $list->lastPage(),
                'current_page' => $list->currentPage(),
            ]
        ]);
    }

    public function organization(Request $request): JsonResponse
    {
        try {
            $organization = Organization::orderBy('district_id')->where('code', $request->code)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
            ]);
        }


        $list = $this->timetable
            ->where('organization_id', $organization->id)
            ->paginate($this->count);


        $template = '';
        foreach ($list->items() as $key => $item) {
            if ($key == 0) {
                $template .= '🏡 ' . $item->organization->short_name . "\n";
                $template .= '🗺 ' . $item->organization->address . "\n";
                $template .= "\n";
            }

            $day = $item->day->name;
            $title = $item->program->name ?? $item->event->name;
            $prefix = $item->program ? '🔸' : '🔹';


            $time = $item->time_end
                ? Carbon::parse($item->time_start)->format('G:i') . '-' . Carbon::parse($item->time_end)->format('G:i')
                : Carbon::parse($item->time_start)->format('G:i');

            $time = $item->event ? $item->date . ' ' . $time : $time;


            $template .= '⌚️ ' . $day . ' ' . $time . "\n";
            $template .= $prefix . ' ' . $title . "\n";

            if ($key < $list->count() - 1) {
                $template .= "\n";
            }
        }

        return response()->json([
            'data' => $template,
            'meta' => [
                'last_page' => $list->lastPage(),
                'current_page' => $list->currentPage(),
            ]
        ]);
    }

    public function organizationExists() {}

    public function events(Request $request): JsonResource
    {
        $this->timetable->whereNull('program_id');
        return TimetableResource::collection($this->timetable->paginate($this->count));
    }
}
