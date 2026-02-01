<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        // Helper function to generate UUID
        $generateUUID = function() {
            $data = random_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        };
        
        $data = [
            [
                'id' => $generateUUID(),
                'title' => 'Computer Science & Engineering',
                'description' => 'Comprehensive program covering software development, algorithms, data structures, and computer systems. Prepare for a career in technology with hands-on projects and industry-standard tools.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Industry-relevant curriculum',
                    'Hands-on coding projects',
                    'Expert faculty with industry experience',
                    'Career placement assistance',
                    'Modern programming languages'
                ]),
                'facilities' => json_encode([
                    'State-of-the-art computer labs',
                    'High-speed internet connectivity',
                    'Latest software and development tools',
                    'Project collaboration spaces',
                    '24/7 lab access'
                ]),
                'extra_facilities' => json_encode([
                    'Free cloud computing credits',
                    'GitHub Enterprise access',
                    'Online learning resources',
                    'Tech conference passes'
                ]),
                'registration_fee' => 500000,
                'tuition_fee' => 15000000,
                'discount' => 10.00,
                'category' => 'Technology',
                'sub_category' => 'Computer Science',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Business Administration',
                'description' => 'Master the fundamentals of business management, finance, marketing, and entrepreneurship. Develop leadership skills and strategic thinking for the modern business world.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Comprehensive business curriculum',
                    'Case study methodology',
                    'Guest lectures from industry leaders',
                    'Internship opportunities',
                    'Global business perspective'
                ]),
                'facilities' => json_encode([
                    'Modern classrooms',
                    'Business simulation lab',
                    'Library with business resources',
                    'Seminar halls',
                    'Study rooms'
                ]),
                'extra_facilities' => json_encode([
                    'Bloomberg Terminal access',
                    'Business magazine subscriptions',
                    'Networking events',
                    'Career counseling'
                ]),
                'registration_fee' => 400000,
                'tuition_fee' => 12000000,
                'discount' => 15.00,
                'category' => 'Business',
                'sub_category' => 'Management',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Digital Marketing & E-Commerce',
                'description' => 'Learn cutting-edge digital marketing strategies, SEO, social media marketing, content creation, and e-commerce management. Perfect for the digital age entrepreneur.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Practical digital marketing skills',
                    'SEO and SEM training',
                    'Social media strategy',
                    'Analytics and data-driven marketing',
                    'E-commerce platform management'
                ]),
                'facilities' => json_encode([
                    'Digital marketing lab',
                    'Content creation studio',
                    'Video production equipment',
                    'Photography studio',
                    'Podcast recording booth'
                ]),
                'extra_facilities' => json_encode([
                    'Google Ads credits',
                    'Premium marketing tools access',
                    'Industry certifications',
                    'Live campaign projects'
                ]),
                'registration_fee' => 350000,
                'tuition_fee' => 10000000,
                'discount' => 20.00,
                'category' => 'Marketing',
                'sub_category' => 'Digital Marketing',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Graphic Design & Multimedia',
                'description' => 'Unleash your creativity with professional training in graphic design, video editing, animation, and multimedia production using industry-standard software.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Adobe Creative Suite mastery',
                    'Portfolio development',
                    'Design thinking methodology',
                    'Client project experience',
                    'Industry-standard workflows'
                ]),
                'facilities' => json_encode([
                    'Mac lab with latest hardware',
                    'Drawing tablets and stylus',
                    'Professional monitors',
                    'Printing and production lab',
                    'Design library'
                ]),
                'extra_facilities' => json_encode([
                    'Adobe Creative Cloud license',
                    'Stock photo subscriptions',
                    'Design competition entries',
                    'Exhibition opportunities'
                ]),
                'registration_fee' => 400000,
                'tuition_fee' => 11000000,
                'discount' => 12.00,
                'category' => 'Creative Arts',
                'sub_category' => 'Design',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Data Science & Analytics',
                'description' => 'Dive into the world of big data, machine learning, statistical analysis, and data visualization. Learn to extract insights and make data-driven decisions.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Python and R programming',
                    'Machine learning algorithms',
                    'Statistical analysis',
                    'Data visualization techniques',
                    'Real-world datasets'
                ]),
                'facilities' => json_encode([
                    'High-performance computing lab',
                    'GPU-enabled workstations',
                    'Big data infrastructure',
                    'Collaborative workspace',
                    'Research facilities'
                ]),
                'extra_facilities' => json_encode([
                    'Cloud computing resources',
                    'Kaggle competition support',
                    'Industry datasets access',
                    'Research paper guidance'
                ]),
                'registration_fee' => 550000,
                'tuition_fee' => 16000000,
                'discount' => 8.00,
                'category' => 'Technology',
                'sub_category' => 'Data Science',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Accounting & Finance',
                'description' => 'Master financial accounting, management accounting, taxation, auditing, and financial management. Prepare for professional certifications and finance careers.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Comprehensive accounting training',
                    'Financial software proficiency',
                    'Tax preparation skills',
                    'Audit procedures',
                    'Professional certification prep'
                ]),
                'facilities' => json_encode([
                    'Accounting software lab',
                    'Financial modeling stations',
                    'Case study rooms',
                    'Professional library',
                    'Mock audit environment'
                ]),
                'extra_facilities' => json_encode([
                    'Accounting software licenses',
                    'Professional journal access',
                    'CPA exam preparation',
                    'Industry workshops'
                ]),
                'registration_fee' => 450000,
                'tuition_fee' => 13000000,
                'discount' => 10.00,
                'category' => 'Business',
                'sub_category' => 'Finance',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Web Development Bootcamp',
                'description' => 'Intensive program covering front-end and back-end web development. Learn HTML, CSS, JavaScript, React, Node.js, and database management in 6 months.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Full-stack development',
                    'Modern frameworks and libraries',
                    'Responsive design',
                    'API development',
                    'Portfolio projects'
                ]),
                'facilities' => json_encode([
                    'Dedicated coding lab',
                    'Dual monitor setups',
                    'High-speed internet',
                    'Collaboration tools',
                    'Testing environments'
                ]),
                'extra_facilities' => json_encode([
                    'GitHub Pro account',
                    'Hosting credits',
                    'Premium learning platforms',
                    'Job placement support'
                ]),
                'registration_fee' => 300000,
                'tuition_fee' => 9000000,
                'discount' => 25.00,
                'category' => 'Technology',
                'sub_category' => 'Web Development',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Hospitality & Tourism Management',
                'description' => 'Comprehensive training in hotel management, tourism operations, event planning, and customer service excellence for the hospitality industry.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Hotel operations management',
                    'Tourism industry insights',
                    'Event planning skills',
                    'Customer service excellence',
                    'Industry internships'
                ]),
                'facilities' => json_encode([
                    'Mock hotel reception',
                    'Restaurant training area',
                    'Event planning studio',
                    'Culinary demonstration kitchen',
                    'Hospitality library'
                ]),
                'extra_facilities' => json_encode([
                    'Industry field trips',
                    'Hotel management software',
                    'Professional certifications',
                    'International exposure programs'
                ]),
                'registration_fee' => 400000,
                'tuition_fee' => 11500000,
                'discount' => 15.00,
                'category' => 'Hospitality',
                'sub_category' => 'Tourism',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Mobile App Development',
                'description' => 'Learn to build native and cross-platform mobile applications for iOS and Android. Master Swift, Kotlin, React Native, and Flutter frameworks.',
                'thumbnail' => null,
                'features' => json_encode([
                    'iOS and Android development',
                    'Cross-platform frameworks',
                    'UI/UX design for mobile',
                    'App store deployment',
                    'Real app projects'
                ]),
                'facilities' => json_encode([
                    'Mac and PC development stations',
                    'Mobile device testing lab',
                    'Emulator environments',
                    'Collaboration spaces',
                    'App testing devices'
                ]),
                'extra_facilities' => json_encode([
                    'Apple Developer account',
                    'Google Play Console access',
                    'Cloud backend services',
                    'App analytics tools'
                ]),
                'registration_fee' => 500000,
                'tuition_fee' => 14000000,
                'discount' => 10.00,
                'category' => 'Technology',
                'sub_category' => 'Mobile Development',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => $generateUUID(),
                'title' => 'Cybersecurity & Ethical Hacking',
                'description' => 'Comprehensive cybersecurity training covering network security, penetration testing, ethical hacking, and security operations. Prepare for industry certifications.',
                'thumbnail' => null,
                'features' => json_encode([
                    'Network security fundamentals',
                    'Penetration testing techniques',
                    'Security operations',
                    'Incident response',
                    'Certification preparation'
                ]),
                'facilities' => json_encode([
                    'Isolated security lab',
                    'Virtual hacking environment',
                    'Network simulation tools',
                    'Security monitoring systems',
                    'Forensics workstations'
                ]),
                'extra_facilities' => json_encode([
                    'Security tool licenses',
                    'CTF competition access',
                    'Bug bounty program guidance',
                    'Industry certifications'
                ]),
                'registration_fee' => 600000,
                'tuition_fee' => 17000000,
                'discount' => 5.00,
                'category' => 'Technology',
                'sub_category' => 'Security',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        // Use database builder to insert all records
        $db = \Config\Database::connect();
        $builder = $db->table('programs');
        
        $builder->insertBatch($data);
        
        echo count($data) . " program records have been seeded successfully!\n";
    }
}
