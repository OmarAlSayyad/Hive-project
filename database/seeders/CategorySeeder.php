<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Technical Skills' => [
                'description' => 'Skills related to specific technical knowledge and tasks.',
                'skills' => [
                    'Programming Languages',
                    'Web Development',
                    'Database Management',
                    'Cloud Computing',
                    'Software Development Tools',
                    'Operating Systems',
                    'Networking',
                    'Data Analysis',
                    'Cybersecurity',
                ],
            ],
            'Soft Skills' => [
                'description' => 'Personal attributes that enable someone to interact effectively with others.',
                'skills' => [
                    'Communication',
                    'Leadership',
                    'Teamwork',
                    'Problem-Solving',
                    'Time Management',
                    'Adaptability',
                ],
            ],
            'Industry-Specific Skills' => [
                'description' => 'Skills tailored to specific industries.',
                'skills' => [
                    'Healthcare',
                    'Finance',
                    'Legal',
                    'Marketing',
                    'Engineering',
                    'Education',
                ],
            ],
            'Certifications' => [
                'description' => 'Professional certifications and credentials.',
                'skills' => [
                    'IT and Cybersecurity',
                    'Project Management',
                    'Finance and Accounting',
                    'Healthcare',
                    'Marketing',
                ],
            ],
            'Languages' => [
                'description' => 'Languages spoken and proficiency levels.',
                'skills' => [
                    'Languages Spoken',
                    'Proficiency Levels',
                ],
            ],
            'Professional Development' => [
                'description' => 'Workshops, seminars, and online courses.',
                'skills' => [
                    'Workshops and Seminars',
                    'Online Courses',
                    'Conferences Attended',
                ],
            ],
            'Projects' => [
                'description' => 'Project-related skills and experiences.',
                'skills' => [
                    'Project Management',
                    'Technical Projects',
                    'Research Projects',
                ],
            ],
            'Volunteer Experience' => [
                'description' => 'Skills and experiences gained through volunteer work.',
                'skills' => [
                    'Community Service',
                    'Non-Profit Work',
                ],
            ],
            'Additional Information' => [
                'description' => 'Hobbies, interests, and other relevant information.',
                'skills' => [
                    'Hobbies and Interests',
                    'Publications',
                    'Awards and Honors',
                ],
            ],
            'References' => [
                'description' => 'Professional and personal references.',
                'skills' => [
                    'Professional References',
                    'Personal References',
                ],
            ],
        ];

        // Insert categories and skills into the database
        foreach ($categories as $categoryName => $data) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => $categoryName,
                'description' => $data['description'],
            ]);

            foreach ($data['skills'] as $skillName) {
                DB::table('skills')->insert([
                    'category_id' => $categoryId,
                    'name' => $skillName,
                ]);
            }
        }
     }
 }
