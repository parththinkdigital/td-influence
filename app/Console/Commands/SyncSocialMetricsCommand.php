<?php

namespace App\Console\Commands;

use App\Models\SocialAccount;
use App\Services\SocialSyncService;
use Illuminate\Console\Command;

class SyncSocialMetricsCommand extends Command
{
    protected $signature = 'social:sync-metrics 
                            {--platform= : Specific platform to sync (instagram, youtube)}
                            {--limit=50 : Maximum number of accounts to sync in this batch}
                            {--force : Force sync even if synced recently}';

    protected $description = 'Sync live follower counts, subscriber metrics, and 30-day view analytics from official APIs';

    public function handle(SocialSyncService $syncService): int
    {
        $this->info('🚀 Starting social metrics synchronization...');

        $query = SocialAccount::with('talentProfile');

        if ($platform = $this->option('platform')) {
            $query->where('platform', strtolower($platform));
        }

        if (! $this->option('force')) {
            $query->where(function ($q) {
                $q->whereNull('last_synced_at')
                    ->orWhere('last_synced_at', '<', now()->subHours(12));
            });
        }

        $limit = (int) $this->option('limit');
        $accounts = $query->take($limit)->get();

        if ($accounts->isEmpty()) {
            $this->info('✓ All social accounts are up to date. No accounts pending sync.');

            return Command::SUCCESS;
        }

        $this->info("Found {$accounts->count()} social account(s) to synchronize.");

        $synced = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar($accounts->count());
        $bar->start();

        foreach ($accounts as $account) {
            $username = ltrim(trim($account->username), '@');
            $result = $syncService->fetchMetrics($account->platform, $username, $account->profile_url);

            if ($result['success'] && $result['followers'] !== null && $result['followers'] > 0) {
                $newFollowers = $result['followers'];
                $newViews = $result['views_30d'] ?? (int) ($newFollowers * 3.0);
                $recentMedia = ! empty($result['recent_media']) ? $result['recent_media'] : ($account->recent_media ?? []);
                $avgViews = $result['avg_views'] ?? $syncService->calculateAvgViews($account->platform, $newFollowers, $newViews, $recentMedia);
                $postsCount = $result['posts_count'] ?? $account->posts_count;

                $account->update([
                    'followers' => $newFollowers,
                    'views_30d' => $newViews,
                    'avg_views' => $avgViews,
                    'avg_likes' => $result['avg_likes'] ?? $account->avg_likes,
                    'avg_comments' => $result['avg_comments'] ?? $account->avg_comments,
                    'engagement_rate' => $result['engagement_rate'] ?? $account->engagement_rate,
                    'posts_count' => $postsCount,
                    'recent_media' => $recentMedia,
                    'is_verified' => true,
                    'last_synced_at' => now(),
                    'sync_source' => $result['source'],
                ]);
                $synced++;
            } else {
                $account->update([
                    'last_synced_at' => now(),
                    'sync_source' => $result['source'] ?: 'crawler_fallback',
                ]);
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✨ Sync complete! Successfully updated: {$synced}, Fallbacks/Unchanged: {$failed}");

        return Command::SUCCESS;
    }
}
