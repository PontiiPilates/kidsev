<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Timetable;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class KidsevBotController extends Controller
{
    /** @var Timetable $timetable */
    private $timetable;

    /** @var int $count */
    private $count = 10;

    /** @var TemplateService $templateService*/
    private $templateService;

    public function __construct()
    {
        $this->timetable = Timetable::query()
            ->where(function ($q) {
                $q->whereNull('date')
                    ->orWhere('date', '>=', now());
            })
            ->orderBy('day_id')
            ->orderBy('time_start');

        $this->templateService = new TemplateService();
    }

    public function organizationsAll(): JsonResponse
    {
        $list = Organization::orderBy('district_id')->paginate($this->count);

        $content = $this->templateService->organizationsTemplate($list);

        $response = $this->templateService->responseTemplate(null, $content, $list->lastPage(), $list->currentPage());

        return response()->json($response);
    }

    public function organizationsByDistrict(Request $request): JsonResponse
    {
        try {
            $list = Organization::where('district_id', $request->id)->paginate($this->count);
        } catch (\Throwable $th) {
            return response()->json(['data' => []]);
        }

        $content = $this->templateService->organizationsTemplate($list);

        $response = $this->templateService->responseTemplate(null, $content, $list->lastPage(), $list->currentPage());

        return response()->json($response);
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

        $content = $this->templateService->timetableTemplate($list);
        $title = $this->templateService->organizationTitle($organization);

        $response = $this->templateService->responseTemplate($title, $content, $list->lastPage(), $list->currentPage());

        return response()->json($response);
    }
}
