<?php

namespace Modules\CMS\Database\Seeders;

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
                    'en' => 'Codliy — Senior software studio for product teams',
                    'ar' => 'كودلي — استوديو برمجيات متمرس لفرق المنتجات',
                    'tr' => 'Codliy — Ürün ekipleri için kıdemli yazılım stüdyosu',
                ],
                'slug' => 'home',
                'excerpt' => [
                    'en' => 'Codliy is a small, senior team of engineers and designers building durable software with founders and product leaders.',
                    'ar' => 'كودلي فريق صغير من المهندسين والمصممين يبني برمجيات موثوقة مع المؤسسين وقادة المنتج.',
                    'tr' => 'Codliy; kurucular ve ürün liderleriyle birlikte dayanıklı yazılım kuran, küçük ve kıdemli bir mühendis ve tasarımcı ekibidir.',
                ],
                'content' => [
                    'en' => 'We design, build and operate production systems — web, mobile, cloud, AI — that ship on time and hold up in production.',
                    'ar' => 'نصمم وننشئ ونشغل أنظمة إنتاج — ويب، جوال، سحابة، ذكاء اصطناعي — تُطلق في وقتها وتصمد في الإنتاج.',
                    'tr' => 'Üretim sistemlerini — web, mobil, bulut, yapay zekâ — zamanında devreye alıp üretimde ayakta tutan bir ekibiz.',
                ],
                'status' => PageStatusEnum::PUBLISHED,
                'template' => PageTemplateEnum::LANDING,
                'order' => 0,
                'published_at' => now(),
                'meta_data' => [
                    // ───────────────────────────────────────────────
                    // HERO
                    // ───────────────────────────────────────────────
                    'hero' => [
                        'badge' => [
                            'en' => 'SENIOR SOFTWARE STUDIO',
                            'ar' => 'استوديو برمجيات متمرس',
                            'tr' => 'KIDEMLİ YAZILIM STÜDYOSU',
                        ],
                        'title' => [
                            'en' => 'Software that holds up in production.',
                            'ar' => 'برمجيات تصمد في بيئة الإنتاج.',
                            'tr' => 'Üretimde ayakta kalan yazılımlar.',
                        ],
                        'subtitle' => [
                            'en' => 'Engineered by a senior team',
                            'ar' => 'يبنيها فريق من كبار المهندسين',
                            'tr' => 'Kıdemli bir ekip tarafından inşa edilir',
                        ],
                        'description' => [
                            'en' => 'We partner with founders and product teams to design, ship and operate web, mobile, cloud and AI systems — with tests, observability and clean handover as defaults.',
                            'ar' => 'نعمل مع المؤسسين وفرق المنتج لتصميم وإطلاق وتشغيل أنظمة ويب وجوال وسحابة وذكاء اصطناعي — مع اختبارات ومراقبة وتسليم نظيف كإعدادات افتراضية.',
                            'tr' => 'Kuruculara ve ürün ekiplerine web, mobil, bulut ve yapay zekâ sistemleri tasarlayıp teslim eder ve işletiriz — testler, gözlemlenebilirlik ve temiz devir varsayılan olarak dahildir.',
                        ],
                        'cta_text' => [
                            'en' => 'Start a Project',
                            'ar' => 'ابدأ مشروعاً',
                            'tr' => 'Bir Proje Başlat',
                        ],
                        'cta_url' => '#contactUs',
                        'secondary_cta_text' => [
                            'en' => 'See what we do',
                            'ar' => 'اطلع على ما نقوم به',
                            'tr' => 'Neler yaptığımızı gör',
                        ],
                        'secondary_cta_url' => '#landingFeatures',
                        'image' => 'codliy/images/hero.png',
                    ],

                    // ───────────────────────────────────────────────
                    // FEATURES / SERVICES
                    // ───────────────────────────────────────────────
                    'features' => [
                        'badge' => [
                            'en' => 'WHAT WE DO',
                            'ar' => 'ما نقوم به',
                            'tr' => 'NE YAPIYORUZ',
                        ],
                        'title' => [
                            'en' => 'A small studio that covers the whole stack',
                            'ar' => 'استوديو صغير يغطي المنصة بالكامل',
                            'tr' => 'Tüm yığını kapsayan küçük bir stüdyo',
                        ],
                        'description' => [
                            'en' => 'Five practices, one team. We design the system, write the code, run the infrastructure, and stay accountable for outcomes.',
                            'ar' => 'خمس ممارسات، فريق واحد. نصمم النظام، ونكتب الشيفرة، ونشغّل البنية التحتية، ونبقى مسؤولين عن النتائج.',
                            'tr' => 'Beş pratik, tek ekip. Sistemi tasarlar, kodu yazar, altyapıyı işletir ve sonuçlardan sorumlu kalırız.',
                        ],
                        'items' => [
                            [
                                'icon' => 'ti tabler-code',
                                'image' => 'codliy/images/services/web.png',
                                'title' => [
                                    'en' => 'Web platforms',
                                    'ar' => 'منصات الويب',
                                    'tr' => 'Web platformları',
                                ],
                                'description' => [
                                    'en' => 'Laravel, Vue and Next.js products built with boring stability — auth, billing, multi-tenant, admin, API, tests, CI/CD.',
                                    'ar' => 'منتجات بـ Laravel و Vue و Next.js مبنية باستقرار هادئ — مصادقة، فوترة، متعدد المستأجرين، لوحة إدارة، واجهة برمجة، اختبارات، CI/CD.',
                                    'tr' => 'Laravel, Vue ve Next.js ürünleri, sıkıcı bir istikrarla inşa edilir — kimlik doğrulama, faturalandırma, çok kiracılı, yönetim paneli, API, testler, CI/CD.',
                                ],
                            ],
                            [
                                'icon' => 'ti tabler-device-mobile',
                                'image' => 'codliy/images/services/mobile.png',
                                'title' => [
                                    'en' => 'Mobile apps',
                                    'ar' => 'تطبيقات الجوال',
                                    'tr' => 'Mobil uygulamalar',
                                ],
                                'description' => [
                                    'en' => 'React Native and Flutter apps with native feel, offline-first data, push notifications and store-ready release pipelines.',
                                    'ar' => 'تطبيقات بـ React Native و Flutter بإحساس أصلي، وبيانات بدون اتصال، وإشعارات، وخطوط إصدار جاهزة للمتاجر.',
                                    'tr' => 'Yerli hissi, çevrimdışı öncelikli veri, anlık bildirimler ve mağazaya hazır yayın hatlarıyla React Native ve Flutter uygulamaları.',
                                ],
                            ],
                            [
                                'icon' => 'ti tabler-cloud',
                                'image' => 'codliy/images/services/cloud.png',
                                'title' => [
                                    'en' => 'Cloud & DevOps',
                                    'ar' => 'السحابة والـ DevOps',
                                    'tr' => 'Bulut ve DevOps',
                                ],
                                'description' => [
                                    'en' => 'AWS-first infrastructure as code, zero-downtime deploys, logs, metrics, alerts and runbooks your on-call will thank you for.',
                                    'ar' => 'بنية تحتية على AWS ككود، ونشر دون توقف، وسجلات ومقاييس وتنبيهات ودلائل تشغيل يشكرك عليها فريق المناوبة.',
                                    'tr' => 'AWS öncelikli kod olarak altyapı, sıfır kesintili dağıtımlar, loglar, metrikler, alarmlar ve nöbet ekibinin size teşekkür edeceği runbook’lar.',
                                ],
                            ],
                            [
                                'icon' => 'ti tabler-brain',
                                'image' => 'codliy/images/services/ai.png',
                                'title' => [
                                    'en' => 'AI & RAG systems',
                                    'ar' => 'الذكاء الاصطناعي وأنظمة RAG',
                                    'tr' => 'Yapay zekâ ve RAG sistemleri',
                                ],
                                'description' => [
                                    'en' => 'LLM-powered features built on top of your data — retrieval pipelines, evaluation, guardrails, cost and latency budgets included.',
                                    'ar' => 'ميزات مدعومة بالـ LLM فوق بياناتك — خطوط استرجاع، وتقييم، وحواجز أمان، وميزانيات تكلفة وكمون.',
                                    'tr' => 'Verileriniz üzerine inşa edilen LLM destekli özellikler — geri getirme hatları, değerlendirme, kılavuzlar, maliyet ve gecikme bütçeleri dahil.',
                                ],
                            ],
                            [
                                'icon' => 'ti tabler-palette',
                                'image' => 'codliy/images/services/uiux.png',
                                'title' => [
                                    'en' => 'Product design',
                                    'ar' => 'تصميم المنتج',
                                    'tr' => 'Ürün tasarımı',
                                ],
                                'description' => [
                                    'en' => 'Design systems, UX flows and high-fidelity interfaces done by product designers who also ship code and understand constraints.',
                                    'ar' => 'أنظمة تصميم، وتدفقات تجربة المستخدم، وواجهات عالية الدقة ينفذها مصممو منتج يكتبون الشيفرة ويفهمون القيود.',
                                    'tr' => 'Kod da yazan ve kısıtları anlayan ürün tasarımcıları tarafından yapılan tasarım sistemleri, UX akışları ve yüksek çözünürlüklü arayüzler.',
                                ],
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // STATS (landingFunFacts)
                    // ───────────────────────────────────────────────
                    'stats' => [
                        'items' => [
                            [
                                'value' => '12+',
                                'icon' => 'ti tabler-code',
                                'label' => [
                                    'en' => 'Production releases per week',
                                    'ar' => 'إصدار إنتاج في الأسبوع',
                                    'tr' => 'Haftalık üretim sürümü',
                                ],
                            ],
                            [
                                'value' => '40+',
                                'icon' => 'ti tabler-rocket',
                                'label' => [
                                    'en' => 'Products shipped end-to-end',
                                    'ar' => 'منتج تم إطلاقه من البداية للنهاية',
                                    'tr' => 'Uçtan uca teslim edilmiş ürün',
                                ],
                            ],
                            [
                                'value' => '99.95%',
                                'icon' => 'ti tabler-heartbeat',
                                'label' => [
                                    'en' => 'Average uptime we operate',
                                    'ar' => 'متوسط وقت التشغيل الذي نديره',
                                    'tr' => 'İşlettiğimiz ortalama çalışma süresi',
                                ],
                            ],
                            [
                                'value' => '0',
                                'icon' => 'ti tabler-shield-lock',
                                'label' => [
                                    'en' => 'Reportable security incidents',
                                    'ar' => 'حوادث أمنية تستوجب التبليغ',
                                    'tr' => 'Bildirilebilir güvenlik olayı',
                                ],
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // HOW WE WORK (landingTeam fallback – 4 steps)
                    // ───────────────────────────────────────────────
                    'howItWorksSection' => [
                        'badge' => [
                            'en' => 'HOW WE WORK',
                            'ar' => 'كيف نعمل',
                            'tr' => 'NASIL ÇALIŞIYORUZ',
                        ],
                        'title' => [
                            'en' => 'From first call to launch — and beyond',
                            'ar' => 'من أول اتصال إلى الإطلاق — وما بعده',
                            'tr' => 'İlk görüşmeden lansmana — ve sonrasına',
                        ],
                        'description' => [
                            'en' => 'Short engagements are a lie. Real software is a continuous act. Here is how we keep it sane.',
                            'ar' => 'المشاريع القصيرة وهمٌ مريح. البرمجيات الجادة عملٌ مستمر. هكذا نبقيها معقولة.',
                            'tr' => 'Kısa projeler bir yalandır. Gerçek yazılım sürekli bir eylemdir. İşte bunu sağduyulu tutma şeklimiz.',
                        ],
                        'steps' => [
                            [
                                'title' => [
                                    'en' => 'Discovery',
                                    'ar' => 'الاستكشاف',
                                    'tr' => 'Keşif',
                                ],
                                'description' => [
                                    'en' => 'We sit with you, read the real code, look at the real data, and write down the actual problem — not the one in the brief.',
                                    'ar' => 'نجلس معك، نقرأ الشيفرة الحقيقية، ونطلع على البيانات الحقيقية، ثم نكتب المشكلة الفعلية — لا تلك الموجودة في الموجز.',
                                    'tr' => 'Sizinle otururuz, gerçek kodu okuruz, gerçek veriye bakarız ve asıl sorunu yazarız — brifte yazılanı değil.',
                                ],
                            ],
                            [
                                'title' => [
                                    'en' => 'Scope & shape',
                                    'ar' => 'النطاق والشكل',
                                    'tr' => 'Kapsam ve biçim',
                                ],
                                'description' => [
                                    'en' => 'We shape the work into small, demonstrable slices. Clear scope, realistic estimates, no surprises in month three.',
                                    'ar' => 'نحوّل العمل إلى شرائح صغيرة قابلة للعرض. نطاق واضح، وتقديرات واقعية، ولا مفاجآت في الشهر الثالث.',
                                    'tr' => 'İşi küçük, gösterilebilir dilimlere ayırırız. Net kapsam, gerçekçi tahminler, üçüncü ayda sürpriz yok.',
                                ],
                            ],
                            [
                                'title' => [
                                    'en' => 'Build & demo',
                                    'ar' => 'البناء والعرض',
                                    'tr' => 'İnşa ve demo',
                                ],
                                'description' => [
                                    'en' => 'Weekly demos with real software, real data, and real users — not slides. Tests, CI/CD and observability are part of the build, not an extra.',
                                    'ar' => 'عروض أسبوعية ببرمجيات حقيقية وبيانات ومستخدمين حقيقيين — لا شرائح عرض. الاختبارات وCI/CD والمراقبة جزء من البناء لا إضافة.',
                                    'tr' => 'Gerçek yazılım, gerçek veri ve gerçek kullanıcıyla haftalık demolar — slayt değil. Testler, CI/CD ve gözlemlenebilirlik inşanın parçasıdır, ekstra değil.',
                                ],
                            ],
                            [
                                'title' => [
                                    'en' => 'Launch & operate',
                                    'ar' => 'الإطلاق والتشغيل',
                                    'tr' => 'Lansman ve işletim',
                                ],
                                'description' => [
                                    'en' => 'We go live, we stay on-call, and we hand over with runbooks, dashboards and recorded walk-throughs. Your team owns it after — not before.',
                                    'ar' => 'نُطلق، نبقى على الجاهزية، ونسلم بدليل تشغيل ولوحات متابعة وتسجيلات شرح. يمتلكه فريقك بعد ذلك — لا قبله.',
                                    'tr' => 'Yayına alırız, nöbette kalırız ve runbook’lar, panolar ve kayıtlı anlatımlarla devrederiz. Ekibiniz sonra sahiplenir — önce değil.',
                                ],
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // TEAM (who builds it)
                    // ───────────────────────────────────────────────
                    'team' => [
                        'badge' => [
                            'en' => 'THE PEOPLE',
                            'ar' => 'الأشخاص',
                            'tr' => 'EKİP',
                        ],
                        'title' => [
                            'en' => 'Senior by default',
                            'ar' => 'خبرة عالية بالتأكيد',
                            'tr' => 'Varsayılan olarak kıdemli',
                        ],
                        'description' => [
                            'en' => 'You meet the engineers doing the work. No account managers in the way, no juniors hidden in the org chart.',
                            'ar' => 'تلتقي بالمهندسين الذين يؤدون العمل فعلاً. لا مدراء حسابات يعترضون، ولا مبتدئين مخفيين في الهيكل التنظيمي.',
                            'tr' => 'İşi yapan mühendislerle siz tanışırsınız. Araya giren hesap yöneticisi yok, organigramda saklanan junior yok.',
                        ],
                        'members' => [
                            [
                                'name' => 'Mira Aydın',
                                'position' => [
                                    'en' => 'Founding Engineer',
                                    'ar' => 'مهندسة مؤسسة',
                                    'tr' => 'Kurucu Mühendis',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-1.png',
                            ],
                            [
                                'name' => 'Samir Haddad',
                                'position' => [
                                    'en' => 'Principal Engineer',
                                    'ar' => 'مهندس رئيسي',
                                    'tr' => 'Baş Mühendis',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-2.png',
                            ],
                            [
                                'name' => 'Leïla Ouali',
                                'position' => [
                                    'en' => 'Product Designer',
                                    'ar' => 'مصممة منتج',
                                    'tr' => 'Ürün Tasarımcısı',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-3.png',
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // REVIEWS (landingReviews)
                    // ───────────────────────────────────────────────
                    'reviews' => [
                        'badge' => [
                            'en' => 'TESTIMONIALS',
                            'ar' => 'شهادات',
                            'tr' => 'REFERANSLAR',
                        ],
                        'title' => [
                            'en' => 'What teams say after shipping with us',
                            'ar' => 'ما تقوله الفرق بعد الإطلاق معنا',
                            'tr' => 'Birlikte yayına aldıktan sonra ekipler ne söylüyor',
                        ],
                        'description' => [
                            'en' => 'Feedback from founders and product leaders after shipping real software together.',
                            'ar' => 'ملاحظات من مؤسسين وقادة منتج بعد إطلاق برمجيات حقيقية معاً.',
                            'tr' => 'Birlikte gerçek yazılım yayına aldıktan sonra kuruculardan ve ürün liderlerinden geri bildirim.',
                        ],
                        'items' => [
                            [
                                'quote' => [
                                    'en' => 'They moved faster than our internal team — and what they handed over was more maintainable than anything we had before. Tests, CI, runbooks, the works.',
                                    'ar' => 'تحركوا أسرع من فريقنا الداخلي — وما سلموه كان أسهل في الصيانة من أي شيء عملنا معه سابقاً. اختبارات، CI، دلائل تشغيل، كل شيء.',
                                    'tr' => 'Kendi ekibimizden daha hızlı ilerlediler — ve devrettikleri şey daha önce sahip olduğumuz her şeyden daha sürdürülebilirdi. Testler, CI, runbook’lar, hepsi.',
                                ],
                                'name' => 'Mira Aydın',
                                'role' => [
                                    'en' => 'CTO, Orbit Labs',
                                    'ar' => 'المدير التقني، Orbit Labs',
                                    'tr' => 'CTO, Orbit Labs',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-1.png',
                                'rating' => 5,
                            ],
                            [
                                'quote' => [
                                    'en' => 'Weekly demos with real working software. No slideware, no excuses. Exactly the engineering culture we needed around our product.',
                                    'ar' => 'عروض أسبوعية ببرمجيات فعلية. بلا عروض شرائح، بلا أعذار. ثقافة الهندسة التي احتجناها تماماً حول منتجنا.',
                                    'tr' => 'Gerçekten çalışan yazılımla haftalık demolar. Slayt showu yok, bahane yok. Ürünümüzün etrafında ihtiyaç duyduğumuz mühendislik kültürü tam olarak buydu.',
                                ],
                                'name' => 'Samir Haddad',
                                'role' => [
                                    'en' => 'Head of Product, Fielder',
                                    'ar' => 'مدير المنتج، Fielder',
                                    'tr' => 'Ürün Başkanı, Fielder',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-2.png',
                                'rating' => 5,
                            ],
                            [
                                'quote' => [
                                    'en' => 'The RAG pipeline they built actually holds up in production. Observability from day one meant we could trust what we shipped.',
                                    'ar' => 'خط أنابيب RAG الذي بنوه يصمد فعلاً في الإنتاج. المراقبة من اليوم الأول جعلتنا نثق بما أطلقناه.',
                                    'tr' => 'Kurdukları RAG hattı gerçekten üretimde ayakta kaldı. İlk günden gözlemlenebilirlik, yayına aldığımıza güvenebilmemiz anlamına geliyordu.',
                                ],
                                'name' => 'Leïla Ouali',
                                'role' => [
                                    'en' => 'Founder, Bookstack AI',
                                    'ar' => 'مؤسِّسة، Bookstack AI',
                                    'tr' => 'Kurucu, Bookstack AI',
                                ],
                                'avatar' => 'codliy/images/testimonials/avatar-3.png',
                                'rating' => 5,
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // FAQ (landingFAQ)
                    // ───────────────────────────────────────────────
                    'faq' => [
                        'badge' => [
                            'en' => 'FAQ',
                            'ar' => 'الأسئلة الشائعة',
                            'tr' => 'SSS',
                        ],
                        'title' => [
                            'en' => 'Questions teams usually ask us first',
                            'ar' => 'الأسئلة التي تطرحها الفرق علينا أولاً عادةً',
                            'tr' => 'Ekiplerin bize genellikle ilk sorduğu sorular',
                        ],
                        'description' => [
                            'en' => 'Plain answers to the questions we hear most often before starting a new engagement.',
                            'ar' => 'إجابات واضحة للأسئلة التي نسمعها غالباً قبل بدء مشروع جديد.',
                            'tr' => 'Yeni bir projeye başlamadan önce en çok duyduğumuz soruların net yanıtları.',
                        ],
                        'items' => [
                            [
                                'question' => [
                                    'en' => 'How long does a typical engagement last?',
                                    'ar' => 'كم يستغرق المشروع النموذجي معكم؟',
                                    'tr' => 'Tipik bir proje ne kadar sürer?',
                                ],
                                'answer' => [
                                    'en' => 'Most projects run 8–16 weeks to first production release, then evolve on a monthly cadence as we add features and scale.',
                                    'ar' => 'تستغرق معظم المشاريع من 8 إلى 16 أسبوعاً حتى أول إصدار إنتاج، ثم تتطور بوتيرة شهرية مع إضافة الميزات والتوسع.',
                                    'tr' => 'Projelerin çoğu ilk üretim sürümüne kadar 8–16 hafta sürer, ardından özellik ekleyip ölçeklendirirken aylık bir kadansa evrilir.',
                                ],
                            ],
                            [
                                'question' => [
                                    'en' => 'Do you sign NDAs and work on proprietary codebases?',
                                    'ar' => 'هل توقّعون اتفاقيات سرية وتعملون على شيفرات مملوكة؟',
                                    'tr' => 'NDA imzalayıp tescilli kod tabanlarında çalışıyor musunuz?',
                                ],
                                'answer' => [
                                    'en' => 'Yes. We sign mutual NDAs, work inside your repos and cloud accounts, and respect your code review and security policies from day one.',
                                    'ar' => 'نعم. نوقّع اتفاقيات سرية متبادلة، ونعمل داخل مستودعاتك وحساباتك السحابية، ونلتزم بسياسات المراجعة والأمن لديك من اليوم الأول.',
                                    'tr' => 'Evet. Karşılıklı NDA imzalar, kendi depolarınız ve bulut hesaplarınızın içinde çalışır ve kod inceleme ile güvenlik politikalarınıza ilk günden uyarız.',
                                ],
                            ],
                            [
                                'question' => [
                                    'en' => 'Who actually writes the code?',
                                    'ar' => 'من يكتب الشيفرة فعلاً؟',
                                    'tr' => 'Kodu gerçekten kim yazıyor?',
                                ],
                                'answer' => [
                                    'en' => 'Senior engineers only. We do not hide juniors on projects. You meet the people doing the work, and they stay with you through the engagement.',
                                    'ar' => 'مهندسون خبراء فقط. لا نخفي مبتدئين في المشاريع. تلتقي بالأشخاص الذين ينفذون العمل ويبقون معك طوال المشروع.',
                                    'tr' => 'Yalnızca kıdemli mühendisler. Projelerde junior saklamayız. İşi yapan kişilerle tanışırsınız ve proje boyunca sizinle kalırlar.',
                                ],
                            ],
                            [
                                'question' => [
                                    'en' => 'How do you handle handover?',
                                    'ar' => 'كيف تتعاملون مع التسليم؟',
                                    'tr' => 'Devir teslimi nasıl yapıyorsunuz?',
                                ],
                                'answer' => [
                                    'en' => 'Everything ships with tests, CI/CD, observability dashboards, README and runbooks. We document architectural decisions and record walk-through videos of critical systems.',
                                    'ar' => 'كل شيء يُسلَّم مع اختبارات وCI/CD ولوحات مراقبة وملف README ودلائل تشغيل. نوثّق القرارات المعمارية ونسجّل مقاطع شرح للأنظمة الحرجة.',
                                    'tr' => 'Her şey testler, CI/CD, gözlemlenebilirlik panoları, README ve runbook’larla teslim edilir. Mimari kararları belgeler ve kritik sistemler için anlatım videoları kaydederiz.',
                                ],
                            ],
                            [
                                'question' => [
                                    'en' => 'Do you work in English, Arabic and Turkish?',
                                    'ar' => 'هل تعملون بالإنجليزية والعربية والتركية؟',
                                    'tr' => 'İngilizce, Arapça ve Türkçe çalışıyor musunuz?',
                                ],
                                'answer' => [
                                    'en' => 'Yes — our product is multilingual by default (EN / AR / TR) and we write docs, demos and contracts in the language your team actually uses.',
                                    'ar' => 'نعم — منتجنا متعدد اللغات افتراضياً (إنجليزية / عربية / تركية) ونكتب الوثائق والعروض والعقود باللغة التي يستخدمها فريقك فعلاً.',
                                    'tr' => 'Evet — ürünümüz varsayılan olarak çok dillidir (EN / AR / TR) ve belgeleri, demoları ve sözleşmeleri ekibinizin fiilen kullandığı dilde yazarız.',
                                ],
                            ],
                        ],
                    ],

                    // ───────────────────────────────────────────────
                    // CTA (landingCTA)
                    // ───────────────────────────────────────────────
                    'cta' => [
                        'title' => [
                            'en' => 'Ready to build something that holds up?',
                            'ar' => 'جاهز لبناء شيء يصمد فعلاً؟',
                            'tr' => 'Ayakta kalacak bir şey inşa etmeye hazır mısınız?',
                        ],
                        'subtitle' => [
                            'en' => 'Share a few lines about your product and we will come back with a realistic plan — no heavy sales process.',
                            'ar' => 'شاركنا بضعة أسطر عن منتجك وسنعود إليك بخطة واقعية — دون مسار مبيعات ثقيل.',
                            'tr' => 'Ürününüz hakkında birkaç satır paylaşın, gerçekçi bir planla geri döneriz — ağır bir satış süreci yok.',
                        ],
                        'button_text' => [
                            'en' => 'Start a Project',
                            'ar' => 'ابدأ مشروعاً',
                            'tr' => 'Bir Proje Başlat',
                        ],
                        'button_url' => '#contactUs',
                    ],

                    // ───────────────────────────────────────────────
                    // CONTACT
                    // ───────────────────────────────────────────────
                    'contact' => [
                        'badge' => [
                            'en' => 'CONTACT',
                            'ar' => 'تواصل',
                            'tr' => 'İLETİŞİM',
                        ],
                        'title' => [
                            'en' => 'Tell us about your project',
                            'ar' => 'أخبرنا عن مشروعك',
                            'tr' => 'Projeniz hakkında bize anlatın',
                        ],
                        'description' => [
                            'en' => 'Founders, CTOs and product leaders — write to us in English, Arabic or Turkish. We answer within one working day.',
                            'ar' => 'المؤسسون والمدراء التقنيون وقادة المنتج — راسلنا بالإنجليزية أو العربية أو التركية. نرد خلال يوم عمل واحد.',
                            'tr' => 'Kurucular, CTO’lar ve ürün liderleri — bize İngilizce, Arapça ya da Türkçe yazın. Bir iş günü içinde yanıtlıyoruz.',
                        ],
                        'email' => 'hello@codliy.com',
                        'phone' => '+90 (212) 000-0000',
                    ],
                ],
            ]
        );

        // ───────────────────────────────────────────────
        // SEO
        // ───────────────────────────────────────────────
        $landingPage->seo()->updateOrCreate(
            ['seoable_id' => $landingPage->id, 'seoable_type' => get_class($landingPage)],
            [
                'title' => [
                    'en' => 'Codliy — Senior software studio for web, mobile, cloud & AI',
                    'ar' => 'كودلي — استوديو برمجيات متمرس للويب والجوال والسحابة والذكاء الاصطناعي',
                    'tr' => 'Codliy — Web, mobil, bulut ve yapay zekâ için kıdemli yazılım stüdyosu',
                ],
                'meta_description' => [
                    'en' => 'Codliy is a small, senior team of engineers and designers shipping durable web, mobile, cloud and AI systems for founders and product teams.',
                    'ar' => 'كودلي فريق صغير من المهندسين والمصممين الخبراء يطلق أنظمة ويب وجوال وسحابة وذكاء اصطناعي موثوقة لصالح المؤسسين وفرق المنتج.',
                    'tr' => 'Codliy; kuruculara ve ürün ekiplerine dayanıklı web, mobil, bulut ve yapay zekâ sistemleri teslim eden, küçük ve kıdemli bir mühendis ve tasarımcı ekibidir.',
                ],
                'robots_index' => true,
                'robots_follow' => true,
            ]
        );
    }
}
