<?php

use App\FaqGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('qst');
            $table->longText('ans');
            $table->unsignedInteger('group_id')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $groups = ['Getting Started', 'User Guide', 'Pricing Plan'];
    
        $faqs = [
            [
              "qst" => "How do I get started with greenerbrains?",
              "ans" => "Download our mobile App at playstore and also our windows App in our website. Sign in and get started.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "Can greenerbrains help me to increase my performance as a student??? ",
              "ans" => "Greenerbrains is a platform that can help any student achieve his/her academic goals with guarantee after going through the contents that we have .",
              "group" => "Getting Started"
            ],
            [
              "qst" => "What category of students can benefit from Greenerbrains contents??",
              "ans" => "Greenerbrains can be beneficial not only to students but school children from basic 3 who can comprehend up to students in higher institutions and in post graduate schools.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "Is greenerbrains contents solely for students and school children?",
              "ans" => "No. Greenerbrains contents are for any person who wants to know and master the techniques of making his work easier and faster thereby, increasing productivity.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "Can greenerbrains contents serve people in Research Institutions??",
              "ans" => "Yes. People in Research institutions can be more productive and can achieve results faster with guarantee if they use Greenerbrains.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "Can parents and guardians benefit from greenerbrains contents?",
              "ans" => "At greenerbrains, we have a special provision for parents and guardians (G-Tab) Contents we have here can help parents bring out the best in their children in academics and beyond.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "Why should I consider donating to Greenerbrains?",
              "ans" => "Each time you donate, you are helping Greenerbrains in making more FREE contents available that would benefit students and school children in Africa and across the globe especially in this COVID-19 global pandemic.",
              "group" => "Getting Started"
            ],
            [
              "qst" => "How do I know the best content that would help me achieve what I want?",
              "ans" => "Check out and preview our contents to know the ones that benefit you the most. You can also send email to us describing what you need and we will help you out.",
              "group" => "User Guide"
            ],
            [
              "qst" => "Can a single content solve my challenges?",
              "ans" => "Yes but not always. Some may need you to combine many contents to get the challenges resolved totally.",
              "group" => "User Guide"
            ],
            [
              "qst" => "How can I share this platform to my family friends?",
              "ans" => "Simply download and use our mobile App and click on the 'Share this App' button and you can share in a matter of seconds.",
              "group" => "User Guide"
            ],
            [
              "qst" => "The App is malfunctioning what should I do?",
              "ans" => "Check your phone's configuration to know whether if it is capable of using the App. You can uninstall and download again.",
              "group" => "User Guide"
            ]
          ];

        for ($i = 0; $i < count($faqs); $i++) {
          $currentGroup = FaqGroup::where('label', $faqs[$i]['group'])->first();
          
          if (isset($currentGroup)) {
            $group_id = $currentGroup->id;

            // Add to database
            DB::table('faqs')->insert([
              'qst' => $faqs[$i]['qst'],
              'ans' => $faqs[$i]['ans'],
              'group_id' => $group_id,
              'is_published' => true
            ]);
          }
          
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
