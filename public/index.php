<?php include_once "../includes/header.php"; ?>

<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-text">
            <p class="eyebrow">WELCOME TO LORD BUDDHA SCHOOL</p>
            <h1>Inspired Learning. Grounded in Values.</h1>
            <p class="hero-sub">
                At Lord Buddha School, students experience rigorous academics, caring mentorship,
                and a culture rooted in peace, compassion and curiosity.
            </p>
            <div class="hero-actions">
                <a href="#admissions" class="btn btn-primary">Explore Admissions</a>
                <a href="/schoolms/public/login.php" class="btn btn-outline">Parent / Student Portal</a>
            </div>
        </div>
        <div class="hero-panels">
            <div class="hero-stat-card">
                <span class="stat-label">Average Class Size</span>
                <span class="stat-value">25</span>
            </div>
            <div class="hero-stat-card">
                <span class="stat-label">Student–Teacher Ratio</span>
                <span class="stat-value">15:1</span>
            </div>
            <div class="hero-stat-card">
                <span class="stat-label">Grades</span>
                <span class="stat-value">Nursery–XII</span>
            </div>
        </div>
    </div>
</section>

<section id="about" class="section">
    <header class="section-header">
        <p class="eyebrow">ABOUT</p>
        <h2>Rooted in Wisdom, Ready for Tomorrow</h2>
        <p>
            Lord Buddha School blends strong academic preparation with character education,
            helping students become thoughtful citizens and resilient learners.
        </p>
    </header>
    <div class="grid-3">
        <article class="info-card">
            <h3>Holistic Education</h3>
            <p>
                We focus on intellectual, emotional, physical and ethical growth through a balanced curriculum
                that values both knowledge and compassion.
            </p>
        </article>
        <article class="info-card">
            <h3>Safe, Caring Community</h3>
            <p>
                Small class sizes and dedicated teachers ensure every child is known, supported and challenged
                in a safe learning environment.
            </p>
        </article>
        <article class="info-card">
            <h3>Future-Ready Skills</h3>
            <p>
                Technology, language, arts and sports are integrated thoughtfully, so students can explore interests
                and build real-world skills.
            </p>
        </article>
    </div>
</section>

<section id="academics" class="section section-alt">
    <header class="section-header">
        <p class="eyebrow">ACADEMICS</p>
        <h2>Academic Excellence at Every Stage</h2>
        <p>
            Our academic programme is structured into developmentally appropriate divisions, all aligned with
            national standards and best practices in teaching.
        </p>
    </header>
    <div class="grid-4">
        <div class="academic-card">
            <h3>Primary School</h3>
            <p>Play-based early learning with a strong foundation in literacy, numeracy and social skills.</p>
        </div>
        <div class="academic-card">
            <h3>Upper Primary</h3>
            <p>Concept-driven learning in languages, mathematics, science and social science.</p>
        </div>
        <div class="academic-card">
            <h3>Middle School</h3>
            <p>Deeper subject exploration, critical thinking, projects and technology integration.</p>
        </div>
        <div class="academic-card">
            <h3>Secondary &amp; Senior Secondary</h3>
            <p>Board exam preparation, career guidance and opportunities for leadership and research.</p>
        </div>
    </div>
</section>

<section id="life" class="section">
    <header class="section-header">
        <p class="eyebrow">CAMPUS LIFE</p>
        <h2>Life at Lord Buddha School</h2>
        <p>
            Beyond classrooms, students engage in sports, visual &amp; performing arts, clubs and community service.
        </p>
    </header>
    <div class="grid-3">
        <div class="life-card">
            <h3>Sports &amp; Fitness</h3>
            <p>Regular sports periods, inter-house competitions and coaching in selected games.</p>
        </div>
        <div class="life-card">
            <h3>Arts &amp; Culture</h3>
            <p>Music, dance, theatre and visual arts help students discover and express their talents.</p>
        </div>
        <div class="life-card">
            <h3>Community &amp; Service</h3>
            <p>Value-based assemblies, outreach projects and celebrations that build empathy and gratitude.</p>
        </div>
    </div>
</section>

<section id="admissions" class="section section-alt two-col">
    <div>
        <header class="section-header align-left">
            <p class="eyebrow">ADMISSIONS</p>
            <h2>Join the Lord Buddha School Community</h2>
            <p>
                We welcome families who seek a nurturing, academically strong and values-driven environment
                for their children.
            </p>
        </header>
        <ul class="bullets">
            <li>Nursery to Class XII admissions</li>
            <li>Transparent process with clear timelines</li>
            <li>Scholarships or concessions (as per school policy)</li>
        </ul>
    </div>
    <div class="card card-form">
        <h3>Admission Enquiry</h3>
        <p>Share your details and our team will connect with you.</p>
        <form>
            <label>Parent Name</label>
            <input type="text" placeholder="Full Name" required>
            <label>Contact Number</label>
            <input type="tel" placeholder="+91-" required>
            <label>Student Class Applying For</label>
            <input type="text" placeholder="e.g. Class VI" required>
            <label>Email</label>
            <input type="email" placeholder="you@example.com">
            <button type="submit" class="btn btn-primary full">Submit Enquiry</button>
        </form>
    </div>
</section>

<section id="notices" class="section">
    <header class="section-header">
        <p class="eyebrow">NOTICES</p>
        <h2>Latest Notices &amp; Announcements</h2>
        <p>Key updates for parents and students. Portal users will see more details after login.</p>
    </header>
    <div class="card notices-list">
        <p>This section will show latest notices from the school management system.</p>
        <p>After you set up the database and log in as Admin, you can create notices that appear here.</p>
        <a href="/schoolms/public/login.php" class="btn btn-outline" style="margin-top:1rem;">Go to Portal</a>
    </div>
</section>

<?php include_once "../includes/footer.php"; ?>
