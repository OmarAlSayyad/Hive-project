<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Skill;

class CategorySkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Software Development',
                'description' => 'Development of software applications, systems, and platforms.',
                'skills' => [
                    'Web Development',
                    'Mobile App Development',
                    'Backend Development',
                    'Frontend Development',
                    'Database Management',
                    'DevOps',
                    'Software Testing',
                ],
            ],
            [
                'name' => 'Design & Creative',
                'description' => 'Creative design in various fields, including graphic, web, and product design.',
                'skills' => [
                    'Graphic Design',
                    'UI/UX Design',
                    'Logo Design',
                    'Illustration',
                    '3D Modeling',
                    'Video Editing',
                    'Animation',
                ],
            ],
            [
                'name' => 'Marketing & Sales',
                'description' => 'Strategies and operations for marketing, sales, and customer engagement.',
                'skills' => [
                    'Digital Marketing',
                    'SEO',
                    'Content Marketing',
                    'Social Media Marketing',
                    'Sales Strategy',
                    'Email Marketing',
                    'Brand Management',
                ],
            ],
            [
                'name' => 'Writing & Translation',
                'description' => 'Content creation and translation services across various languages and formats.',
                'skills' => [
                    'Copywriting',
                    'Technical Writing',
                    'Blog Writing',
                    'Translation',
                    'Proofreading & Editing',
                    'Creative Writing',
                    'Ghostwriting',
                ],
            ],
            [
                'name' => 'Business & Consulting',
                'description' => 'Business strategy, operations, and management consulting services.',
                'skills' => [
                    'Business Strategy',
                    'Project Management',
                    'Data Analysis',
                    'Financial Analysis',
                    'Human Resources',
                    'Management Consulting',
                    'Operations Management',
                ],
            ],
            [
                'name' => 'Education & Training',
                'description' => 'Educational and training services, including tutoring and professional development.',
                'skills' => [
                    'Curriculum Development',
                    'Online Teaching',
                    'Instructional Design',
                    'Corporate Training',
                    'Tutoring',
                    'Educational Consulting',
                    'eLearning Development',
                ],
            ],
            [
                'name' => 'Engineering & Architecture',
                'description' => 'Engineering and architectural design services, including civil, mechanical, and electrical engineering.',
                'skills' => [
                    'Civil Engineering',
                    'Mechanical Engineering',
                    'Electrical Engineering',
                    'Architectural Design',
                    'CAD',
                    'Structural Engineering',
                    'Product Design',
                ],
            ],
            [
                'name' => 'Customer Support',
                'description' => 'Services related to customer support and technical assistance.',
                'skills' => [
                    'Technical Support',
                    'Customer Service',
                    'Help Desk',
                    'Customer Relationship Management (CRM)',
                    'Call Center Management',
                    'Email Support',
                    'Live Chat Support',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
            ]);

            foreach ($categoryData['skills'] as $skill) {
                Skill::create([
                    'category_id' => $category->id,
                    'name' => $skill,
                ]);
            }
        }
    }
}
