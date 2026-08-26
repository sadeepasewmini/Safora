<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicFeedback;

class PublicFeedbackSeeder extends Seeder
{
    public function run(): void
    {
        PublicFeedback::truncate();

        PublicFeedback::create([
            'author_name' => 'Anusha Perera',
            'rating' => 5,
            'category' => '🌙 Night Safety Heatmap',
            'comment' => "Safora's Night Heatmap helped me find well-lit safe streets when returning home from work late at night near Peradeniya. Truly empowering for women commuters!",
        ]);

        PublicFeedback::create([
            'author_name' => 'Sanduni Silva',
            'rating' => 5,
            'category' => '🚨 Emergency SOS',
            'comment' => "The Emergency SOS button with instant WhatsApp live location dispatch gives me and my family immense peace of mind whenever I travel late.",
        ]);

        PublicFeedback::create([
            'author_name' => 'Kavindi Wickramasinghe',
            'rating' => 5,
            'category' => '🤖 Safora AI Companion',
            'comment' => "The AI Chatbot provided instant guidance regarding wildlife encountering near Habarana highway and gave direct ambulance numbers.",
        ]);

        PublicFeedback::create([
            'author_name' => 'Dilani Fernando',
            'rating' => 5,
            'category' => '🌟 Overall Experience',
            'comment' => "Community hazard report voting system is brilliant! Verified community alerts keep our local roads and public spots safe together.",
        ]);
    }
}
