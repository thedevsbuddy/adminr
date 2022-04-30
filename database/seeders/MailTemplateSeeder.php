<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailTemplate::create([
            "subject" => "Welcome to AdminR.",
            "purpose" => "To be sent when user registers.",
            "code" => "registration-welcome-mail",
            "content" => "## Welcome to AdminR

You are successfully registered with us please verify your email
to continue using our platform.

Username: {username} {br}
Registered Email: **{email}** {br}
Verification Link: [Verify now]({verify_link}) {br}

Or

You can click below link to verify your account.
<{verify_link}>",
        ]);
    }
}
