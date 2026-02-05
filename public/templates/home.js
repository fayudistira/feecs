// home.js - DIPERBAIKI
// JavaScript untuk konten home section

// Application Data dengan fitur untuk paket yang sudah dikelompokkan
const appData = {
    languages: [
        {
            id: "mandarin",
            name: "Mandarin",
            description: "Bahasa yang paling banyak digunakan di dunia dengan lebih dari 1 miliar penutur. Bahasa Mandarin membuka berbagai peluang untuk mengembangkan bisnis, karir, dan studi baik nasional maupun internasional.",
            level: "HSK-HSKK-TOCFL",
            flagColor: "#DE2910",
            flag: "https://flagcdn.com/48x36/cn.png",
            generalFeatures: [
                {
                    icon: "fas fa-handshake",
                    title: "Peluang Kerja",
                    description: "Peluang kerja di perusahaan Tiongkok dalam dan luar negeri",
                },
                {
                    icon: "fas fa-graduation-cap",
                    title: "Peluang Beasiswa",
                    description: "Akses beasiswa ke universitas di Tiongkok dan Taiwan",
                },
                {
                    icon: "fas fa-chart-line",
                    title: "Penerjemah/Translator",
                    description: "Peluang usaha jasa konsultan dan penerjemah bahasa mandarin",
                },
            ],
            packages: [
                {
                    name: "Fullday",
                    description: "Program intensif fullday Mandarin area hingga 5x pertemuan/hari dengan berbagai pilihan paket 3 bulan, 5 bulan, 7 bulan, dan 9 bulan.",
                    duration: "3-9 bulan",
                    level: "HSK1-HSK5",
                    options: [
                        "Kelas intensif 5x /hari",
                        "Camp Mandarin Area",
                        "Free T-Shirt Eksklusif",
                        "Modul, Kamus & Buku Saku",
                        "Sertifikat diakui",
                    ],
                    highlight: "",
                },
                {
                    name: "Kelas Privat",
                    description: "Pembelajaran lebih intens dan spesifik dengan sistem 1-on-1 sehingga dapat disesuaikan dengan waktu dan kebutuhan belajar siswa.",
                    duration: "Fleksibel",
                    level: "HSK / HSKK / TOCFL",
                    options: [
                        "Jadwal fleksibel",
                        "Bisa request materi",
                        "Pembelajaran lebih cepat",
                        "Pengajar profesional",
                        "Free Modul & Sertifkat",
                    ],
                    highlight: "",
                },
                {
                    name: "Kelas Online",
                    description: "Pembelajaran fleksibel yang dapat diakses di mana saja dengan banyak pilihan level/materi untuk anda yang punya kesibukan",
                    duration: "Privat / Reguler",
                    level: "HSK / HSKK / TOCFL",
                    options: [
                        "Pilihan privat atau reguler",
                        "Materi HSK dan HSKK semua level",
                        "Kelas interaktif via Zoom",
                        "Akses rekaman kelas",
                        "Materi digital lengkap",
                    ],
                    highlight: "",
                },
            ],
        },
        {
            id: "jepang",
            name: "Jepang",
            description: "Pelajari bahasa Jepang untuk memahami budaya populer, teknologi, dan peluang kerja di perusahaan Jepang.",
            level: "JLPT-JFT",
            flagColor: "#BC002D",
            flag: "https://flagcdn.com/48x36/jp.png",
            icon: "fas fa-book",
            generalFeatures: [
                {
                    icon: "fas fa-handshake",
                    title: "Peluang Magang/Kerja",
                    description: "Peluang magang/kerja di Jepang di berbagai sektor dan industri",
                },
                {
                    icon: "fas fa-graduation-cap",
                    title: "Peluang Beasiswa",
                    description: "Akses beasiswa studi ke universitas yang ada di Jepang",
                },
                {
                    icon: "fas fa-palette",
                    title: "Budaya Populer",
                    description: "Memahami budaya Jepang yang kaya dan populer",
                },
            ],
            packages: [
                {
                    name: "Fullday",
                    description: "Program intensif fullday dengan metode Kampung Inggris untuk belajar bahasa Jepang secara menyeluruh.",
                    duration: "1,5 - 3 bulan",
                    level: "N5 - N4",
                    options: [
                        "Kelas intensif 5x sehari",
                        "Metode Kampung Inggris",
                        "Materi JLPT N5 & N4",
                        "Percakapan sehari-hari",
                        "Garansi bisa mengulang gratis",
                    ],
                    highlight: "Program Unggulan",
                },
                {
                    name: "Privat",
                    description: "Kelas privat 1-on-1 dengan pengajar berpengalaman. Jadwal fleksibel dan materi disesuaikan.",
                    duration: "Fleksibel",
                    level: "Semua Level",
                    options: [
                        "Jadwal fleksibel",
                        "Materi disesuaikan kebutuhan",
                        "Fokus pada tujuan spesifik",
                        "Pengajar berpengalaman",
                        "Progress tracking",
                    ],
                    highlight: "",
                },
                {
                    name: "Online",
                    description: "Kelas online interaktif via Zoom. Dapat diakses dari mana saja dengan materi terstruktur.",
                    duration: "Fleksibel",
                    level: "Semua Level",
                    options: [
                        "Kelas via Zoom",
                        "Materi digital lengkap",
                        "Rekaman kelas tersedia",
                        "Akses dari mana saja",
                        "Pilihan privat atau grup kecil",
                    ],
                    highlight: "Flexible Learning",
                },
            ],
        },
        {
            id: "korea",
            name: "Korea",
            description: "Bahasa Korea semakin populer berkat gelombang K-Pop dan K-Drama. Pelajari bahasa ini untuk memahami budaya Korea secara mendalam.",
            level: "EPS-TOPIK",
            flagColor: "#0047A0",
            flag: "https://flagcdn.com/48x36/kr.png",
            icon: "fas fa-music",
            generalFeatures: [
                {
                    icon: "fas fa-film",
                    title: "Entertainment",
                    description: "Memahami K-Drama dan K-Pop tanpa subtitle",
                },
                {
                    icon: "fas fa-briefcase",
                    title: "Kerja di Korea",
                    description: "Program EPS untuk bekerja di Korea Selatan",
                },
                {
                    icon: "fas fa-utensils",
                    title: "Kuliner Korea",
                    description: "Memasak dan memahami makanan Korea",
                },
            ],
            packages: [
                {
                    name: "Fullday Program (Level 1-2) - 3 Bulan",
                    description: "Program komprehensif 3 bulan untuk pemula yang ingin menguasai bahasa Korea dari dasar hingga level dasar.",
                    duration: "3 bulan",
                    level: "Pemula ke Basic",
                    options: [
                        "Pengenalan dan penguasaan hangeul lengkap",
                        "Kosakata dasar sehari-hari",
                        "Percakapan dasar untuk pemula",
                    ],
                    highlight: "Paket Lengkap",
                },
                {
                    name: "Kelas Privat",
                    description: "Kelas privat dengan berbagai pilihan program sesuai kebutuhan dan tujuan belajar Anda.",
                    duration: "Fleksibel",
                    level: "Custom",
                    options: ["Privat Basic", "Privat EPS1 & EPS2", "Privat TOPIK"],
                    highlight: "",
                },
                {
                    name: "Kelas Online",
                    description: "Kelas online dengan berbagai level untuk belajar bahasa Korea dari mana saja.",
                    duration: "Fleksibel",
                    level: "Semua Level",
                    options: [
                        "Online Basic",
                        "Online A1, A2, B1, B2",
                        "Pilihan reguler atau privat",
                    ],
                    highlight: "",
                },
            ],
        },
        {
            id: "jerman",
            name: "Jerman",
            description: "Bahasa Jerman penting untuk pendidikan, penelitian, dan bisnis di Eropa. Banyak beasiswa tersedia untuk pelajar bahasa Jerman.",
            level: "Goethe-TestDaF-telc Deutsch",
            flagColor: "#000000",
            flag: "https://flagcdn.com/48x36/de.png",
            icon: "fas fa-briefcase",
            generalFeatures: [
                {
                    icon: "fas fa-university",
                    title: "Pendidikan Gratis",
                    description: "Akses pendidikan tinggi gratis di Jerman",
                },
                {
                    icon: "fas fa-flask",
                    title: "Riset & Teknologi",
                    description: "Peluang di bidang penelitian dan teknologi",
                },
                {
                    icon: "fas fa-euro-sign",
                    title: "Ekonomi Eropa",
                    description: "Peluang bisnis di pasar Eropa",
                },
            ],
            packages: [
                {
                    name: "Fullday Program",
                    description: "Program intensif bahasa Jerman dengan metode Kampung Inggris untuk pemula yang ingin menguasai bahasa Jerman dari dasar hingga level menengah (A1-B1).",
                    duration: "4 bulan",
                    level: "Pemula ke Intermediate",
                    options: [
                        "Kelas intensif 5 hari/minggu",
                        "Materi Goethe Institut A1-B1",
                        "Percakapan praktis sehari-hari",
                    ],
                    highlight: "Metode Kampung Inggris",
                },
                {
                    name: "Kelas Privat",
                    description: "Kelas privat bahasa Jerman dengan pengajar berpengalaman dan kurikulum yang disesuaikan dengan kebutuhan Anda.",
                    duration: "Fleksibel",
                    level: "Custom",
                    options: [
                        "Privat A1, A2, B1, B2, C1, C2",
                        "Privat persiapan TestDaF",
                        "Privat persiapan Goethe Zertifikat",
                        "Jadwal fleksibel sesuai kebutuhan",
                        "Kurikulum personalized",
                        "Fokus pada tujuan spesifik",
                    ],
                    highlight: "Pengajar Bersertifikat",
                },
                {
                    name: "Kelas Online",
                    description: "Kelas online bahasa Jerman dengan berbagai level untuk belajar dari mana saja dengan materi terstruktur.",
                    duration: "Fleksibel",
                    level: "Semua Level",
                    options: [
                        "Online A1, A2, B1, B2, C1, C2",
                        "Online persiapan TestDaF",
                        "Pilihan reguler atau privat",
                    ],
                    highlight: "Fleksibel Lokasi",
                },
            ],
        },
        {
            id: "inggris",
            name: "Inggris",
            description: "Bahasa Inggris sebagai bahasa internasional penting untuk komunikasi global, pendidikan, dan karir di perusahaan multinasional.",
            level: "TOEFL-IELTS-PTE",
            duration: "4-8 bulan",
            students: "3000+",
            flagColor: "#012169",
            flag: "https://flagcdn.com/48x36/gb.png",
            icon: "fas fa-globe",
            generalFeatures: [
                {
                    icon: "fas fa-plane",
                    title: "Global Access",
                    description: "Komunikasi di 53 negara penutur Inggris",
                },
                {
                    icon: "fas fa-laptop-code",
                    title: "Teknologi Digital",
                    description: "Akses konten teknologi dan digital global",
                },
                {
                    icon: "fas fa-network-wired",
                    title: "Networking",
                    description: "Jaringan profesional internasional",
                },
            ],
            packages: [
                {
                    name: "Kelas Privat",
                    description: "Kelas privat bahasa Inggris dengan pengajar berpengalaman dan kurikulum yang disesuaikan dengan kebutuhan spesifik Anda.",
                    duration: "Fleksibel",
                    level: "Custom",
                    options: [
                        "Privat IELTS/TOEFL Preparation",
                        "Privat Business English",
                        "Privat Conversation",
                    ],
                    highlight: "Personalized Learning",
                },
            ],
        },
    ],

    partners: [
        {
            name: "IWIP A",
            logo: "https://kursusbahasa.org/assets/img/partners/logo-iwip.webp",
        },
        {
            name: "OSS",
            logo: "assets/img/partners/logo-oss.webp",
        },
        {
            name: "Harita Nickel",
            logo: "assets/img/partners/logo-harita-nickel.webp",
        },
        {
            name: "IMIP",
            logo: "assets/img/partners/logo-imip.webp",
        },
        {
            name: "CCEPC",
            logo: "assets/img/partners/logo-ccepc.webp",
        },
        {
            name: "Golden Textil",
            logo: "assets/img/partners/logo-golden-tekstil-indonesia.webp",
        },
    ],

    features: [
        {
            title: "Pengajar Bersertifikat",
            description: "Pengajar kami memiliki sertifikasi internasional dan pengalaman mengajar minimal 2 tahun.",
            icon: "fas fa-user-tie",
        },
        {
            title: "Metode Kampung Inggris",
            description: "Menggunakan metode intensif ala Kampung Inggris Pare yang terbukti efektif.",
            icon: "fas fa-lightbulb",
        },
        {
            title: "Kelas Kecil",
            description: "12-15 siswa per kelas untuk pendampingan yang lebih efektif dari pengajar.",
            icon: "fas fa-users",
        },
        {
            title: "Aktivitas Praktik",
            description: "Setiap hari ada sesi praktik dengan tema berbeda untuk melatih percakapan.",
            icon: "fas fa-comments",
        },
        {
            title: "Komunitas Belajar",
            description: "Bergabung dengan komunitas belajar yang solid dan saling mendukung.",
            icon: "fas fa-shield-alt",
        },
        {
            title: "Garansi Bisa",
            description: "Garansi mengulang gratis jika belum lancar setelah menyelesaikan program.",
            icon: "fas fa-award",
        },
    ],
};

// Initialize the application - VERSI DIPERBAIKI
function initializeHome() {
    // Cek apakah semua elemen yang diperlukan sudah ada
    const checkElements = setInterval(() => {
        const spinningText = document.getElementById("spinningText");
        const languageTab = document.getElementById("languageTab");
        const languageTabContent = document.getElementById("languageTabContent");
        const featuresContainer = document.getElementById("featuresContainer");

        // Jika semua elemen utama sudah tersedia, jalankan inisialisasi
        if (spinningText && languageTab && languageTabContent && featuresContainer) {
            clearInterval(checkElements);

            console.log("Inisialisasi home section dimulai...");

            // Jalankan semua fungsi inisialisasi
            try {
                initializeSpinningText();
                console.log("Spinning text initialized");
            } catch (e) {
                console.error("Error initializing spinning text:", e);
            }

            try {
                initializePartnerCarousel();
                console.log("Partner carousel initialized");
            } catch (e) {
                console.error("Error initializing partner carousel:", e);
            }

            try {
                initializePartnerMobileCarousel();
                console.log("Partner mobile carousel initialized");
            } catch (e) {
                console.error("Error initializing partner mobile carousel:", e);
            }

            try {
                initializeLanguageTabs();
                console.log("Language tabs initialized");
            } catch (e) {
                console.error("Error initializing language tabs:", e);
            }

            try {
                initializeLanguageCards();
                console.log("Language cards initialized");
            } catch (e) {
                console.error("Error initializing language cards:", e);
            }

            try {
                initializeFeatureCards();
                console.log("Feature cards initialized");
            } catch (e) {
                console.error("Error initializing feature cards:", e);
            }

            console.log("Home section berhasil diinisialisasi");
        }
    }, 100); // Cek setiap 100ms
}

// Tunggu sampai DOM sepenuhnya dimuat
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");
    initializeHome();
});

// Fallback: Juga jalankan ketika window selesai dimuat
window.addEventListener("load", function () {
    console.log("Window fully loaded");
    // Cek apakah inisialisasi sudah berjalan
    const tabsExist = document.querySelectorAll('#languageTab .nav-item').length > 0;
    if (!tabsExist) {
        console.log("Tabs not found, re-initializing...");
        initializeHome();
    }
});

// IMPROVED: Spinning text with smooth zoom in-fade out animation
function initializeSpinningText() {
    const spinningText = document.getElementById("spinningText");
    if (!spinningText) return;

    const languages = [
        "Bahasa Mandarin",
        "Bahasa Jepang",
        "Bahasa Korea",
        "Bahasa Jerman",
        "Bahasa Inggris",
    ];
    let currentIndex = 0;

    // Function to change text with animation
    function changeText() {
        // Start fade out animation
        spinningText.classList.remove("text-zoom-in");
        spinningText.classList.add("text-fade-out");

        // Wait for fade out to complete, then change text
        setTimeout(() => {
            currentIndex = (currentIndex + 1) % languages.length;
            spinningText.textContent = languages[currentIndex];

            // Remove fade out, add zoom in
            spinningText.classList.remove("text-fade-out");
            spinningText.classList.add("text-zoom-in");
        }, 700); // Match this with CSS animation duration (0.7s)
    }

    // Start animation after page loads
    setTimeout(() => {
        // Start animation cycle
        setInterval(changeText, 3000);
    }, 1000);
}

// Initialize partner carousel (desktop - 3 logos per slide)
function initializePartnerCarousel() {
    const carouselInner = document.querySelector("#partnerCarousel .carousel-inner");
    if (!carouselInner) return;

    const partners = appData.partners;

    // Clear existing content
    carouselInner.innerHTML = '';

    // Create carousel items (grouped in pairs for display)
    for (let i = 0; i < partners.length; i += 3) {
        const isActive = i === 0 ? "active" : "";
        const partnerGroup = partners.slice(i, i + 3);

        const carouselItem = document.createElement("div");
        carouselItem.className = `carousel-item ${isActive}`;

        const rowDiv = document.createElement("div");
        rowDiv.className = "row align-items-center justify-content-center";

        partnerGroup.forEach((partner) => {
            const colDiv = document.createElement("div");
            colDiv.className = "col-md-4 text-center";

            colDiv.innerHTML = `
                <div class="d-inline-block p-3">
                    <div class="carousel-logo d-flex align-items-center justify-content-center bg-white rounded p-3">
                        <img src="${partner.logo}" alt="Partner ${partner.name} - Kursus Bahasa Kampung Inggris Pare" width="100" height="100" loading="lazy">
                    </div>
                    <p class="mt-2 small">${partner.name}</p>
                </div>
            `;

            rowDiv.appendChild(colDiv);
        });

        carouselItem.appendChild(rowDiv);
        carouselInner.appendChild(carouselItem);
    }

    // Add carousel indicators
    const carouselElement = document.getElementById("partnerCarousel");
    const existingIndicators = carouselElement.querySelector(".carousel-indicators");
    if (existingIndicators) {
        existingIndicators.remove();
    }

    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators";
    indicatorsContainer.style.position = "relative";
    indicatorsContainer.style.marginTop = "1rem";

    const itemsCount = Math.ceil(partners.length / 3);
    for (let i = 0; i < itemsCount; i++) {
        const button = document.createElement("button");
        button.type = "button";
        button.setAttribute("data-bs-target", "#partnerCarousel");
        button.setAttribute("data-bs-slide-to", i.toString());
        button.setAttribute("aria-label", `Slide ${i + 1}`);
        if (i === 0) {
            button.className = "active";
            button.setAttribute("aria-current", "true");
        }
        indicatorsContainer.appendChild(button);
    }

    carouselElement.appendChild(indicatorsContainer);

    // Add auto-rotation to carousel
    carouselElement.setAttribute("data-bs-ride", "carousel");
    carouselElement.setAttribute("data-bs-interval", "500");
}

// Initialize partner mobile carousel (1 logo per slide)
function initializePartnerMobileCarousel() {
    const carouselInner = document.querySelector("#partnerMobileCarousel .carousel-inner");
    if (!carouselInner) return;

    const partners = appData.partners;

    // Clear existing content
    carouselInner.innerHTML = '';

    partners.forEach((partner, index) => {
        const isActive = index === 0 ? "active" : "";

        const carouselItem = document.createElement("div");
        carouselItem.className = `carousel-item ${isActive}`;

        const colDiv = document.createElement("div");
        colDiv.className = "col-12 text-center";

        colDiv.innerHTML = `
            <div class="d-inline-block p-3">
                <div class="carousel-logo d-flex align-items-center justify-content-center bg-white rounded p-3">
                    <img src="${partner.logo}" alt="Partner ${partner.name} - Kursus Bahasa Kampung Inggris" width="100" height="100" loading="lazy">
                </div>
                <p class="mt-2 small">${partner.name}</p>
            </div>`;

        carouselItem.appendChild(colDiv);
        carouselInner.appendChild(carouselItem);
    });

    // Add indicators for mobile carousel
    const carouselElement = document.getElementById("partnerMobileCarousel");
    const existingIndicators = carouselElement.querySelector(".carousel-indicators");
    if (existingIndicators) {
        existingIndicators.remove();
    }

    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators";
    indicatorsContainer.style.position = "relative";
    indicatorsContainer.style.marginTop = "1rem";

    partners.forEach((_, index) => {
        const button = document.createElement("button");
        button.type = "button";
        button.setAttribute("data-bs-target", "#partnerMobileCarousel");
        button.setAttribute("data-bs-slide-to", index.toString());
        button.setAttribute("aria-label", `Slide ${index + 1}`);
        if (index === 0) {
            button.className = "active";
            button.setAttribute("aria-current", "true");
        }
        indicatorsContainer.appendChild(button);
    });

    carouselElement.appendChild(indicatorsContainer);

    // Add auto-rotation to carousel
    carouselElement.setAttribute("data-bs-ride", "carousel");
    carouselElement.setAttribute("data-bs-interval", "500");
}

// Initialize language tabs
function initializeLanguageTabs() {
    const tabsContainer = document.getElementById("languageTab");
    if (!tabsContainer) return;

    const languages = appData.languages;

    // Clear existing tabs
    tabsContainer.innerHTML = '';

    languages.forEach((language, index) => {
        const li = document.createElement("li");
        li.className = "nav-item";
        li.role = "presentation";

        const button = document.createElement("button");
        button.className = `nav-link ${index === 0 ? "active" : ""}`;
        button.id = `${language.id}-tab`;
        button.setAttribute("data-bs-toggle", "tab");
        button.setAttribute("data-bs-target", `#${language.id}`);
        button.type = "button";
        button.setAttribute("role", "tab");
        button.setAttribute("aria-controls", language.id);
        button.setAttribute("aria-selected", index === 0 ? "true" : "false");
        button.textContent = language.name;
        button.setAttribute("title", `Kursus Bahasa ${language.name} di Kampung Inggris Pare`);

        li.appendChild(button);
        tabsContainer.appendChild(li);
    });

    console.log(`Created ${languages.length} language tabs`);
}

// Helper function untuk membuat card paket
function createPackageCardHTML(pkg, language) {
    // Generate HTML untuk opsi-opsi program
    let optionsHtml = "";
    if (pkg.options && pkg.options.length > 0) {
        pkg.options.forEach((option) => {
            optionsHtml += `
                <li class="package-option-item">
                    <i class="fas fa-check"></i>
                    <span>${option}</span>
                </li>`;
        });
    }

    // Badge untuk highlight jika ada
    const highlightBadge = pkg.highlight
        ? `<span class="meta-badge highlight">${pkg.highlight}</span>`
        : "";

    // URL untuk setiap bahasa berdasarkan ID
    const languageUrlMap = {
        mandarin: "program/mandarin",
        jepang: "program/jepang",
        korea: "program/korea",
        jerman: "program/jerman",
        inggris: "program/inggris",
    };

    const languageUrl = languageUrlMap[language.id] || "#";

    return `
        <div class="package-card">
            <div class="package-card-body">
                <h5 class="package-card-title">${pkg.name}</h5>
                <div class="package-card-meta">
                    <span class="meta-badge">${pkg.duration}</span>
                    <span class="meta-badge">${pkg.level || "All Level"}</span>
                    ${highlightBadge}
                </div>
                <p class="package-card-description">${pkg.description}</p>
                <ul class="package-options-list">
                    ${optionsHtml}
                </ul>
                <div class="package-card-footer">
                    <a href="${languageUrl}" 
                       class="btn btn-package-detail" 
                       title="Detail Program Kursus Bahasa ${language.name}">
                        <span>Detail</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    `;
}

// Initialize language cards dengan desain paket sederhana
function initializeLanguageCards() {
    const tabContent = document.getElementById("languageTabContent");
    if (!tabContent) return;

    const languages = appData.languages;

    // Clear existing content
    tabContent.innerHTML = '';

    // URL mapping untuk tombol Detail Program
    const languageUrlMap = {
        mandarin: "program/mandarin",
        jepang: "program/jepang",
        korea: "program/korea",
        jerman: "program/jerman",
        inggris: "program/inggris",
    };

    languages.forEach((language, index) => {
        const tabPane = document.createElement("div");
        tabPane.className = `tab-pane fade ${index === 0 ? "show active" : ""}`;
        tabPane.id = language.id;
        tabPane.setAttribute("role", "tabpanel");
        tabPane.setAttribute("aria-labelledby", `${language.id}-tab`);

        // Baris pertama: Deskripsi bahasa dan card CTA
        const row1 = document.createElement("div");
        row1.className = "row g-4";

        // Kolom untuk deskripsi bahasa
        const detailCol = document.createElement("div");
        detailCol.className = "col-lg-8";

        const detailCard = document.createElement("div");
        detailCard.className = "card h-100 border-yellow";

        // Buat HTML untuk general features
        let generalFeaturesHTML = "";
        if (language.generalFeatures && language.generalFeatures.length > 0) {
            generalFeaturesHTML = `
                <div class="general-features-section">
                    <div class="row">
                        ${language.generalFeatures.map((feature) => `
                            <div class="col-md-4 text-center mb-3">
                                <div class="general-feature-item">
                                    <i class="${feature.icon}"></i>
                                    <h6 class="fw-bold">${feature.title}</h6>
                                    <p class="small">${feature.description}</p>
                                </div>
                            </div>
                        `).join("")}
                    </div>
                </div>
            `;
        }

        detailCard.innerHTML = `
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center me-3">
                        <img src="${language.flag}" alt="Bendera ${language.name} - Kursus Bahasa di Kampung Inggris" width="48" height="36" loading="lazy">
                    </div>
                    <div>
                        <h3 class="card-title mb-0">${language.name}</h3>
                        <p class="badge bg-primary rounded-pill">${language.level}</p>
                    </div>
                </div>
                ${generalFeaturesHTML}
                <p class="card-text">${language.description}</p>
            </div>`;

        detailCol.appendChild(detailCard);
        row1.appendChild(detailCol);

        // Kolom untuk CTA
        const ctaCol = document.createElement("div");
        ctaCol.className = "col-lg-4";

        const ctaCard = document.createElement("div");
        ctaCard.className = "card h-100 bg-black text-white";
        ctaCard.innerHTML = `
            <div class="card-body d-flex flex-column">
                <h4 class="card-title">Mulai Belajar ${language.name}</h4>
                <p class="card-text flex-grow-1">Daftar sekarang dan amankan kuota untuk pendaftaran bulan ini.</p>
                <div class="mt-auto">
                    <div class="d-grid gap-2">
                        <!-- Tombol Detail Program -->
                        <a class="btn btn-primary-yellow mb-2" href="${languageUrlMap[language.id]}" title="Detail Program Kursus Bahasa ${language.name}">Detail Program</a>
                        <!-- Tombol Chat Admin -->
                        <a class="btn btn-outline-yellow" href="https://api.whatsapp.com/send?phone=6285810310950&text=Hai%2C%20saya%20mau%20konsultasi%20mengenai%20kursus%20bahasa%20di%20SOS%20Course%20and%20Training" target="_blank" title="Konsultasi Kursus Bahasa ${language.name}">Chat Admin</a>
                    </div>
                    <p class="small text-center mt-3">
                        <i class="fas fa-info-circle me-1"></i> Kelas tersedia online & offline
                    </p>
                </div>
            </div>
        `;

        ctaCol.appendChild(ctaCard);
        row1.appendChild(ctaCol);

        tabPane.appendChild(row1);

        // Baris kedua: Card-card paket kursus (hanya untuk bahasa yang memiliki paket)
        if (language.packages && language.packages.length > 0) {
            const row2 = document.createElement("div");
            row2.className = "row mt-4";

            const packagesCol = document.createElement("div");
            packagesCol.className = "col-12";

            // Header untuk paket
            const packagesHeader = document.createElement("div");
            packagesHeader.className = "d-flex justify-content-between align-items-center mb-3";
            packagesHeader.innerHTML = `
                <h4 class="fw-bold mb-0">Paket Kursus ${language.name}</h4>
                <span class="badge bg-primary rounded-pill">${language.packages.length} Paket Tersedia</span>
            `;
            packagesCol.appendChild(packagesHeader);

            // ========== VERSI DESKTOP (GRID) ==========
            const desktopRow = document.createElement("div");
            desktopRow.className = "row g-3 packages-desktop";

            language.packages.forEach((pkg) => {
                const packageCol = document.createElement("div");
                packageCol.className = "col-md-6 col-lg-4";
                packageCol.innerHTML = createPackageCardHTML(pkg, language);
                desktopRow.appendChild(packageCol);
            });

            packagesCol.appendChild(desktopRow);

            // ========== VERSI MOBILE (CAROUSEL) ==========
            const mobileCarousel = document.createElement("div");
            mobileCarousel.className = "packages-mobile";

            // Buat carousel container
            const carouselId = `carousel-${language.id}`;
            let carouselItems = "";
            let carouselIndicators = "";

            language.packages.forEach((pkg, pkgIndex) => {
                const isActive = pkgIndex === 0 ? "active" : "";
                carouselItems += `
                    <div class="carousel-item ${isActive}">
                        <div class="d-flex justify-content-center px-2">
                            ${createPackageCardHTML(pkg, language)}
                        </div>
                    </div>
                `;

                carouselIndicators += `
                    <button type="button" data-bs-target="#${carouselId}" 
                        data-bs-slide-to="${pkgIndex}" 
                        class="${isActive}" 
                        aria-label="Slide ${pkgIndex + 1}"></button>
                `;
            });

            mobileCarousel.innerHTML = `
                <div id="${carouselId}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        ${carouselItems}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <div class="carousel-indicators">
                        ${carouselIndicators}
                    </div>
                </div>
            `;

            packagesCol.appendChild(mobileCarousel);

            row2.appendChild(packagesCol);
            tabPane.appendChild(row2);
        } else {
            // Untuk bahasa yang belum ada paket, tampilkan pesan
            const row2 = document.createElement("div");
            row2.className = "row mt-4";

            const messageCol = document.createElement("div");
            messageCol.className = "col-12";

            messageCol.innerHTML = `
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Paket Kursus ${language.name}</h5>
                            <p class="mb-0">Informasi paket kursus untuk bahasa ${language.name} sedang dalam persiapan. Hubungi kami untuk informasi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
            `;

            row2.appendChild(messageCol);
            tabPane.appendChild(row2);
        }

        tabContent.appendChild(tabPane);
    });

    console.log(`Created language cards for ${languages.length} languages`);
}

// Initialize feature cards
function initializeFeatureCards() {
    const featuresContainer = document.getElementById("featuresContainer");
    if (!featuresContainer) return;

    const features = appData.features;

    // Clear existing content
    featuresContainer.innerHTML = '';

    features.forEach((feature) => {
        const col = document.createElement("div");
        col.className = "col-md-6 col-lg-4 mb-4";

        const card = document.createElement("div");
        card.className = "card h-100 language-card";
        card.innerHTML = `
            <div class="card-body text-center p-4">
                <div class="feature-icon">
                    <i class="${feature.icon}"></i>
                </div>
                <h4 class="card-title">${feature.title}</h4>
                <p class="card-text">${feature.description}</p>
            </div>
        `;

        col.appendChild(card);
        featuresContainer.appendChild(col);
    });

    console.log(`Created ${features.length} feature cards`);
}