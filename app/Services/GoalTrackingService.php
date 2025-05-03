<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\GoalProgressLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GoalTrackingService
{
    /**
     * Get active goals for a user.
     *
     * @param User $user
     * @return Collection
     */
    public function getActiveGoals(User $user): Collection
    {
        return Goal::with('category')
            ->where('user_id', $user->id)
            ->where('end_date', '>=', now())
            ->orderBy('end_date')
            ->get();
    }
    
    /**
     * Log progress for a goal.
     *
     * @param Goal $goal
     * @param int $progressValue
     * @param Carbon $date
     * @param string|null $note
     * @param User $user
     * @return GoalProgressLog
     */
    public function logProgress(Goal $goal, int $progressValue, Carbon $date, ?string $note, User $user): GoalProgressLog
    {
        // Check if log already exists for this date
        $existingLog = GoalProgressLog::where('goal_id', $goal->id)
            ->where('progress_date', $date->toDateString())
            ->first();
            
        if ($existingLog) {
            $existingLog->progress_value = $progressValue;
            $existingLog->note = $note;
            $existingLog->updated_by = $user->id;
            $existingLog->updated_date = now();
            $existingLog->save();
            
            return $existingLog;
        }
        
        // Create new log
        $log = new GoalProgressLog();
        $log->goal_id = $goal->id;
        $log->user_id = $user->id;
        $log->progress_value = $progressValue;
        $log->progress_date = $date->toDateString();
        $log->note = $note;
        $log->created_by = $user->id;
        $log->save();
        
        return $log;
    }
    
    /**
     * Get progress statistics for a goal.
     *
     * @param Goal $goal
     * @return array
     */
    public function getGoalStats(Goal $goal): array
    {
        $logs = $goal->progressLogs()->orderBy('progress_date')->get();
        $totalProgress = $logs->sum('progress_value');
        $percentage = $goal->target_value > 0 
            ? min(100, ($totalProgress / $goal->target_value) * 100) 
            : 0;
            
        $dailyAverage = 0;
        $daysRemaining = 0;
        $estimatedCompletion = null;
        
        // Calculate daily average if there are logs
        if ($logs->count() > 0) {
            $firstLog = $logs->first();
            $lastLog = $logs->last();
            $daysDifference = Carbon::parse($firstLog->progress_date)->diffInDays(Carbon::parse($lastLog->progress_date)) + 1;
            $dailyAverage = $daysDifference > 0 ? $totalProgress / $daysDifference : $totalProgress;
            
            // Calculate days remaining and estimated completion
            $remaining = $goal->target_value - $totalProgress;
            $daysRemaining = $dailyAverage > 0 ? ceil($remaining / $dailyAverage) : 0;
            
            if ($dailyAverage > 0) {
                $estimatedCompletion = Carbon::today()->addDays($daysRemaining);
            }
        }
        
        // Calculate on track status
        $onTrack = false;
        if ($goal->end_date) {
            $daysUntilDeadline = Carbon::today()->diffInDays(Carbon::parse($goal->end_date), false);
            $remainingValue = $goal->target_value - $totalProgress;
            $neededDailyAverage = $daysUntilDeadline > 0 ? $remainingValue / $daysUntilDeadline : $remainingValue;
            $onTrack = $daysUntilDeadline >= 0 && ($dailyAverage >= $neededDailyAverage || $percentage >= 100);
        }
        
        return [
            'total_progress' => $totalProgress,
            'percentage' => round($percentage, 1),
            'daily_average' => round($dailyAverage, 1),
            'days_remaining' => $daysRemaining,
            'estimated_completion' => $estimatedCompletion,
            'on_track' => $onTrack,
        ];
    }
    
    /**
     * Get goals by category.
     *
     * @param User $user
     * @return array
     */
    public function getGoalsByCategory(User $user): array
    {
        $goals = Goal::with('category')
            ->where('user_id', $user->id)
            ->get();
            
        $result = [];
        
        foreach ($goals as $goal) {
            $categoryId = $goal->category_id;
            $categoryName = $goal->category->name;
            
            if (!isset($result[$categoryId])) {
                $result[$categoryId] = [
                    'name' => $categoryName,
                    'goals' => [],
                    'active_count' => 0,
                    'completed_count' => 0,
                ];
            }
            
            $result[$categoryId]['goals'][] = $goal;
            
            if (Carbon::parse($goal->end_date)->isPast()) {
                $result[$categoryId]['completed_count']++;
            } else {
                $result[$categoryId]['active_count']++;
            }
        }
        
        return $result;
    }
} 