<?php

namespace Modules\MCP\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\MCP\Models\BusinessKnowledge;

class BusinessKnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $knowledgeData = [
            // General Information
            [
                'category' => 'general',
                'subcategory' => 'about',
                'question' => [
                    'en' => 'What is this medical system?',
                    'ar' => 'ما هو هذا النظام الطبي؟',
                ],
                'answer' => [
                    'en' => 'This is a comprehensive medical management system that connects patients with doctors, manages appointments, and provides healthcare services.',
                    'ar' => 'هذا نظام إدارة طبي شامل يربط المرضى بالأطباء، ويدير المواعيد، ويقدم خدمات الرعاية الصحية.',
                ],
                'keywords' => ['system', 'about', 'introduction'],
                'tags' => ['general', 'info'],
                'priority' => 100,
                'is_active' => true,
            ],
            [
                'category' => 'general',
                'subcategory' => 'hours',
                'question' => [
                    'en' => 'What are your working hours?',
                    'ar' => 'ما هي ساعات العمل؟',
                ],
                'answer' => [
                    'en' => 'Our clinics operate from 8:00 AM to 8:00 PM, seven days a week. Emergency services are available 24/7.',
                    'ar' => 'تعمل عياداتنا من الساعة 8:00 صباحًا حتى 8:00 مساءً، سبعة أيام في الأسبوع. خدمات الطوارئ متاحة على مدار الساعة.',
                ],
                'keywords' => ['hours', 'working', 'time', 'schedule'],
                'tags' => ['general', 'hours'],
                'priority' => 90,
                'is_active' => true,
            ],

            // Appointments
            [
                'category' => 'appointments',
                'subcategory' => 'booking',
                'question' => [
                    'en' => 'How do I book an appointment?',
                    'ar' => 'كيف أحجز موعداً؟',
                ],
                'answer' => [
                    'en' => 'You can book an appointment through our website, mobile app, or by calling our hotline. Simply select your preferred doctor, date, and time slot.',
                    'ar' => 'يمكنك حجز موعد من خلال موقعنا الإلكتروني أو تطبيق الهاتف المحمول أو عن طريق الاتصال بخط المساعدة. ما عليك سوى اختيار الطبيب المفضل والتاريخ والوقت.',
                ],
                'keywords' => ['appointment', 'booking', 'schedule', 'reserve'],
                'tags' => ['appointments', 'booking'],
                'priority' => 95,
                'is_active' => true,
            ],
            [
                'category' => 'appointments',
                'subcategory' => 'cancellation',
                'question' => [
                    'en' => 'Can I cancel or reschedule my appointment?',
                    'ar' => 'هل يمكنني إلغاء أو إعادة جدولة موعدي؟',
                ],
                'answer' => [
                    'en' => 'Yes, you can cancel or reschedule your appointment up to 24 hours before the scheduled time through your account or by contacting us.',
                    'ar' => 'نعم، يمكنك إلغاء أو إعادة جدولة موعدك قبل 24 ساعة من الوقت المحدد من خلال حسابك أو عن طريق الاتصال بنا.',
                ],
                'keywords' => ['cancel', 'reschedule', 'change', 'appointment'],
                'tags' => ['appointments', 'cancellation'],
                'priority' => 85,
                'is_active' => true,
            ],

            // Doctors
            [
                'category' => 'doctors',
                'subcategory' => 'specialties',
                'question' => [
                    'en' => 'What medical specialties do you offer?',
                    'ar' => 'ما هي التخصصات الطبية المتوفرة؟',
                ],
                'answer' => [
                    'en' => 'We offer a wide range of specialties including General Medicine, Cardiology, Pediatrics, Dermatology, Orthopedics, and many more.',
                    'ar' => 'نقدم مجموعة واسعة من التخصصات بما في ذلك الطب العام، أمراض القلب، طب الأطفال، الأمراض الجلدية، جراحة العظام، وغيرها الكثير.',
                ],
                'keywords' => ['specialties', 'doctors', 'medical', 'fields'],
                'tags' => ['doctors', 'specialties'],
                'priority' => 80,
                'is_active' => true,
            ],
            [
                'category' => 'doctors',
                'subcategory' => 'qualifications',
                'question' => [
                    'en' => 'Are your doctors certified and experienced?',
                    'ar' => 'هل أطباؤكم معتمدون وذوو خبرة؟',
                ],
                'answer' => [
                    'en' => 'Yes, all our doctors are board-certified, highly qualified, and have extensive experience in their respective fields.',
                    'ar' => 'نعم، جميع أطبائنا معتمدون من البورد، ومؤهلون تأهيلاً عالياً، ولديهم خبرة واسعة في مجالاتهم.',
                ],
                'keywords' => ['certified', 'qualified', 'experience', 'doctors'],
                'tags' => ['doctors', 'qualifications'],
                'priority' => 75,
                'is_active' => true,
            ],

            // Payments
            [
                'category' => 'payments',
                'subcategory' => 'methods',
                'question' => [
                    'en' => 'What payment methods do you accept?',
                    'ar' => 'ما هي طرق الدفع المقبولة؟',
                ],
                'answer' => [
                    'en' => 'We accept cash, credit/debit cards, mobile payments, and insurance coverage. Online payments can be made through our secure payment gateway.',
                    'ar' => 'نقبل الدفع نقداً، بطاقات الائتمان/الخصم، الدفع عبر الهاتف المحمول، والتأمين. يمكن إجراء الدفع عبر الإنترنت من خلال بوابة الدفع الآمنة.',
                ],
                'keywords' => ['payment', 'methods', 'cash', 'card', 'insurance'],
                'tags' => ['payments', 'billing'],
                'priority' => 70,
                'is_active' => true,
            ],

            // Insurance
            [
                'category' => 'insurance',
                'subcategory' => 'coverage',
                'question' => [
                    'en' => 'Do you accept insurance?',
                    'ar' => 'هل تقبلون التأمين الصحي؟',
                ],
                'answer' => [
                    'en' => 'Yes, we work with most major insurance providers. Please contact us or check your insurance details to confirm coverage.',
                    'ar' => 'نعم، نتعامل مع معظم مقدمي التأمين الرئيسيين. يرجى الاتصال بنا أو التحقق من تفاصيل تأمينك لتأكيد التغطية.',
                ],
                'keywords' => ['insurance', 'coverage', 'providers', 'accept'],
                'tags' => ['insurance', 'payments'],
                'priority' => 80,
                'is_active' => true,
            ],

            // Emergency
            [
                'category' => 'emergency',
                'subcategory' => 'services',
                'question' => [
                    'en' => 'Do you provide emergency services?',
                    'ar' => 'هل تقدمون خدمات الطوارئ؟',
                ],
                'answer' => [
                    'en' => 'Yes, we have a 24/7 emergency department staffed with experienced medical professionals ready to handle all types of medical emergencies.',
                    'ar' => 'نعم، لدينا قسم طوارئ يعمل على مدار الساعة مع متخصصين طبيين ذوي خبرة جاهزين للتعامل مع جميع أنواع حالات الطوارئ الطبية.',
                ],
                'keywords' => ['emergency', '24/7', 'urgent', 'critical'],
                'tags' => ['emergency', 'services'],
                'priority' => 100,
                'is_active' => true,
            ],

            // Contact
            [
                'category' => 'contact',
                'subcategory' => 'support',
                'question' => [
                    'en' => 'How can I contact customer support?',
                    'ar' => 'كيف يمكنني الاتصال بخدمة العملاء؟',
                ],
                'answer' => [
                    'en' => 'You can reach our customer support team via phone, email, or through the chat widget on our website. We are available to assist you Monday through Friday, 9 AM to 6 PM.',
                    'ar' => 'يمكنك التواصل مع فريق خدمة العملاء عبر الهاتف أو البريد الإلكتروني أو من خلال أداة الدردشة على موقعنا. نحن متاحون لمساعدتك من الاثنين إلى الجمعة، من 9 صباحاً حتى 6 مساءً.',
                ],
                'keywords' => ['contact', 'support', 'help', 'customer service'],
                'tags' => ['contact', 'support'],
                'priority' => 65,
                'is_active' => true,
            ],
        ];

        foreach ($knowledgeData as $data) {
            BusinessKnowledge::create($data);
        }
    }
}
