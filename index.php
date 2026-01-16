<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    // Get form data
    $data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'name' => $_POST['name'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'age' => $_POST['age'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'usage' => $_POST['usage'] ?? '',
        'strength' => $_POST['strength'] ?? '',
        'style' => $_POST['style'] ?? '',
        'note' => $_POST['note'] ?? '',
        'result_perfume' => $_POST['result_perfume'] ?? ''
    ];
    
    // Create data directory if it doesn't exist
    if (!file_exists('quiz_data')) {
        mkdir('quiz_data', 0755, true);
    }
    
    // Save to CSV file
    $filename = 'quiz_data/responses.csv';
    $file_exists = file_exists($filename);
    $file = fopen($filename, 'a');
    
    // Add header if file is new
    if (!$file_exists) {
        fputcsv($file, array_keys($data));
    }
    
    // Add data
    fputcsv($file, $data);
    fclose($file);
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مُخمَل - اكتشف عطرك المثالي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <img src="logo.svg" alt="مُخمَل" class="brand-logo">
            </div>
            <h1 class="brand-name">مُخمَل</h1>
            <p class="tagline">حضور لا ينسى</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
            <div class="progress-text" id="progressText">1 / 7</div>
        </div>

        <!-- Quiz Form -->
        <div class="quiz-container" id="quizContainer">
            <form id="quizForm" method="POST">
                
                <!-- Step 1: Age -->
                <div class="step" data-step="1">
                    <h2 class="step-title">كم عمرك؟</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="age" value="under18">
                            <div class="option-box">أقل من 18</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="age" value="20s">
                            <div class="option-box">العشرينات</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="age" value="30s">
                            <div class="option-box">الثلاثينات</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="age" value="40s">
                            <div class="option-box">الأربعينات</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="age" value="50plus">
                            <div class="option-box">50+</div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Gender -->
                <div class="step" data-step="2" style="display: none;">
                    <h2 class="step-title">اختر الفئة</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="gender" value="male">
                            <div class="option-box">رجالي</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="gender" value="female">
                            <div class="option-box">نسائي</div>
                        </label>
                    </div>
                </div>

                <!-- Step 3: Usage -->
                <div class="step" data-step="3" style="display: none;">
                    <h2 class="step-title">متى ستستخدم العطر غالبًا؟</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="usage" value="daily">
                            <div class="option-box">يومي</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="usage" value="formal">
                            <div class="option-box">مناسبات</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="usage" value="night">
                            <div class="option-box">مساء</div>
                        </label>
                    </div>
                </div>

                <!-- Step 4: Strength -->
                <div class="step" data-step="4" style="display: none;">
                    <h2 class="step-title">تحب العطر يكون؟</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="strength" value="soft">
                            <div class="option-box">ناعم وقريب</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="strength" value="balanced">
                            <div class="option-box">متوازن</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="strength" value="strong">
                            <div class="option-box">قوي ولافت</div>
                        </label>
                    </div>
                </div>

                <!-- Step 5: Style -->
                <div class="step" data-step="5" style="display: none;">
                    <h2 class="step-title">أي طابع يلفت انتباهك أكثر؟</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="style" value="classic">
                            <div class="option-box">كلاسيكي وأنيق</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="style" value="modern">
                            <div class="option-box">عصري ومضيء</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="style" value="mysterious">
                            <div class="option-box">غامض وعميق</div>
                        </label>
                    </div>
                </div>

                <!-- Step 6: Note -->
                <div class="step" data-step="6" style="display: none;">
                    <h2 class="step-title">اختر النوتة الأقرب لقلبك</h2>
                    <div class="options">
                        <label class="option-label">
                            <input type="radio" name="note" value="oud">
                            <div class="option-box">عود وخشب</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="note" value="floral">
                            <div class="option-box">زهور ناعمة</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="note" value="sweet">
                            <div class="option-box">حلاوة دافئة</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="note" value="fresh">
                            <div class="option-box">انتعاش وحمضيات</div>
                        </label>
                        <label class="option-label">
                            <input type="radio" name="note" value="spicy">
                            <div class="option-box">توابل وحِدّة</div>
                        </label>
                    </div>
                </div>

                <!-- Step 7: Contact Info -->
                <div class="step" data-step="7" style="display: none;">
                    <h2 class="step-title">معلومات التواصل</h2>
                    <div class="contact-fields">
                        <div class="field-group">
                            <input type="text" name="name" id="name" class="contact-input" placeholder="الاسم" required>
                        </div>
                        <div class="field-group">
                            <input type="tel" name="phone" id="phone" class="contact-input" placeholder="رقم الهاتف" required>
                        </div>
                        <div class="field-group">
                            <input type="email" name="email" id="email" class="contact-input" placeholder="البريد الإلكتروني" required>
                        </div>
                        <input type="hidden" name="result_perfume" id="result_perfume">
                        <input type="hidden" name="submit_quiz" value="1">
                        <button type="submit" class="btn-submit">اكتشف عطرك المثالي</button>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="navigation">
                    <button type="button" class="btn-prev" id="prevBtn" style="display: none;">← السابق</button>
                </div>

            </form>
        </div>

        <!-- Result Container -->
        <div class="result-container" id="resultContainer" style="display: none;">
            <div class="result-card">
                <div class="result-header">
                    <img src="logo.svg" alt="مُخمَل" class="result-logo">
                    <h2 class="result-title">عطرك المثالي</h2>
                </div>
                
                <div class="perfume-result">
                    <div class="perfume-image-container">
                        <img id="plantImage" src="" alt="" class="perfume-image">
                    </div>
                    
                    <h3 id="plantName" class="perfume-name"></h3>
                    
                    <div id="plantDescription" class="perfume-description"></div>
                    
                    <div class="result-actions">
                        <button id="resetButton" class="btn-secondary">
                            إعادة الاختبار
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>© 2025 مُخمَل</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Perfume database
        const perfumes = {
            ouwar: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=أُوار',
                name: 'أُوار',
                gender: 'male',
                notes: 'عود، عنبر، مسك',
                description: 'عطر شرقي فخم يجمع بين دفء العود وعمق العنبر، مثالي للمناسبات الرسمية والأمسيات الخاصة.'
            },
            lail: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=ليل',
                name: 'ليل',
                gender: 'male',
                notes: 'عود، فانيليا، تبغ',
                description: 'عطر غامض وجذاب يمزج بين قوة العود وحلاوة الفانيليا مع لمسة من التبغ الفاخر.'
            },
            ward: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=ورد',
                name: 'ورد',
                gender: 'female',
                notes: 'ورد، ياسمين، مسك',
                description: 'عطر زهري أنثوي راقي يجسد الأنوثة الناعمة مع لمسة من المسك الدافئ.'
            },
            noor: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=نور',
                name: 'نور',
                gender: 'female',
                notes: 'حمضيات، زهور، فانيليا',
                description: 'عطر منعش ومشرق يبدأ بحمضيات حيوية وينتهي بدفء الفانيليا الحلوة.'
            },
            samt: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=صمت',
                name: 'صمت',
                gender: 'male',
                notes: 'خشب الصندل، عود، مسك',
                description: 'عطر هادئ وعميق يعكس الوقار والأناقة الكلاسيكية.'
            },
            farah: {
                image: 'https://via.placeholder.com/400x300/2f2f2f/fed700?text=فرح',
                name: 'فرح',
                gender: 'female',
                notes: 'فواكه، زهور، كراميل',
                description: 'عطر مبهج وحلو يجمع بين نضارة الفواكه وحلاوة الكراميل الدافئة.'
            }
        };

        function includesAny(text, keywords) {
            return keywords.some(kw => text.includes(kw));
        }

        function extractTags(perfume) {
            const text = `${perfume.notes} ${perfume.description}`.toLowerCase();
            const tags = new Set();

            if (includesAny(text, ['عود', 'خشب'])) tags.add('oud');
            if (includesAny(text, ['خشب', 'صندل'])) tags.add('woody');
            if (includesAny(text, ['عنبر'])) tags.add('amber');
            if (includesAny(text, ['مسك'])) tags.add('musk');
            if (includesAny(text, ['فانيليا', 'كراميل', 'عسل', 'تونكا', 'حلو'])) tags.add('sweet');
            if (includesAny(text, ['حمضيات', 'ليمون', 'مندرين', 'برغموت', 'تفاح', 'أناناس', 'منعش'])) tags.add('fresh');
            if (includesAny(text, ['ورد', 'زهور', 'ياسمين', 'غاردينيا', 'أوركيد', 'زهر'])) tags.add('floral');
            if (includesAny(text, ['فلفل', 'قرفة', 'هيل', 'زعفران', 'توابل', 'حار'])) tags.add('spicy');
            if (includesAny(text, ['بخور', 'دخاني', 'تبغ'])) tags.add('smoky');
            if (includesAny(text, ['خوخ', 'توت', 'فريز', 'كمثرى', 'كرز', 'عنب', 'فروتي', 'فواكه'])) tags.add('fruity');

            if (includesAny(text, ['قوي', 'حاد', 'جريء', 'مشتعل'])) tags.add('strong');
            if (includesAny(text, ['ناعم', 'مريح', 'هادئ'])) tags.add('soft');
            if (includesAny(text, ['متوازن', 'متزن'])) tags.add('balanced');

            if (includesAny(text, ['فخم', 'مهيب', 'وقار', 'هيبة', 'راقي', 'أنيق', 'تميّز', 'رسمي'])) tags.add('formal');
            if (includesAny(text, ['عصري', 'حديث', 'مشرق'])) tags.add('modern');
            if (includesAny(text, ['كلاسيكي', 'أناقة'])) tags.add('classic');
            if (includesAny(text, ['غامض', 'مظلم', 'ليلي', 'جذاب'])) tags.add('mysterious');
            if (includesAny(text, ['رومانسي'])) tags.add('romantic');

            return tags;
        }

        function scorePerfume(perfumeTags, desiredTags) {
            const weights = {
                note: 4,
                occasion: 2,
                strength: 2,
                style: 2
            };

            let score = 0;

            desiredTags.forEach(item => {
                if (perfumeTags.has(item.tag)) {
                    score += weights[item.kind] ?? 1;
                }
            });

            return score;
        }

        // Step navigation
        let currentStep = 1;
        const totalSteps = 7;

        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('progressText').textContent = `${currentStep} / ${totalSteps}`;
        }

        function showStep(stepNumber) {
            document.querySelectorAll('.step').forEach(step => {
                step.style.display = 'none';
            });
            
            const targetStep = document.querySelector(`[data-step="${stepNumber}"]`);
            if (targetStep) {
                targetStep.style.display = 'block';
            }

            const prevBtn = document.getElementById('prevBtn');
            if (stepNumber > 1) {
                prevBtn.style.display = 'block';
            } else {
                prevBtn.style.display = 'none';
            }

            currentStep = stepNumber;
            updateProgress();
        }

        // Auto-advance on selection (except for step 7 which is the contact form)
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                setTimeout(() => {
                    if (currentStep < totalSteps) {
                        showStep(currentStep + 1);
                    }
                }, 300);
            });
        });

        // Previous button
        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });

        function calculateAndShowResult() {
            const formData = new FormData(document.getElementById('quizForm'));
            const gender = formData.get('gender');
            const usage = formData.get('usage');
            const strength = formData.get('strength');
            const style = formData.get('style');
            const note = formData.get('note');

            const desiredTags = [];

            if (note === 'oud') {
                desiredTags.push({ kind: 'note', tag: 'oud' });
                desiredTags.push({ kind: 'note', tag: 'woody' });
            }
            if (note === 'floral') desiredTags.push({ kind: 'note', tag: 'floral' });
            if (note === 'sweet') desiredTags.push({ kind: 'note', tag: 'sweet' });
            if (note === 'fresh') desiredTags.push({ kind: 'note', tag: 'fresh' });
            if (note === 'spicy') desiredTags.push({ kind: 'note', tag: 'spicy' });

            if (usage === 'daily') desiredTags.push({ kind: 'occasion', tag: 'fresh' });
            if (usage === 'formal') desiredTags.push({ kind: 'occasion', tag: 'formal' });
            if (usage === 'night') {
                desiredTags.push({ kind: 'occasion', tag: 'mysterious' });
                desiredTags.push({ kind: 'occasion', tag: 'romantic' });
            }

            if (strength === 'soft') desiredTags.push({ kind: 'strength', tag: 'soft' });
            if (strength === 'balanced') desiredTags.push({ kind: 'strength', tag: 'balanced' });
            if (strength === 'strong') desiredTags.push({ kind: 'strength', tag: 'strong' });

            if (style === 'classic') desiredTags.push({ kind: 'style', tag: 'classic' });
            if (style === 'modern') desiredTags.push({ kind: 'style', tag: 'modern' });
            if (style === 'mysterious') desiredTags.push({ kind: 'style', tag: 'mysterious' });

            const perfumeEntries = Object.entries(perfumes);
            const candidates = perfumeEntries.filter(([, perfume]) => perfume.gender === gender);
            const pool = candidates.length > 0 ? candidates : perfumeEntries;

            let bestKey = pool[0][0];
            let bestScore = -1;

            pool.forEach(([key, perfume]) => {
                const tags = extractTags(perfume);
                const score = scorePerfume(tags, desiredTags);
                if (score > bestScore) {
                    bestScore = score;
                    bestKey = key;
                }
            });

            const perfume = perfumes[bestKey];

            // Store result in hidden field for PHP submission
            document.getElementById('result_perfume').value = perfume.name;

            document.getElementById('plantImage').src = perfume.image;
            document.getElementById('plantImage').alt = perfume.name;
            document.getElementById('plantName').textContent = perfume.name;
            document.getElementById('plantDescription').innerHTML = `<strong>النوتات:</strong> ${perfume.notes}<br><br>${perfume.description}`;

            document.getElementById('quizContainer').style.display = 'none';
            document.getElementById('resultContainer').style.display = 'block';

            window.scrollTo({ top: 0 });
        }

        // Form submission handler
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Calculate result first
            calculateAndShowResult();
            
            // Submit data to PHP backend
            const formData = new FormData(this);
            
            fetch('index.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Quiz data saved successfully');
                }
            })
            .catch(error => {
                console.error('Error saving quiz data:', error);
            });
        });

        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('quizForm').reset();
            currentStep = 1;
            showStep(1);
            document.getElementById('quizContainer').style.display = 'block';
            document.getElementById('resultContainer').style.display = 'none';
            window.scrollTo({ top: 0 });
        });

        // Initialize
        showStep(1);
    </script>
</body>
</html>
