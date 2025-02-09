<?php

namespace App\Observers;

use App\Models\SalesProjects;
use App\Notifications\SalesProjectUpdated;

class SalesProjectObserver
{
    public function updated(SalesProjects $project)
    {
        // รายชื่อผู้ที่ต้องได้รับการแจ้งเตือน
        $usersToNotify = collect([
            $project->responsible_admin,
            $project->responsible_pm,
            $project->responsible_contractor
        ])->filter()->unique(); // กรองค่าที่ไม่เป็น null

        foreach ($usersToNotify as $userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                $user->notify(new SalesProjectUpdated($project));
            }
        }
    }
}
