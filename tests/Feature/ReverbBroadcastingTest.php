<?php

use App\Events\MessageSent;
use App\Events\NotificationBroadcasted;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Conversation;
use App\Models\TalentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->brandUser = User::factory()->create([
        'role' => 'brand',
        'password' => Hash::make('password123'),
    ]);
    $this->brandProfile = BrandProfile::create([
        'user_id' => $this->brandUser->id,
        'company_name' => 'Apex Brands Ltd',
    ]);

    $this->talentUser = User::factory()->create([
        'role' => 'influencer',
        'password' => Hash::make('password123'),
    ]);
    $this->talentProfile = TalentProfile::create([
        'user_id' => $this->talentUser->id,
        'display_name' => 'Aarav Sharma',
        'username' => 'aarav_sharma',
    ]);

    $this->campaign = Campaign::create([
        'brand_profile_id' => $this->brandProfile->id,
        'title' => 'Summer Monsoon Campaign',
        'campaign_name' => 'Summer Monsoon Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'summer-monsoon-campaign',
        'description' => 'Summer harvest reel showcase in Nashik.',
        'budget_min' => 40000,
        'budget_max' => 60000,
        'city' => 'Nashik',
        'status' => 'published',
    ]);

    $this->application = CampaignApplication::create([
        'campaign_id' => $this->campaign->id,
        'talent_profile_id' => $this->talentProfile->id,
        'quoted_price' => 50000,
        'cover_note' => 'Ready to produce premium reel assets',
        'status' => 'applied',
    ]);

    $this->conversation = Conversation::create([
        'campaign_id' => $this->campaign->id,
        'brand_user_id' => $this->brandUser->id,
        'talent_user_id' => $this->talentUser->id,
        'application_id' => $this->application->id,
    ]);
});

test('brand sending a message broadcasts MessageSent and NotificationBroadcasted events', function () {
    Event::fake([MessageSent::class, NotificationBroadcasted::class]);

    $response = $this->actingAs($this->brandUser)->postJson("/brand/chat/{$this->conversation->id}/send", [
        'message_text' => 'Hello Aarav, looking forward to working with you!',
    ]);

    $response->assertStatus(200);
    $response->assertJsonPath('success', true);

    Event::assertDispatched(MessageSent::class, function ($event) {
        return $event->message->conversation_id === $this->conversation->id
            && $event->message->message_text === 'Hello Aarav, looking forward to working with you!'
            && $event->broadcastOn()[0]->name === 'private-chat.'.$this->conversation->id;
    });

    Event::assertDispatched(NotificationBroadcasted::class, function ($event) {
        return $event->notification->user_id === $this->talentUser->id
            && $event->broadcastOn()[0]->name === 'private-user.'.$this->talentUser->id;
    });
});

test('influencer sending a message broadcasts MessageSent and NotificationBroadcasted events', function () {
    Event::fake([MessageSent::class, NotificationBroadcasted::class]);

    $response = $this->actingAs($this->talentUser)->postJson("/influencer/chat/{$this->conversation->id}/send", [
        'message_text' => 'Thanks! I have received your brief and can start immediately.',
    ]);

    $response->assertStatus(200);
    $response->assertJsonPath('success', true);

    Event::assertDispatched(MessageSent::class, function ($event) {
        return $event->message->conversation_id === $this->conversation->id
            && $event->broadcastOn()[0]->name === 'private-chat.'.$this->conversation->id;
    });

    Event::assertDispatched(NotificationBroadcasted::class, function ($event) {
        return $event->notification->user_id === $this->brandUser->id
            && $event->broadcastOn()[0]->name === 'private-user.'.$this->brandUser->id;
    });
});

test('submitting a commercial offer broadcasts MessageSent with proposal data', function () {
    Event::fake([MessageSent::class, NotificationBroadcasted::class]);

    $response = $this->actingAs($this->brandUser)->postJson("/brand/chat/{$this->conversation->id}/send", [
        'message_text' => 'Offering 55,000 for 1 Reel with 30-day ad rights.',
        'proposal_price' => 55000,
        'usage_rights' => 'digital_ads_30d',
        'revisions_included' => 2,
        'exclusivity_days' => 14,
    ]);

    $response->assertStatus(200);

    Event::assertDispatched(MessageSent::class, function ($event) {
        $data = $event->broadcastWith();

        return (float) $data['proposal_price'] === 55000.0
            && $data['usage_rights'] === 'digital_ads_30d'
            && $data['revisions_included'] === 2
            && $data['exclusivity_days'] === 14;
    });
});

test('broadcasting channel authorization authorizes conversation participants and rejects outsiders', function () {
    config([
        'broadcasting.default' => 'reverb',
        'broadcasting.connections.reverb.key' => 'test_key',
        'broadcasting.connections.reverb.secret' => 'test_secret',
        'broadcasting.connections.reverb.app_id' => '12345',
    ]);
    Broadcast::purge();
    require base_path('routes/channels.php');
    $outsider = User::factory()->create(['role' => 'brand']);

    // Brand user authorizes successfully
    $authBrand = $this->actingAs($this->brandUser)->post('/broadcasting/auth', [
        'channel_name' => 'private-chat.'.$this->conversation->id,
        'socket_id' => '1234.5678',
    ]);
    $authBrand->assertStatus(200);
    $authBrand->assertSee('auth');

    // Talent user authorizes successfully
    $authTalent = $this->actingAs($this->talentUser)->post('/broadcasting/auth', [
        'channel_name' => 'private-chat.'.$this->conversation->id,
        'socket_id' => '1234.5678',
    ]);
    $authTalent->assertStatus(200);
    $authTalent->assertSee('auth');

    // Outsider user is rejected
    $authOutsider = $this->actingAs($outsider)->post('/broadcasting/auth', [
        'channel_name' => 'private-chat.'.$this->conversation->id,
        'socket_id' => '1234.5678',
    ]);
    $authOutsider->assertStatus(403);
});

test('user channel authorization allows owner and rejects other users', function () {
    config([
        'broadcasting.default' => 'reverb',
        'broadcasting.connections.reverb.key' => 'test_key',
        'broadcasting.connections.reverb.secret' => 'test_secret',
        'broadcasting.connections.reverb.app_id' => '12345',
    ]);
    Broadcast::purge();
    require base_path('routes/channels.php');
    $otherUser = User::factory()->create(['role' => 'influencer']);

    // Owner can authorize their channel
    $authOwner = $this->actingAs($this->talentUser)->post('/broadcasting/auth', [
        'channel_name' => 'private-user.'.$this->talentUser->id,
        'socket_id' => '1234.5678',
    ]);
    $authOwner->assertStatus(200);
    $authOwner->assertSee('auth');

    // Other user cannot authorize this channel
    $authOther = $this->actingAs($otherUser)->post('/broadcasting/auth', [
        'channel_name' => 'private-user.'.$this->talentUser->id,
        'socket_id' => '1234.5678',
    ]);
    $authOther->assertStatus(403);
});
