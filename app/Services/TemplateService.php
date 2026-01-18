<?php

namespace App\Services;

use App\Models\Organization;
use Carbon\Carbon;

class TemplateService
{
    public function organizationTitle(Organization $organization): string
    {
        $title = '🏡 ' . $organization->short_name . "\n";
        $title .= '🗺 ' . $organization->address;

        return $title;
    }

    public function timetableTemplate($list): string
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

    public function organizationsTemplate($list): string
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

    public function responseTemplate($title = null, $content, $lasPage = null, $currentPage = null)
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
