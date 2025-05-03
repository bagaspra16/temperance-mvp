<?php

namespace App\Services;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HabitTrackingService
{
    /**
     * Get habits scheduled for today for a specific user.
     *
     * @param User $user
     * @return Collection
     */
    public function getTodayHabits(User $user): Collection
    {
        $today = Carbon::today();
        $dayOfWeek = $today->dayOfWeekIso; // 1 (Monday) to 7 (Sunday)
        
        return Habit::with(['goal', 'goal.category'])
            ->where('user_id', $user->id)
            ->where('active', true)
            ->get()
            ->filter(function ($habit) use ($dayOfWeek) {
                return $habit->isScheduledForDay($dayOfWeek);
            });
    }
    
    /**
     * Log a habit completion for a specific date.
     *
     * @param Habit $habit
     * @param Carbon $date
     * @param bool $status
     * @param string|null $note
     * @param User $user
     * @return HabitLog
     */
    public function logHabit(Habit $habit, Carbon $date, bool $status, ?string $note, User $user): HabitLog
    {
        // Check if log already exists
        $existingLog = HabitLog::where('habit_id', $habit->id)
            ->where('log_date', $date->toDateString())
            ->first();
            
        if ($existingLog) {
            $existingLog->status = $status;
            $existingLog->note = $note;
            $existingLog->updated_by = $user->id;
            $existingLog->updated_date = now();
            $existingLog->save();
            
            return $existingLog;
        }
        
        // Create new log
        $log = new HabitLog();
        $log->habit_id = $habit->id;
        $log->user_id = $user->id;
        $log->log_date = $date->toDateString();
        $log->status = $status;
        $log->note = $note;
        $log->created_by = $user->id;
        $log->save();
        
        return $log;
    }
    
    /**
     * Calculate streak information for a habit.
     *
     * @param Habit $habit
     * @return array
     */
    public function getStreakInfo(Habit $habit): array
    {
        $logs = $habit->logs()
            ->where('status', true)
            ->orderBy('log_date')
            ->get()
            ->pluck('log_date')
            ->map(function ($date) {
                return Carbon::parse($date);
            });
            
        if ($logs->isEmpty()) {
            return [
                'current' => 0,
                'longest' => 0,
            ];
        }
        
        // Calculate longest streak
        $longestStreak = 1;
        $currentStreak = 1;
        
        for ($i = 1; $i < $logs->count(); $i++) {
            $prevDate = clone $logs[$i-1];
            $currDate = $logs[$i];
            
            if ($prevDate->addDay()->isSameDay($currDate)) {
                $currentStreak++;
            } else {
                $longestStreak = max($longestStreak, $currentStreak);
                $currentStreak = 1;
            }
        }
        
        $longestStreak = max($longestStreak, $currentStreak);
        
        // Calculate current streak
        $logs = $logs->reverse()->values();
        $today = Carbon::today();
        
        // Check if most recent log is today or yesterday
        if (count($logs) > 0 && !$logs[0]->isSameDay($today) && !$logs[0]->isSameDay($today->copy()->subDay())) {
            $currentStreak = 0;
        } else {
            $currentStreak = 1;
            
            for ($i = 1; $i < $logs->count(); $i++) {
                $prevDate = clone $logs[$i-1];
                $currDate = $logs[$i];
                
                if ($prevDate->subDay()->isSameDay($currDate)) {
                    $currentStreak++;
                } else {
                    break;
                }
            }
        }
        
        return [
            'current' => $currentStreak,
            'longest' => $longestStreak,
        ];
    }
    
    /**
     * Get completion statistics for a specific time period.
     *
     * @param User $user
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function getCompletionStats(User $user, Carbon $startDate, Carbon $endDate): array
    {
        $logs = HabitLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();
            
        $totalLogs = $logs->count();
        $completedLogs = $logs->where('status', true)->count();
        
        return [
            'total' => $totalLogs,
            'completed' => $completedLogs,
            'percentage' => $totalLogs > 0 ? round(($completedLogs / $totalLogs) * 100, 1) : 0,
        ];
    }
} 