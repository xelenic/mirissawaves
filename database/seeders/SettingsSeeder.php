<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Mirissawaves',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'sort_order' => 1
            ],
            [
                'key' => 'site_description',
                'value' => 'Experience the beauty of Sri Lanka with our premium tour packages',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Brief description of your website',
                'sort_order' => 2
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Upload your website logo',
                'sort_order' => 3
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode for the website',
                'sort_order' => 4
            ],

            // Contact Settings
            [
                'key' => 'contact_email',
                'value' => 'info@mirissawaves.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'Primary contact email address',
                'sort_order' => 1
            ],
            [
                'key' => 'contact_phone',
                'value' => '+94 77 552 3939',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Phone',
                'description' => 'Primary contact phone number',
                'sort_order' => 2
            ],
            [
                'key' => 'contact_address',
                'value' => 'Mirissa, Southern Province, Sri Lanka',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Contact Address',
                'description' => 'Physical address of your business',
                'sort_order' => 3
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Your Facebook page URL',
                'sort_order' => 1
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Your Instagram profile URL',
                'sort_order' => 2
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Your Twitter profile URL',
                'sort_order' => 3
            ],
            [
                'key' => 'tripadvisor_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'TripAdvisor URL',
                'description' => 'Your TripAdvisor business page URL',
                'sort_order' => 4
            ],

            // SEO Settings
            [
                'key' => 'meta_title',
                'value' => 'Mirissawaves - Premium Sri Lanka Tour Packages',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Meta Title',
                'description' => 'Default meta title for SEO',
                'sort_order' => 1
            ],
            [
                'key' => 'meta_description',
                'value' => 'Discover Sri Lanka with Mirissawaves. Premium tour packages including whale watching, safari tours, and cultural experiences.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Meta Description',
                'description' => 'Default meta description for SEO',
                'sort_order' => 2
            ],
            [
                'key' => 'google_analytics',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Google Analytics ID',
                'description' => 'Google Analytics tracking ID',
                'sort_order' => 3
            ],

            // Email Settings
            [
                'key' => 'smtp_host',
                'value' => '',
                'type' => 'text',
                'group' => 'email',
                'label' => 'SMTP Host',
                'description' => 'SMTP server hostname',
                'sort_order' => 1
            ],
            [
                'key' => 'smtp_port',
                'value' => '587',
                'type' => 'number',
                'group' => 'email',
                'label' => 'SMTP Port',
                'description' => 'SMTP server port',
                'sort_order' => 2
            ],
            [
                'key' => 'smtp_username',
                'value' => '',
                'type' => 'text',
                'group' => 'email',
                'label' => 'SMTP Username',
                'description' => 'SMTP authentication username',
                'sort_order' => 3
            ],
            [
                'key' => 'smtp_password',
                'value' => '',
                'type' => 'text',
                'group' => 'email',
                'label' => 'SMTP Password',
                'description' => 'SMTP authentication password',
                'sort_order' => 4
            ],

            // Payment Settings
            [
                'key' => 'currency',
                'value' => 'USD',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Currency',
                'description' => 'Default currency for payments',
                'sort_order' => 1
            ],
            [
                'key' => 'payhere_merchant_id',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'PayHere Merchant ID',
                'description' => 'PayHere payment gateway merchant ID',
                'sort_order' => 2
            ],
            [
                'key' => 'payhere_merchant_secret',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'PayHere Merchant Secret',
                'description' => 'PayHere payment gateway merchant secret',
                'sort_order' => 3
            ],
            [
                'key' => 'promo_popup_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Startup promo popup',
                'description' => 'Show promotional image popup when visitors load the site',
                'sort_order' => 50
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
