<?php

namespace Database\Seeders;

use App\Models\Audience;
use App\Models\Course;
use App\Models\Description;
use App\Models\Goal;
use App\Models\Image;
use App\Models\Lesson;
use App\Models\Requirement;
use App\Models\Section;
use Illuminate\Database\Seeder;
// use App\Models\Course;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $courses = Course::factory(100)->create();
        // Download the images and put images in the table images
      foreach($courses as $course){
            Image::factory(1)->create([
                'imageable_id' => $course->id,
                'imageable_type' => 'App\Models\Course'
            ]);


            Requirement::factory(4)->create([
              'course_id' => $course->id
            ]);

            Goal::factory(4)->create([
              'course_id' => $course->id
            ]);

            Audience::factory(4)->create([
              'course_id' => $course->id
            ]);

            $sections = Section::factory(4)->create([ // recuperamos coleecion en este objeto
              'course_id' => $course->id
            ]);

            foreach($sections as $section){
               $lessons = Lesson::factory(4)->create(['section_id' => $section->id]);


               foreach($lessons as $lesson){
                  Description::factory(1)->create(['lesson_id' => $lesson->id]);
               }
            }
      }
    }
}