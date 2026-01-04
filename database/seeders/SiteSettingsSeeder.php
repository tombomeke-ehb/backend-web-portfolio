<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Portfolio',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your website',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Developer Portfolio',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Tagline',
                'description' => 'Short tagline shown in headers/metadata',
            ],
            [
                'key' => 'site_description',
                'value' => 'My personal portfolio website',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'A short description for SEO purposes',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Maintenance Mode',
                'description' => 'Enable to show a maintenance page to visitors',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'We are currently performing maintenance. Please check back soon.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Maintenance Message',
                'description' => 'Message shown to visitors when maintenance mode is enabled',
            ],

            // Features Settings
            [
                'key' => 'comments_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'features',
                'label' => 'Enable Comments',
                'description' => 'Allow users to comment on news articles',
            ],
            [
                'key' => 'comments_require_approval',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'features',
                'label' => 'Comments Require Approval',
                'description' => 'New comments must be approved by admin before showing',
            ],
            [
                'key' => 'contact_form_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'features',
                'label' => 'Enable Contact Form',
                'description' => 'Allow visitors to send contact messages',
            ],
            [
                'key' => 'registration_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'features',
                'label' => 'Allow Registration',
                'description' => 'Allow new users to register accounts',
            ],
            [
                'key' => 'public_profiles_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'features',
                'label' => 'Enable Public Profiles',
                'description' => 'Allow viewing user profiles via /u/{username}',
            ],

            // Contact Settings
            [
                'key' => 'admin_email',
                'value' => 'admin@example.com',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Admin Email',
                'description' => 'Email address for admin notifications',
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@example.com',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'Public contact email address',
            ],
            [
                'key' => 'contact_subject_prefix',
                'value' => '[Portfolio] ',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Contact Subject Prefix',
                'description' => 'Prefix added to outgoing email subjects',
            ],

            // Social Settings
            [
                'key' => 'social_github',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'GitHub URL',
                'description' => 'Your GitHub profile URL',
            ],
            [
                'key' => 'social_linkedin',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'Your LinkedIn profile URL',
            ],
            [
                'key' => 'social_twitter',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter/X URL',
                'description' => 'Your Twitter/X profile URL',
            ],
            [
                'key' => 'social_instagram',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Your Instagram profile URL',
            ],

            // SEO / Meta Settings
            [
                'key' => 'meta_robots',
                'value' => 'index,follow',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Meta Robots',
                'description' => 'Robots directive (e.g. index,follow or noindex,nofollow)',
            ],
            [
                'key' => 'meta_theme_color',
                'value' => '#0ea5e9',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Theme Color',
                'description' => 'Browser UI theme color',
            ],

            // Branding
            [
                'key' => 'brand_primary_color',
                'value' => '#0ea5e9',
                'type' => 'string',
                'group' => 'branding',
                'label' => 'Primary Brand Color',
                'description' => 'Used for buttons, accents and highlights (hex).',
            ],
            [
                'key' => 'brand_logo_url',
                'value' => '',
                'type' => 'string',
                'group' => 'branding',
                'label' => 'Logo URL',
                'description' => 'Optional logo image URL (leave empty to use default).',
            ],

            // Analytics
            [
                'key' => 'analytics_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'analytics',
                'label' => 'Enable Analytics',
                'description' => 'Enable adding analytics scripts to your pages.',
            ],
            [
                'key' => 'analytics_provider',
                'value' => 'none',
                'type' => 'string',
                'group' => 'analytics',
                'label' => 'Analytics Provider',
                'description' => 'e.g. none, plausible, google, umami',
            ],
            [
                'key' => 'analytics_id',
                'value' => '',
                'type' => 'string',
                'group' => 'analytics',
                'label' => 'Analytics ID',
                'description' => 'Tracking ID / site ID for your analytics provider.',
            ],

            // Email / Notifications
            [
                'key' => 'mail_from_name',
                'value' => 'Portfolio',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail From Name',
                'description' => 'Sender name used for outgoing emails.',
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'hello@example.com',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Mail From Address',
                'description' => 'Sender email used for outgoing emails.',
            ],
            [
                'key' => 'contact_notify_admin',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'email',
                'label' => 'Notify Admin on New Contact Message',
                'description' => 'Send an email/log notification when a visitor submits the contact form.',
            ],

            // Security / Rate limits
            [
                'key' => 'contact_rate_limit_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Enable Contact Rate Limit',
                'description' => 'Protect contact form from spam by limiting requests.',
            ],
            [
                'key' => 'contact_rate_limit_per_minute',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Contact Rate Limit (per minute)',
                'description' => 'Max contact submissions per minute per IP.',
            ],
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Max Login Attempts',
                'description' => 'Used by login throttling (if enabled).',
            ],

            // Upload limits
            [
                'key' => 'max_avatar_upload_kb',
                'value' => '2048',
                'type' => 'integer',
                'group' => 'uploads',
                'label' => 'Max Avatar Upload (KB)',
                'description' => 'Maximum allowed avatar upload size in kilobytes.',
            ],
            [
                'key' => 'allowed_avatar_mimes',
                'value' => 'jpg,jpeg,png,webp',
                'type' => 'string',
                'group' => 'uploads',
                'label' => 'Allowed Avatar Types',
                'description' => 'Comma-separated list of allowed avatar file extensions.',
            ],

            // Legal
            [
                'key' => 'privacy_policy_url',
                'value' => '',
                'type' => 'string',
                'group' => 'legal',
                'label' => 'Privacy Policy URL',
                'description' => 'Optional link shown in footer or legal section.',
            ],
            [
                'key' => 'terms_url',
                'value' => '',
                'type' => 'string',
                'group' => 'legal',
                'label' => 'Terms of Service URL',
                'description' => 'Optional terms page URL.',
            ],

            // UX
            [
                'key' => 'show_cookie_notice',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'ux',
                'label' => 'Show Cookie Notice',
                'description' => 'Show a cookie notice banner on first visit.',
            ],
            [
                'key' => 'default_language',
                'value' => 'nl',
                'type' => 'string',
                'group' => 'ux',
                'label' => 'Default Language',
                'description' => 'Default UI language when no user preference is set (nl/en).',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clean up any prior diagnostics artifact if it exists.
        SiteSetting::where('key', 'diagnostic_test_key')->delete();
    }
}
