<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(
        Request $request
    )
    {
        $student = $request->user()->student;

        $batchIds = $student
            ->batches
            ->pluck('id');

        return Announcement::with('targets')
            ->where('is_published', true)
            ->where(function ($query) use (
                $student,
                $batchIds
            ) {

                $query->whereHas(
                    'targets',
                    function ($q) {

                        $q->where(
                            'target_type',
                            'all'
                        );

                    }
                )

                ->orWhereHas(
                    'targets',
                    function ($q) use (
                        $student
                    ) {

                        $q->where(
                            'target_type',
                            'student'
                        )
                        ->where(
                            'target_id',
                            $student->id
                        );

                    }
                )

                ->orWhereHas(
                    'targets',
                    function ($q) use (
                        $batchIds
                    ) {

                        $q->where(
                            'target_type',
                            'batch'
                        )
                        ->whereIn(
                            'target_id',
                            $batchIds
                        );

                    }
                );

            })
            ->latest()
            ->get();
    }
}