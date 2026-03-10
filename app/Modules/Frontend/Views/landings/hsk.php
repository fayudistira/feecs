<?php
/**
 * HSK Simulation Test Landing Page
 * 
 * Page-specific SEO and content for HSK Simulation Test
 */

// Page-specific variables for SEO
$pageTitle = 'HSK Simulation Test - Simulasi Ujian HSK Resmi | SOS Course';
$pageDescription = 'Ikuti simulasi HSK (Hanyu Shuiping Kaoshi) terlengkap dan terdekat dari Kampung Inggris Pare. Persiapan maksimal untuk ujian HSK 1-6 dengan soal asli dan standar resmi.';
$pageKeywords = 'simulasi HSK, test HSK, ujian HSK, kursus HSK, persiapan HSK, HSK 1, HSK 2, HSK 3, HSK 4, HSK 5, HSK 6, mandarin test, Chinese proficiency test, SOS Course';
$ogImage = 'https://images.pexels.com/photos/3769021/pexels-photo-3769021.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2';
?>

<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('extra_head') ?>
<!-- Page-specific styles for HSK landing -->
<style>
    /* Hero Section - Deep Red Background */
    .hsk-hero {
        background: linear-gradient(135deg, #8B0000 0%, #B22222 50%, #8B0000 100%);
        color: white;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .hsk-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50%" font-size="50" opacity="0.05">汉语</text></svg>');
        background-size: 150px;
        opacity: 0.3;
    }
    
    .hsk-hero .display-4 {
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .hsk-hero .lead {
        font-size: 1.25rem;
        opacity: 0.95;
    }
    
    /* HSK Level Cards */
    .hsk-level-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
    }
    
    .hsk-level-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(139, 0, 0, 0.2);
    }
    
    .hsk-level-card .card-header {
        background: linear-gradient(135deg, #8B0000 0%, #B22222 100%);
        color: white;
        padding: 1.5rem;
        border: none;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .hsk-level-card .card-body {
        padding: 1.5rem;
    }
    
    .hsk-level-card .vocab-count {
        color: #8B0000;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    /* Feature Boxes */
    .hsk-feature-box {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .hsk-feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(139, 0, 0, 0.15);
    }
    
    .hsk-feature-box .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #8B0000 0%, #B22222 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        color: white;
        font-size: 2rem;
    }
    
    /* Test Format Section */
    .test-format-card {
        background: #F8F9FA;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #8B0000;
    }
    
    .test-format-card h5 {
        color: #8B0000;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    /* CTA Button */
    .btn-hsk-cta {
        background: white;
        color: #8B0000;
        font-weight: 600;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        border: none;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-hsk-cta:hover {
        background: #F5E8E8;
        color: #8B0000;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    
    /* Stats Section */
    .hsk-stats {
        background: linear-gradient(135deg, #8B0000 0%, #B22222 100%);
        color: white;
        padding: 3rem 0;
    }
    
    .hsk-stats .stat-number {
        font-size: 3rem;
        font-weight: 700;
    }
    
    .hsk-stats .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Coming Soon Banner -->
<div class="alert alert-warning text-center mb-0 py-3">
    <i class="bi bi-clock-history me-2"></i>
    <strong>Coming Soon!</strong> Simulasi HSK akan segera tersedia. Stay tuned untuk informasi lebih lanjut.
</div>

<!-- Hero Section -->
<section class="hsk-hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="display-4 fw-bold mb-3">HSK Simulation Test</div>
                <p class="lead mb-4">
                    Simulasi ujian HSK (Hanyu Shuiping Kaoshi) dengan standar resmi. 
                    Persiapkan diri Anda untuk sertifikasi bahasa Mandarin China yang diakui secara internasional.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#levels" class="btn btn-hsk-cta disabled" aria-disabled="true">
                        <i class="bi bi-play-circle me-2"></i>Mulai Simulasi
                    </a>
                    <a href="#features" class="btn btn-outline-light rounded-pill px-4 py-2">
                        <i class="bi bi-info-circle me-2"></i>Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="display-1 fw-bold">HSK</div>
                <div class="h3">汉语水平考试</div>
                <p class="mt-3 opacity-75">Chinese Proficiency Test</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="hsk-stats">
    <div class="container">
        <div class="row text-center">
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="stat-number">6</div>
                <div class="stat-label">Tingkat HSK</div>
            </div>
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="stat-number">5000+</div>
                <div class="stat-label">Kosa Kata</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">100+</div>
                <div class="stat-label">Soal per Test</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">100%</div>
                <div class="stat-label">Standar Resmi</div>
            </div>
        </div>
    </div>
</section>

<!-- HSK Levels Section -->
<section id="levels" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark-red">Tingkat HSK (HSK Levels)</h2>
            <p class="text-muted">Pilih tingkat yang sesuai dengan kemampuan Anda</p>
        </div>
        
        <div class="row g-4">
            <!-- HSK 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-1-circle me-2"></i>HSK Level 1
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">175</div>
                        <p class="text-muted mb-3">Kosa Kata Dasar</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 40 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 40 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat memahami dan menggunakan frasa sederhana</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 1">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- HSK 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-2-circle me-2"></i>HSK Level 2
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">300</div>
                        <p class="text-muted mb-3">Kosa Kata Dasar</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 55 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 60 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat berkomunikasi dalam situasi kehidupan sehari-hari</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 2">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- HSK 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-3-circle me-2"></i>HSK Level 3
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">600</div>
                        <p class="text-muted mb-3">Kosa Kata Menengah</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 90 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 80 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat berkomunikasi dalam topik yang familiar</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 3">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- HSK 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-4-circle me-2"></i>HSK Level 4
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">1200</div>
                        <p class="text-muted mb-3">Kosa Kata Menengah</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 100 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 100 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat berbicara dengan fluen tentang berbagai topik</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 4">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- HSK 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-5-circle me-2"></i>HSK Level 5
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">2500</div>
                        <p class="text-muted mb-3">Kosa Kata Lanjutan</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 120 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 100 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat membaca artikel surat kabar dengan pemahaman penuh</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 5">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- HSK 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="hsk-level-card">
                    <div class="card-header">
                        <i class="bi bi-6-circle me-2"></i>HSK Level 6
                    </div>
                    <div class="card-body">
                        <div class="vocab-count mb-2">5000+</div>
                        <p class="text-muted mb-3">Kosa Kata Lanjutan</p>
                        <hr>
                        <p class="small mb-2"><strong>Durasi:</strong> 140 menit</p>
                        <p class="small mb-2"><strong>Soal:</strong> 101 soal</p>
                        <p class="small mb-4"><strong>Tujuan:</strong> Dapat dengan mudah memahami informasi tertulis dan lisan</p>
                        <button class="btn btn-dark-red w-100" data-bs-toggle="modal" data-bs-target="#registerModal" data-level="HSK Level 6">
                            <i class="bi bi-pencil-square me-2"></i>Daftar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark-red">Keunggulan Simulasi HSK SOS Course</h2>
            <p class="text-muted">Persiapan maksimal untuk menghadapi ujian HSK resmi</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="hsk-feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h5>Soal Standar Resmi</h5>
                    <p class="text-muted mb-0">Soal simulasi disusun sesuai standar resmi dari Hanban/Confucius Headquarters</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="hsk-feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h5>Timer Real-time</h5>
                    <p class="text-muted mb-0">Simulasi dengan timer реального времени untuk melatih manajemen waktu</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="hsk-feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h5>Analisis Detail</h5>
                    <p class="text-muted mb-0">Dapatkan analisis skor detail untuk mengetahui area yang perlu ditingkatkan</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="hsk-feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h5>Sertifikat</h5>
                    <p class="text-muted mb-0">Dapatkan sertifikat penyelesaian setelah menyelesaikan simulasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Test Format Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="fw-bold text-dark-red mb-4">Format Ujian HSK</h2>
                
                <div class="test-format-card">
                    <h5><i class="bi bi-earbuds me-2"></i>Listening (Mendengarkan)</h5>
                    <p class="mb-0">Bagian ini menguji kemampuan memahami percakapan dan ujaran dalam bahasa Mandarin. Terdapat berbagai tingkat kesulitan sesuai level HSK.</p>
                </div>
                
                <div class="test-format-card">
                    <h5><i class="bi bi-book me-2"></i>Reading (Membaca)</h5>
                    <p class="mb-0">Menguji kemampuan memahami teks tertulis dalam bahasa Mandarin, dari tingkat paling dasar hingga kompleks.</p>
                </div>
                
                <div class="test-format-card">
                    <h5><i class="bi bi-pencil me-2"></i>Writing (Menulis)</h5>
                    <p class="mb-0">Hanya untuk HSK level 5 dan 6. Menguji kemampuan menulis dalam bahasa Mandarin dengan cara填写试题 dan menulis esai.</p>
                </div>
            </div>
            
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark-red mb-4">Siapa yang perlu mengikuti HSK?</h4>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-check"></i>
                            </div>
                            <div>
                                <strong>Pelajar</strong>
                                <p class="mb-0 text-muted small">Yang ingin melanjutkan studi ke Tiongkok</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-check"></i>
                            </div>
                            <div>
                                <strong>Pekerja</strong>
                                <p class="mb-0 text-muted small">Yang ingin bekerja di perusahaan Tiongkok</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-check"></i>
                            </div>
                            <div>
                                <strong>Pengajar Mandarin</strong>
                                <p class="mb-0 text-muted small">Yang ingin membuktikan kompetensi mengajar</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-check"></i>
                            </div>
                            <div>
                                <strong>Minat Pribadi</strong>
                                <p class="mb-0 text-muted small">Yang ingin mengukur kemampuan bahasa Mandarin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark-red text-white">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Pendaftaran Simulasi HSK
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="hskRegisterForm">
                    <input type="hidden" id="selectedLevel" name="hsk_level" value="">
                    
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Anda akan mendaftar untuk: <strong id="displayLevel" class="text-dark-red"></strong>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullName" name="full_name" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="contoh@email.com">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required placeholder="0812xxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label for="birthDate" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="birthDate" name="birth_date">
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="education" class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select" id="education" name="education">
                                <option value="">Pilih pendidikan</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA/SMK</option>
                                <option value="D3">D3 (Diploma)</option>
                                <option value="S1">S1 (Sarjana)</option>
                                <option value="S2">S2 (Magister)</option>
                                <option value="S3">S3 (Doktor)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="occupation" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Contoh: Pelajar, Karyawan, dll">
                        </div>
                        <div class="col-12">
                            <label for="mandarinLevel" class="form-label">Kemampuan Bahasa Mandarin Saat Ini</label>
                            <select class="form-select" id="mandarinLevel" name="mandarin_level">
                                <option value="">Pilih tingkat kemampuan</option>
                                <option value="Tidak Ada">Tidak Ada / Pemula</option>
                                <option value="HSK 1">Sudah Mengikuti Kursus HSK 1</option>
                                <option value="HSK 2">Sudah Mengikuti Kursus HSK 2</option>
                                <option value="HSK 3">Sudah Mengikuti Kursus HSK 3</option>
                                <option value="HSK 4">Sudah Mengikuti Kursus HSK 4</option>
                                <option value="HSK 5">Sudah Mengikuti Kursus HSK 5</option>
                                <option value="HSK 6">Sudah Mengikuti Kursus HSK 6</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tulis pertanyaan atau informasi tambahan yang ingin disampaikan"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    Saya setuju dengan <a href="#" class="text-dark-red">syarat dan ketentuan</a> yang berlaku
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-dark-red btn-lg w-100">
                            <i class="bi bi-send me-2"></i>Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="py-5 bg-dark-red text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Siap Menghadapi Ujian HSK?</h2>
        <p class="mb-4 opacity-75">Ikuti simulasi HSK di SOS Course dan persiapkan diri Anda untuk sukses!</p>
        <a href="#levels" class="btn btn-light btn-lg px-5 py-3 rounded-pill disabled" aria-disabled="true">
            <i class="bi bi-play-fill me-2"></i>Mulai Simulasi Sekarang
        </a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle modal level selection
    const registerModal = document.getElementById('registerModal');
    if (registerModal) {
        registerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const level = button.getAttribute('data-level');
            
            document.getElementById('selectedLevel').value = level;
            document.getElementById('displayLevel').textContent = level;
        });
    }
    
    // Handle form submission
    const form = document.getElementById('hskRegisterForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            
            // Collect form data
            const formData = {
                hsk_level: document.getElementById('selectedLevel').value,
                full_name: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                birth_date: document.getElementById('birthDate').value || null,
                address: document.getElementById('address').value || null,
                education: document.getElementById('education').value || null,
                occupation: document.getElementById('occupation').value || null,
                mandarin_level: document.getElementById('mandarinLevel').value || null,
                notes: document.getElementById('notes').value || null
            };
            
            try {
                const response = await fetch('<?= base_url("frontend/api/test-registration") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(registerModal);
                    modal.hide();
                    // Reset form
                    form.reset();
                } else {
                    alert(result.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
