<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Badge;

class AssignBadgeCommand extends Command
{
    protected $signature = 'app:assign-badge-command';
    protected $description = 'Star badge for 100 first reviewer';

    public function handle()
    {
        $this->info('🔄 Đang kiểm tra và gán badge...');

        DB::beginTransaction();
        try {
            $badge = Badge::find(1);
            if (!$badge) {
                $this->error('❌ Badge với ID = 1 không tồn tại.');
                return Command::FAILURE;
            }

            $users = User::where('role', 1)
                ->orderBy('id', 'asc')
                ->limit(100)
                ->get();

            $count = 0;
            foreach ($users as $user) {
                if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                    $user->badges()->attach($badge->id);
                    $count++;
                }
            }

            DB::commit();
            $this->info("✅ Đã gán badge '{$badge->name}' cho {$count} người dùng.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Lỗi: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
