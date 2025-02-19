<?php

namespace App\Services\Timetable;

use App\Models\CustomTimetableItem;
use App\Models\Timetable;
use App\Services\Print\PrintService;

class TimetableService
{
    //get all syllabus in semester and class
    public function getAllTimetablesInSemesterAndClass($semester_id, $class_id)
    {
        return Timetable::where('semester_id', $semester_id)->get()->filter(function ($timetable) use ($class_id) {
            return $timetable->my_class_id == $class_id;
        });
    }

    /**
     * Create timetable.
     *
     * @param mixed $data
     *
     * @return void
     */
    public function createTimetable($data)
    {
        Timetable::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'my_class_id' => $data['my_class_id'],
            'semester_id' => $data['semester_id'],
        ]);
    }

    /**
     * Update timetable.
     *
     * @param Timetable $timetable
     * @param mixed     $data
     *
     * @return void
     */
    public function updateTimetable(Timetable $timetable, $data)
    {
        $timetable->name = $data['name'];
        $timetable->description = $data['description'];
        $timetable->save();
    }

    /**
     * Print timetable.
     *
     * @param string $name
     * @param string $view
     * @param array  $data
     *
     * @return \Illuminate\Http\Response
     */
    public function printTimetable(string $name, string $view, array $data)
    {
        return PrintService::createPdfFromView($name, $view, $data)->download();
    }

    /**
     * Delete timetable.
     *
     * @param Timetable $timetable
     *
     * @return void
     */
    public function deleteTimetable(Timetable $timetable)
    {
        $timetable->delete();
    }

    /**
     * Get all custom timetable items in school.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomTimetableItem()
    {
        return CustomTimetableItem::where('school_id', auth()->user()->school_id)->get();
    }

    /**
     * Create custom timetable item.
     *
     * @param array<mixed> $record
     *
     * @return \App\Models\CustomTimetableItem
     */
    public function createCustomTimetableItem($record)
    {
        return CustomTimetableItem::create([
            'name'      => $record['name'],
            'school_id' => $record['school_id'],
        ]);
    }

    /**
     * Update a given customet timetable item.
     *
     * @param CustomTimetableItem $customTimetableItem
     * @param array<mixed>        $record
     *
     * @return \App\Models\CustomTimetableItem
     */
    public function updateCustomTimetableItem(CustomTimetableItem $customTimetableItem, $record)
    {
        $customTimetableItem->name = $record['name'];
        $customTimetableItem->save();

        return $customTimetableItem;
    }

    public function deleteCustomTimetableItem(CustomTimetableItem $customTimetableItem)
    {
        $customTimetableItem->timetableRecord()->delete();
        $customTimetableItem->delete();
    }
}
