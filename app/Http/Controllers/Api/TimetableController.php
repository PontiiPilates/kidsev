<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function organizationsAll(): JsonResponse
    {
        $list = Organization::orderBy('district_id')->paginate($this->count);

        $content = $this->organizationsTemplate($list);

        return response()->json($this->responseTemplate(null, $content, $list->lastPage(), $list->currentPage()));
    }

    public function organizationsByDistrict(Request $request): JsonResponse
    {
        try {
            $list = Organization::where('district_id', $request->id)->paginate($this->count);
        } catch (\Throwable $th) {
            return response()->json(['data' => []]);
        }

        $content = $this->organizationsTemplate($list);

        return response()->json($this->responseTemplate(null, $content, $list->lastPage(), $list->currentPage()));
    }

    public function timetableByOrganization(Request $request): JsonResponse
    {
        try {
            $organization = Organization::where('code', $request->code)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json(['data' => []]);
        }

        $list = $this->timetable
            ->where('organization_id', $organization->id)
            ->paginate($this->count);

        $content = $this->timetableTemplate($list);
        $title = $this->organizationTitle($organization);

        return response()->json($this->responseTemplate($title, $content, $list->lastPage(), $list->currentPage()));
    }

    private function organizationTitle(Organization $organization): string
    {
        $title = '🏡 ' . $organization->short_name . "\n";
        $title .= '🗺 ' . $organization->address;

        return $title;
    }

    private function timetableTemplate($list): string
    {
        $content = '';

        foreach ($list->items() as $key => $item) {

            $day = $item->day->name;

            $time = $item->time_end
                ? Carbon::parse($item->time_start)->format('G:i') . '-' . Carbon::parse($item->time_end)->format('G:i')
                : Carbon::parse($item->time_start)->format('G:i');

            $time = $item->event
                ? $item->date . ' ' . $time
                : $time;

            $prefix = $item->program ? '🔸' : '🔹';

            $title = $item->program->name ?? $item->event->name;

            $content .= '⌚️ ' . $day . ' ' . $time . "\n";
            $content .= $prefix . ' ' . $title;

            // устанавливает конечный символ переноса и разделитель элементов
            if ($key < $list->count() - 1) {
                $content .= "\n";
                $content .= "\n";
            }
        }

        return $content;
    }

    private function organizationsTemplate($list): string
    {
        $content = '';

        foreach ($list->items() as $key => $item) {

            $content .= '🏷 ' . '/' . $item->code . ' ' . "*$item->short_name*" . "\n";
            $content .= '🗺 ' . $item->address;

            // устанавливает конечный символ переноса и разделитель элементов
            if ($key < $list->count() - 1) {
                $content .= "\n";
                $content .= "\n";
            }
        }

        return $content;
    }

    private function responseTemplate($title = null, $content, $lasPage = null, $currentPage = null)
    {
        return array_filter([
            'data' => array_filter([
                'content' => $content,
                'title' => $title,
            ]),
            'meta' => array_filter([
                'last_page' => $lasPage,
                'current_page' => $currentPage,
            ])
        ]);
    }
}
