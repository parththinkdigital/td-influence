<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_profile_id',
        'platform',
        'username',
        'profile_url',
        'followers',
        'following',
        'posts_count',
        'avg_views',
        'views_30d',
        'avg_likes',
        'avg_comments',
        'engagement_rate',
        'audience_demographics',
        'recent_media',
        'is_verified',
        'last_synced_at',
        'sync_source',
        'access_token',
        'token_expires_at',
        'instagram_user_id',
    ];

    protected $casts = [
        'views_30d' => 'integer',
        'engagement_rate' => 'decimal:2',
        'audience_demographics' => 'array',
        'recent_media' => 'array',
        'is_verified' => 'boolean',
        'last_synced_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }

    /**
     * Format numbers into compact human-readable format (1K, 10K, 100K, 1.2M, 10M, etc.)
     */
    public static function formatCount(int|float|null $number, int $precision = 1): string
    {
        $num = (float) ($number ?? 0);
        if ($num >= 1000000000) {
            $val = round($num / 1000000000, $precision);

            return ($val == (int) $val ? (int) $val : $val).'B';
        }
        if ($num >= 1000000) {
            $val = round($num / 1000000, $precision);

            return ($val == (int) $val ? (int) $val : $val).'M';
        }
        if ($num >= 20000) {
            $val = round($num / 1000, $precision);

            return ($val == (int) $val ? (int) $val : $val).'K';
        }

        return number_format((int) $num);
    }

    public function getFormattedFollowersAttribute(): string
    {
        return self::formatCount($this->followers);
    }

    public function getFormattedViews30dAttribute(): string
    {
        return self::formatCount($this->views_30d);
    }

    public function getFormattedAvgViewsAttribute(): string
    {
        return self::formatCount($this->avg_views);
    }
}
