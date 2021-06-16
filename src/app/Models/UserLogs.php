<?php

declare(strict_types=1);

namespace App\Models;

use App\Infrastructure\Enums\LogTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperUserLogs
 */
class UserLogs extends Model
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param  string  $type
     *
     * @return UserLogs
     */
    public function setType(string $type): UserLogs
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param  int  $user_id
     *
     * @return UserLogs
     */
    public function setUserId(int $user_id): UserLogs
    {
        $this->user_id = $user_id;
        return $this;
    }

    protected $fillable = ['user_id', 'type', 'created_at', 'updated_at'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getUserActivity(int $userId, bool $lastMonth = false): array
    {
        if ($lastMonth) {
            $userLogs = UserLogs::where('user_id', '=', $userId)->orderBy('created_at')->get();
        } else {
            $userLogs = UserLogs::
            where('user_id', '=', $userId)
                ->where('created_at', '>', now()->subMonth()->toDateTime())
                ->orderBy('created_at')->get();
        }
        $result = [];
        $previous = null;
        $nextSkip = false;
        foreach ($userLogs as $log) {
            if ($previous === null) {
                $previous = $log;
                continue;
            }
            if ($nextSkip) {
                $nextSkip = false;
                $previous = null;
                continue;
            }
            if ($previous->type === LogTypes::LOGIN) {
                switch ($log->type) {
                    case LogTypes::LOGOUT:
                        $result[] = [
                            'Date' => $log->created_at,
                            'Login Time' => $previous->created_at->toTimeString(),
                            'Logout Time' => $log->created_at->toTimeString(),
                            'Time spend on system' => $log->created_at->diff($previous->created_at),
                            'Reason' => ''
                        ];
                        $nextSkip = true;
                        break;
                    case LogTypes::LOGIN_BLOCKED:
                        $result[] = [
                            'Date' => $previous->created_at,
                            'Login Time' => $previous->created_at->toTimeString(),
                            'Logout Time' => $log->created_at->toTimeString(),
                            'Time spend on system' => '',
                            'Reason' => 'Login in blocked account'
                        ];
                        break;
                    case LogTypes::FORCE_LOGOUT:
                        $result[] = [
                            'Date' => $log->created_at,
                            'Login Time' => $previous->created_at->toTimeString(),
                            'Logout Time' => $log->created_at->toTimeString(),
                            'Time spend on system' => '',
                            'Reason' => 'Detect unsuccessful force logout by time'
                        ];
                        break;
                }
            }
            $previous = $log;
        }
        return $result;
    }

    public static function isActiveByMonth(Carbon $month, int $userId): bool
    {
        $since = $month->startOfMonth()->toDateTime();
        $util = $month->endOfMonth()->toDateTime();
        return self::
            where('user_id', '=', $userId)
                ->where('created_at', '>', $since)
                ->where('created_at', '<', $util)
                ->where('type', '=', LogTypes::LOGIN)
                ->count() > 0;
    }

    public static function getSummaryActivityLastMonth(int $userId): string
    {
        $activity = self::getUserActivity($userId, true);
        $result = Carbon::create();
        foreach ($activity as $item) {
            if ($item['Time spend on system'] !== '') {
                $result->sub($item['Time spend on system']);
            }
        }
        return $result->toTimeString();
    }

    public static function numberOfCrashes(int $userId): int
    {
        $activity = self::getUserActivity($userId, true);
        $result = 0;
        foreach ($activity as $item) {
            if ($item['Reason'] !== '') {
                $result++;
            }
        }
        return $result;
    }
}
