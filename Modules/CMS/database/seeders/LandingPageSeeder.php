<?php

namespace Modules\CMS\database\seeders;

use Illuminate\Database\Seeder;
use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Enums\PageTemplateEnum;
use Modules\CMS\Models\Page;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        $landingPage = Page::query()->updateOrCreate(
            ['slug' => 'home'],
            [
            'title' => [
                'en' => 'Home - Codliy Software Solutions',
                'ar' => 'الرئيسية - كودلي حلول البرمجيات',
                'tr' => 'Ana Sayfa - Codliy Yazılım Çözümleri',
            ],
            'slug' => 'home',
            'excerpt' => [
                'en' => 'Welcome to Codliy - Your trusted partner for custom software development',
                'ar' => 'مرحبا بكم في كودلي - شريكك الموثوق لتطوير البرمجيات المخصصة',
                'tr' => 'Codliy\'ye hoş geldiniz - Özel yazılım geliştirme için güvenilir ortağınız',
            ],
            'content' => [
                'en' => 'Codliy is a leading software development company specializing in custom solutions for businesses of all sizes.',
                'ar' => 'كودلي هي شركة رائدة في تطوير البرمجيات متخصصة في الحلول المخصصة للشركات من جميع الأحجام.',
                'tr' => 'Codliy, her büyüklükteki işletmeler için özel çözümlerde uzmanlaşmış önde gelen bir yazılım geliştirme şirketidir.',
            ],
            'status' => PageStatusEnum::PUBLISHED,
            'template' => PageTemplateEnum::LANDING,
            'order' => 0,
            'published_at' => now(),
            'meta_data' => [
                'hero' => [
                    'title' => [
                        'en' => 'Transform Your Business with Custom Software Solutions',
                        'ar' => 'حول عملك مع حلول البرمجيات المخصصة',
                        'tr' => 'İşletmenizi Özel Yazılım Çözümleri ile Dönüştürün',
                    ],
                    'subtitle' => [
                        'en' => 'Expert Development Team at Your Service',
                        'ar' => 'فريق تطوير خبير في خدمتك',
                        'tr' => 'Uzman Geliştirme Ekibi Hizmetinizde',
                    ],
                    'description' => [
                        'en' => 'We build scalable, secure, and innovative software solutions tailored to your business needs. From web applications to mobile apps and enterprise systems.',
                        'ar' => 'نقوم ببناء حلول برمجية قابلة للتطوير وآمنة ومبتكرة مصممة خصيصًا لاحتياجات عملك. من تطبيقات الويب إلى تطبيقات الهاتف المحمول وأنظمة المؤسسات.',
                        'tr' => 'İşletme ihtiyaçlarınıza göre ölçeklenebilir, güvenli ve yenilikçi yazılım çözümleri geliştiriyoruz. Web uygulamalarından mobil uygulamalara ve kurumsal sistemlere.',
                    ],
                    'cta_text' => [
                        'en' => 'Start Your Project',
                        'ar' => 'ابدأ مشروعك',
                        'tr' => 'Projenizi Başlatın',
                    ],
                    'cta_url' => '/contact',
                    'image' => 'assets/img/front-pages/landing-page/hero-dashboard.png',
                ],
                'features' => [
                    'badge' => [
                        'en' => 'Our Services',
                        'ar' => 'خدماتنا',
                        'tr' => 'Hizmetlerimiz',
                    ],
                    'title' => [
                        'en' => 'Comprehensive Software Development Services',
                        'ar' => 'خدمات تطوير برمجيات شاملة',
                        'tr' => 'Kapsamlı Yazılım Geliştirme Hizmetleri',
                    ],
                    'description' => [
                        'en' => 'We offer end-to-end software development services, from concept to deployment and ongoing support.',
                        'ar' => 'نقدم خدمات تطوير برمجيات شاملة من البداية إلى النهاية، من المفهوم إلى النشر والدعم المستمر.',
                        'tr' => 'Kavramdan dağıtıma ve sürekli desteğe kadar uçtan uca yazılım geliştirme hizmetleri sunuyoruz.',
                    ],
                    'items' => [
                        [
                            'icon' => 'ti tabler-code',
                            'title' => [
                                'en' => 'Custom Web Development',
                                'ar' => 'تطوير ويب مخصص',
                                'tr' => 'Özel Web Geliştirme',
                            ],
                            'description' => [
                                'en' => 'Build powerful, scalable web applications using modern technologies like Laravel, React, and Vue.js.',
                                'ar' => 'بناء تطبيقات ويب قوية وقابلة للتطوير باستخدام تقنيات حديثة مثل Laravel و React و Vue.js.',
                                'tr' => 'Laravel, React ve Vue.js gibi modern teknolojileri kullanarak güçlü, ölçeklenebilir web uygulamaları oluşturun.',
                            ],
                        ],
                        [
                            'icon' => 'ti tabler-device-mobile',
                            'title' => [
                                'en' => 'Mobile App Development',
                                'ar' => 'تطوير تطبيقات الهاتف المحمول',
                                'tr' => 'Mobil Uygulama Geliştirme',
                            ],
                            'description' => [
                                'en' => 'Native and cross-platform mobile apps for iOS and Android that deliver exceptional user experiences.',
                                'ar' => 'تطبيقات جوال أصلية ومتعددة المنصات لنظامي iOS و Android توفر تجارب مستخدم استثنائية.',
                                'tr' => 'Olağanüstü kullanıcı deneyimleri sunan iOS ve Android için yerel ve çapraz platform mobil uygulamalar.',
                            ],
                        ],
                        [
                            'icon' => 'ti tabler-api',
                            'title' => [
                                'en' => 'API Development',
                                'ar' => 'تطوير واجهة برمجة التطبيقات',
                                'tr' => 'API Geliştirme',
                            ],
                            'description' => [
                                'en' => 'RESTful and GraphQL APIs designed for performance, security, and seamless integration.',
                                'ar' => 'واجهات برمجة تطبيقات RESTful و GraphQL مصممة للأداء والأمان والتكامل السلس.',
                                'tr' => 'Performans, güvenlik ve sorunsuz entegrasyon için tasarlanmış RESTful ve GraphQL API\'leri.',
                            ],
                        ],
                        [
                            'icon' => 'ti tabler-cloud',
                            'title' => [
                                'en' => 'Cloud Solutions',
                                'ar' => 'حلول سحابية',
                                'tr' => 'Bulut Çözümleri',
                            ],
                            'description' => [
                                'en' => 'Deploy and manage your applications on AWS, Azure, or Google Cloud with our expertise.',
                                'ar' => 'نشر وإدارة تطبيقاتك على AWS أو Azure أو Google Cloud مع خبرتنا.',
                                'tr' => 'Uzmanlığımızla uygulamalarınızı AWS, Azure veya Google Cloud\'da dağıtın ve yönetin.',
                            ],
                        ],
                        [
                            'icon' => 'ti tabler-users',
                            'title' => [
                                'en' => 'UI/UX Design',
                                'ar' => 'تصميم واجهة وتجربة المستخدم',
                                'tr' => 'UI/UX Tasarımı',
                            ],
                            'description' => [
                                'en' => 'Beautiful, intuitive interfaces that engage users and drive conversions.',
                                'ar' => 'واجهات جميلة وبديهية تجذب المستخدمين وتعزز التحويلات.',
                                'tr' => 'Kullanıcıları meşgul eden ve dönüşümleri artıran güzel, sezgisel arayüzler.',
                            ],
                        ],
                        [
                            'icon' => 'ti tabler-shield-check',
                            'title' => [
                                'en' => 'Maintenance & Support',
                                'ar' => 'الصيانة والدعم',
                                'tr' => 'Bakım ve Destek',
                            ],
                            'description' => [
                                'en' => 'Ongoing maintenance, updates, and 24/7 technical support to keep your software running smoothly.',
                                'ar' => 'صيانة مستمرة وتحديثات ودعم فني على مدار الساعة للحفاظ على تشغيل برنامجك بسلاسة.',
                                'tr' => 'Yazılımınızın sorunsuz çalışmasını sağlamak için sürekli bakım, güncellemeler ve 7/24 teknik destek.',
                            ],
                        ],
                    ],
                ],
                'team' => [
                    'badge' => [
                        'en' => 'Our Expert Team',
                        'ar' => 'فريقنا الخبير',
                        'tr' => 'Uzman Ekibimiz',
                    ],
                    'title' => [
                        'en' => 'Meet the Talent Behind Codliy',
                        'ar' => 'تعرف على المواهب وراء كودلي',
                        'tr' => 'Codliy\'nin Arkasındaki Yetenekle Tanışın',
                    ],
                    'description' => [
                        'en' => 'Our experienced team of developers, designers, and project managers work together to deliver exceptional software solutions.',
                        'ar' => 'يعمل فريقنا المتمرس من المطورين والمصممين ومديري المشاريع معًا لتقديم حلول برمجية استثنائية.',
                        'tr' => 'Deneyimli geliştiriciler, tasarımcılar ve proje yöneticilerinden oluşan ekibimiz olağanüstü yazılım çözümleri sunmak için birlikte çalışıyor.',
                    ],
                    'members' => [
                        [
                            'name' => 'Sarah Johnson',
                            'position' => [
                                'en' => 'CEO & Founder',
                                'ar' => 'الرئيس التنفيذي والمؤسس',
                                'tr' => 'CEO ve Kurucu',
                            ],
                            'avatar' => 'assets/img/avatars/1.png',
                        ],
                        [
                            'name' => 'Michael Chen',
                            'position' => [
                                'en' => 'Lead Developer',
                                'ar' => 'المطور الرئيسي',
                                'tr' => 'Baş Geliştirici',
                            ],
                            'avatar' => 'assets/img/avatars/2.png',
                        ],
                        [
                            'name' => 'Emma Davis',
                            'position' => [
                                'en' => 'Senior UI/UX Designer',
                                'ar' => 'مصمم واجهة وتجربة مستخدم أول',
                                'tr' => 'Kıdemli UI/UX Tasarımcı',
                            ],
                            'avatar' => 'assets/img/avatars/3.png',
                        ],
                        [
                            'name' => 'David Martinez',
                            'position' => [
                                'en' => 'DevOps Engineer',
                                'ar' => 'مهندس DevOps',
                                'tr' => 'DevOps Mühendisi',
                            ],
                            'avatar' => 'assets/img/avatars/4.png',
                        ],
                    ],
                ],
                'contact' => [
                    'badge' => [
                        'en' => 'Contact Us',
                        'ar' => 'اتصل بنا',
                        'tr' => 'Bize Ulaşın',
                    ],
                    'title' => [
                        'en' => "Let's Build Something Amazing Together",
                        'ar' => 'لنبني شيئًا مذهلاً معًا',
                        'tr' => 'Birlikte Harika Bir Şey İnşa Edelim',
                    ],
                    'description' => [
                        'en' => 'Have a project in mind? Get in touch with us to discuss how we can help bring your ideas to life.',
                        'ar' => 'هل لديك مشروع في ذهنك؟ تواصل معنا لمناقشة كيف يمكننا مساعدتك في تحقيق أفكارك.',
                        'tr' => 'Aklınızda bir proje mi var? Fikirlerinizi hayata geçirmenize nasıl yardımcı olabileceğimizi tartışmak için bizimle iletişime geçin.',
                    ],
                    'email' => 'info@codliy.com',
                    'phone' => '+1 (555) 123-4567',
                ],
                'cta' => [
                    'title' => [
                        'en' => 'Ready to Transform Your Business?',
                        'ar' => 'هل أنت مستعد لتحويل عملك؟',
                        'tr' => 'İşletmenizi Dönüştürmeye Hazır mısınız?',
                    ],
                    'subtitle' => [
                        'en' => 'Get a free consultation and project estimate from our experts',
                        'ar' => 'احصل على استشارة مجانية وتقدير للمشروع من خبرائنا',
                        'tr' => 'Uzmanlarımızdan ücretsiz danışmanlık ve proje tahmini alın',
                    ],
                    'button_text' => [
                        'en' => 'Schedule a Consultation',
                        'ar' => 'حدد موعد استشارة',
                        'tr' => 'Bir Danışma Planlayın',
                    ],
                    'button_url' => '/contact',
                ],
                'faq' => [
                    'badge' => [
                        'en' => 'FAQ',
                        'ar' => 'الأسئلة الشائعة',
                        'tr' => 'SSS',
                    ],
                    'title' => [
                        'en' => 'Frequently asked questions',
                        'ar' => 'الأسئلة المتكررة',
                        'tr' => 'Sıkça sorulan sorular',
                    ],
                    'description' => [
                        'en' => 'Browse through these FAQs to find answers to commonly asked questions.',
                        'ar' => 'تصفح هذه الأسئلة الشائعة للعثور على إجابات للأسئلة الشائعة.',
                        'tr' => 'Sık sorulan sorulara cevaplar bulmak için bu SSS\'lere göz atın.',
                    ],
                    'items' => [
                        [
                            'question' => [
                                'en' => 'What technologies does Codliy specialize in?',
                                'ar' => 'ما هي التقنيات التي تتخصص فيها كودلي؟',
                                'tr' => 'Codliy hangi teknolojilerde uzmanlaşmıştır?',
                            ],
                            'answer' => [
                                'en' => 'We specialize in modern web technologies including Laravel, PHP, JavaScript (React, Vue.js, Node.js), Python, and mobile development with React Native and Flutter. We also have expertise in cloud platforms like AWS, Azure, and Google Cloud.',
                                'ar' => 'نحن متخصصون في تقنيات الويب الحديثة بما في ذلك Laravel و PHP و JavaScript (React و Vue.js و Node.js) و Python وتطوير الجوال باستخدام React Native و Flutter. لدينا أيضًا خبرة في منصات السحابة مثل AWS و Azure و Google Cloud.',
                                'tr' => 'Laravel, PHP, JavaScript (React, Vue.js, Node.js), Python ve React Native ve Flutter ile mobil geliştirme dahil olmak üzere modern web teknolojilerinde uzmanız. Ayrıca AWS, Azure ve Google Cloud gibi bulut platformlarında uzmanlığımız var.',
                            ],
                        ],
                        [
                            'question' => [
                                'en' => 'How long does a typical project take?',
                                'ar' => 'كم من الوقت يستغرق المشروع النموذجي؟',
                                'tr' => 'Tipik bir proje ne kadar sürer?',
                            ],
                            'answer' => [
                                'en' => 'Project timelines vary based on complexity and requirements. A simple website might take 4-6 weeks, while a complex enterprise application could take 3-6 months. We provide detailed timelines during the consultation phase.',
                                'ar' => 'تختلف جداول المشروع بناءً على التعقيد والمتطلبات. قد يستغرق موقع ويب بسيط 4-6 أسابيع، بينما قد يستغرق تطبيق مؤسسي معقد 3-6 أشهر. نقدم جداول زمنية تفصيلية خلال مرحلة الاستشارة.',
                                'tr' => 'Proje süreleri karmaşıklığa ve gereksinimlere göre değişir. Basit bir web sitesi 4-6 hafta sürebilirken, karmaşık bir kurumsal uygulama 3-6 ay sürebilir. Danışma aşamasında ayrıntılı zaman çizelgeleri sağlıyoruz.',
                            ],
                        ],
                        [
                            'question' => [
                                'en' => 'Do you provide ongoing support after project completion?',
                                'ar' => 'هل تقدمون دعمًا مستمرًا بعد انتهاء المشروع؟',
                                'tr' => 'Proje tamamlandıktan sonra sürekli destek sağlıyor musunuz?',
                            ],
                            'answer' => [
                                'en' => 'Yes, we offer comprehensive maintenance and support packages. This includes bug fixes, security updates, performance optimization, and feature enhancements. We provide both monthly retainer and hourly support options.',
                                'ar' => 'نعم، نقدم باقات صيانة ودعم شاملة. يشمل ذلك إصلاحات الأخطاء وتحديثات الأمان وتحسين الأداء وتحسينات الميزات. نقدم خيارات دعم شهرية وساعية.',
                                'tr' => 'Evet, kapsamlı bakım ve destek paketleri sunuyoruz. Bu, hata düzeltmeleri, güvenlik güncellemeleri, performans optimizasyonu ve özellik geliştirmelerini içerir. Hem aylık ön ödeme hem de saatlik destek seçenekleri sunuyoruz.',
                            ],
                        ],
                    ],
                ],
            ]
        ]);

        // Set SEO data
        $landingPage->seo()->updateOrCreate(
            ['seoable_id' => $landingPage->id, 'seoable_type' => get_class($landingPage)],
            [
                'title' => [
                    'en' => 'Codliy - Custom Software Development Company',
                    'ar' => 'كودلي - شركة تطوير برمجيات مخصصة',
                    'tr' => 'Codliy - Özel Yazılım Geliştirme Şirketi',
                ],
                'meta_description' => [
                    'en' => 'Codliy delivers custom web and mobile software solutions. Expert team specializing in Laravel, React, Vue.js, and cloud development. Transform your business with our innovative software services.',
                    'ar' => 'تقدم كودلي حلول برمجيات ويب وجوال مخصصة. فريق خبير متخصص في Laravel و React و Vue.js وتطوير السحابة. حول عملك بخدماتنا البرمجية المبتكرة.',
                    'tr' => 'Codliy özel web ve mobil yazılım çözümleri sunar. Laravel, React, Vue.js ve bulut geliştirmede uzmanlaşmış uzman ekip. Yenilikçi yazılım hizmetlerimizle işletmenizi dönüştürün.',
                ],
                'robots_index' => true,
                'robots_follow' => true,
            ]
        );
    }
}
