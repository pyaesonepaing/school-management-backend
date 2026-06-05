<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementStoreRequest;
use App\Models\Announcement;
use App\Models\AnnouncementTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Announcement::with([
            'user',
            'targets'
        ])
        ->latest()
        ->get();
    }

    public function store(
        AnnouncementStoreRequest $request
    )
    {
        DB::beginTransaction();

        try {

            $announcement = Announcement::create([

                'user_id' => auth()->id(),

                'title' => $request->title,

                'message' => $request->message,

                'sender_role' => auth()->user()->role,

                'publish_at' => $request->publish_at,

                'expire_at' => $request->expire_at,

                'is_published' => $request->is_published ?? true,

            ]);

            foreach ($request->targets as $target) {

                AnnouncementTarget::create([

                    'announcement_id' => $announcement->id,

                    'target_type' => $target['target_type'],

                    'target_id' => $target['target_id'] ?? null,

                ]);

            }

            DB::commit();

            return response()->json([
                'message' => 'Announcement created.',
                'data' => $announcement->load('targets')
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(
        Announcement $announcement
    )
    {
        return $announcement->load([
            'user',
            'targets'
        ]);
    }

    public function update(
        AnnouncementStoreRequest $request,
        Announcement $announcement
    )
    {
        DB::beginTransaction();

        try {

            $announcement->update([

                'title' => $request->title,

                'message' => $request->message,

                'publish_at' => $request->publish_at,

                'expire_at' => $request->expire_at,

                'is_published' => $request->is_published,

            ]);

            $announcement
                ->targets()
                ->delete();

            foreach ($request->targets as $target) {

                AnnouncementTarget::create([

                    'announcement_id' => $announcement->id,

                    'target_type' => $target['target_type'],

                    'target_id' => $target['target_id'] ?? null,

                ]);

            }

            DB::commit();

            return response()->json([
                'message' => 'Announcement updated.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy(
        Announcement $announcement
    )
    {
        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted.'
        ]);
    }
}