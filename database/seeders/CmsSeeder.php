<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $cmsPages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'tag_line' => 'Learn more about the information we collect and the steps we take to protect your privacy',
                'content' => 'This is the privacy policy page',
                'meta_title' => 'Privacy Policy | Your Website Name',
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'tag_line' => 'Learn more about the information we collect and the steps we take to protect your privacy',
                'content' => 'This is the terms and conditions page',
                'meta_title' => 'Terms & Conditions | Your Website Name',
                'meta_description' => 'Review our terms and conditions to understand the rules and guidelines for using our website and services.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'tag_line' => 'Learn more about the information we collect and the steps we take to protect your privacy',
                'content' => 'This is the about us page',
                'meta_title' => 'About Us | Your Website Name',
                'meta_description' => 'Learn more about our company, mission, values, and the team behind our services.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'How it Works',
                'slug' => 'how-it-works',
                'tag_line' => 'Learn more about the information we collect and the steps we take to protect your privacy',
                'content' => 'how it works',
                'meta_title' => 'How It Works | Your Website Name',
                'meta_description' => 'Discover how our service works and learn how to get started with our platform.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'tag_line' => 'Learn more about the information we collect and the steps we take to protect your privacy',
                'content' => 'This is the Faq page',
                'meta_title' => 'Frequently Asked Questions | Your Website Name',
                'meta_description' => 'Find answers to common questions about our services, features, and policies.',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('cms_pages')->insert($cmsPages);
    }
}
