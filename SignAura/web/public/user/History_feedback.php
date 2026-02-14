<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | History & Feedback</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 50%, #F97316 100%);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-logout {
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            transition: transform 0.2s;
        }

        .btn-logout:hover { transform: translateY(-2px); color: white; }

        .btn-back {
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            margin-right: 15px;
            transition: color 0.2s;
        }
        .btn-back:hover { color: #1f2937; }

        .container { margin-top: 40px; padding-bottom: 50px; }

        .page-header {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .table th { padding: 15px; font-weight: 600; border: none; }
        .table td { padding: 15px; vertical-align: middle; }

        .badge-accuracy { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 13px; }
        .badge-high { background: #dcfce7; color: #166534; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-low { background: #fee2e2; color: #991b1b; }

        /* Feedback Form */
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid #e5e7eb;
        }
        .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .star-rating {
            font-size: 32px;
            color: #d1d5db;
            cursor: pointer;
        }
        .star-rating .star:hover,
        .star-rating .star.active { color: #fbbf24; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
            border: none;
            margin-top: 20px;
        }
        .btn-submit:hover { transform: translateY(-2px); }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
        .empty-state-icon { font-size: 48px; margin-bottom: 10px; opacity: 0.5; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-5">
            <a class="navbar-brand" href="#">✨ SignAura</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="dashboard.php" class="btn-back">← Dashboard</a>
                <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        
        <div class="page-header">
            <h2 class="m-0">📚 History & Feedback</h2>
            <p class="text-muted mt-2 mb-0">Review translations and share your experience</p>
        </div>

        <div class="row">
            <!-- LEFT COLUMN: HISTORY -->
            <div class="col-lg-8">
                <!-- HISTORY TABLE -->
                <div class="section-card">
                    <div class="section-title">📜 Sentence History</div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                             <thead>
                                 <tr>
                                     <th>Date</th>
                                     <th>🇬🇧 English</th>
                                     <th>🇱🇰 Sinhala</th>
                                     <th>🇮🇳 Tamil</th>
                                     <th>Score</th>
                                     <th>Actions</th>
                                 </tr>
                             </thead>
                             <tbody id="sentences-tbody">
                                 <tr><td colspan="6" class="text-center p-4">Loading history...</td></tr>
                             </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAST FEEDBACK TABLE -->
                <div class="section-card">
                    <div class="section-title">💬 My Past Feedback</div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody id="feedback-tbody">
                                <tr><td colspan="4" class="text-center p-4">Loading feedback...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: FEEDBACK FORM -->
            <div class="col-lg-4">
                <div class="section-card">
                    <div class="section-title">✍️ Submit Feedback</div>
                    
                     <form id="feedback-form">
                         <div id="success-message" class="alert alert-success" style="display:none;">
                             ✅ Feedback submitted!
                         </div>

                         <div class="mb-3">
                             <label class="form-label fw-bold">Select Sentence</label>
                             <select class="form-select" name="sentence_id" id="sentence-select" required>
                                 <option value="">Select a sentence...</option>
                             </select>
                         </div>

                         <div class="mb-3">
                             <label class="form-label fw-bold">Is this translation correct?</label>
                             <div class="form-check">
                                 <input class="form-check-input" type="radio" name="is_correct" value="1" id="correct-yes" required>
                                 <label class="form-check-label" for="correct-yes">Yes</label>
                             </div>
                             <div class="form-check">
                                 <input class="form-check-input" type="radio" name="is_correct" value="0" id="correct-no" required>
                                 <label class="form-check-label" for="correct-no">No</label>
                             </div>
                         </div>

                         <div class="mb-3" id="correct-text-group" style="display:none;">
                             <label class="form-label fw-bold">What should it be?</label>
                             <textarea class="form-control" name="correct_text" rows="3" placeholder="Provide the correct translation..."></textarea>
                         </div>

                         <div class="mb-3">
                             <label class="form-label fw-bold">Rating</label>
                             <div class="star-rating" id="star-rating">
                                 <span class="star" data-value="1">★</span>
                                 <span class="star" data-value="2">★</span>
                                 <span class="star" data-value="3">★</span>
                                 <span class="star" data-value="4">★</span>
                                 <span class="star" data-value="5">★</span>
                             </div>
                             <input type="hidden" name="rating" id="rating-input">
                         </div>

                         <div class="mb-3">
                             <label class="form-label fw-bold">Additional Comments</label>
                             <textarea class="form-control" name="message" rows="3" placeholder="Any additional feedback..."></textarea>
                         </div>

                         <button type="submit" class="btn-submit">Submit Feedback</button>
                     </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- 1. Load Sentences ---
        async function loadHistory() {
            try {
                const response = await fetch('../api/fetch_sentences.php');
                const data = await response.json();
                const tbody = document.getElementById('sentences-tbody');
                
                if (data.success && data.sentences.length > 0) {
                    tbody.innerHTML = '';
                    const select = document.getElementById('sentence-select');
                    select.innerHTML = '<option value="">Select a sentence...</option>';
                    data.sentences.forEach(s => {
                        const accuracyClass = s.accuracy >= 80 ? 'badge-high' :
                                            s.accuracy >= 50 ? 'badge-medium' : 'badge-low';

                        const row = `
                            <tr>
                                <td class="text-muted small">${s.date_formatted}</td>
                                <td class="fw-semibold text-primary">${s.sentence_en}</td>
                                <td>${s.sentence_si}</td>
                                <td>${s.sentence_ta}</td>
                                <td><span class="badge-accuracy ${accuracyClass}">${s.accuracy}%</span></td>
                                <td><button class="btn btn-sm btn-danger delete-btn" data-id="${s.id}">🗑️ Delete</button></td>
                            </tr>
                        `;
                        tbody.innerHTML += row;

                        // Add to select
                        const option = document.createElement('option');
                        option.value = s.id;
                        option.textContent = `${s.sentence_en} (${s.accuracy}%)`;
                        select.appendChild(option);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center p-4">No sentences found yet.</td></tr>`;
                    document.getElementById('sentence-select').innerHTML = '<option value="">No sentences available</option>';
                }
            } catch (error) {
                console.error('Error:', error);
                 document.getElementById('sentences-tbody').innerHTML = `<tr><td colspan="6" class="text-center text-danger">Failed to load</td></tr>`;
            }
        }
        loadHistory();

        // Delete sentence
        document.addEventListener('click', async function(e) {
            if (e.target.classList.contains('delete-btn')) {
                const id = e.target.dataset.id;
                if (confirm('Are you sure you want to delete this sentence?')) {
                    try {
                        const res = await fetch('../api/delete_sentence.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({sentence_id: id})
                        });
                        const data = await res.json();
                        if (data.success) {
                            loadHistory(); // Reload
                        } else {
                            alert('Error: ' + (data.error || 'Delete failed'));
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Error deleting sentence');
                    }
                }
            }
        });

        // Show/hide correct text
        document.querySelectorAll('input[name="is_correct"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const group = document.getElementById('correct-text-group');
                group.style.display = this.value === '0' ? 'block' : 'none';
                if (this.value === '1') {
                    document.querySelector('textarea[name="correct_text"]').value = '';
                }
            });
        });

        // --- 2. Load User Feedback ---
        async function loadFeedback() {
            try {
                const response = await fetch('../api/fetch_user_feedback.php');
                const data = await response.json();
                const tbody = document.getElementById('feedback-tbody');
                
                if (data.success && data.feedback.length > 0) {
                    tbody.innerHTML = '';
                    data.feedback.forEach(f => {
                        const row = `
                            <tr>
                                <td class="text-muted small">${f.date_formatted}</td>
                                <td><span class="badge bg-light text-dark border">${f.category}</span></td>
                                <td><span class="text-warning">${'★'.repeat(f.rating)}</span></td>
                                <td class="small">${f.message}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center p-4">No feedback submitted yet.</td></tr>`;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('feedback-tbody').innerHTML = `<tr><td colspan="4" class="text-center text-danger">Failed to load</td></tr>`;
            }
        }
        loadFeedback();

        // --- 3. Star Rating Logic ---
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating-input');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = this.dataset.value;
                ratingInput.value = val;
                stars.forEach(s => s.classList.toggle('active', s.dataset.value <= val));
            });
        });

        // --- 4. Feedback Submission ---
        document.getElementById('feedback-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            if(!ratingInput.value) { alert('Please select a rating!'); return; }
            if(!this.sentence_id.value) { alert('Please select a sentence!'); return; }
            const isCorrect = this.is_correct.value;
            if(isCorrect === undefined) { alert('Please indicate if the translation is correct!'); return; }

            const formData = {
                sentence_id: parseInt(this.sentence_id.value),
                is_correct: isCorrect === '1',
                correct_text: this.correct_text.value,
                rating: parseInt(ratingInput.value),
                message: this.message.value
            };

            try {
                const res = await fetch('../api/submit_feedback.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(formData)
                });
                const data = await res.json();

                if(data.success) {
                    document.getElementById('success-message').style.display = 'block';
                    this.reset();
                    stars.forEach(s => s.classList.remove('active'));
                    document.getElementById('correct-text-group').style.display = 'none';
                    loadFeedback(); // Reload table
                    setTimeout(() => document.getElementById('success-message').style.display = 'none', 4000);
                } else {
                    alert('Error: ' + (data.error || 'Submission failed'));
                }
            } catch(err) {
                console.error(err);
                alert('Error submitting feedback');
            }
        });
    </script>
</body>
</html>
