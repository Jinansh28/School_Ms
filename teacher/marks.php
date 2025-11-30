<?php
require_once "../includes/auth.php";
require_role('teacher');
include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">TEACHER &middot; MARKS</p>
        <h2>Enter Marks</h2>
        <p>
            In this basic version, exam creation and mark entry are handled via the Admin &gt; Exams &amp; Marks module.
            You can coordinate with the admin to have marks entry assigned to you or extended here.
        </p>
    </header>
    <div class="card">
        <p style="font-size:0.9rem;color:#6b7280;">
            For many schools, teachers directly enter marks. You can enhance this page later by filtering exams
            and subjects assigned to you and then reusing the logic from <code>admin/exam_marks.php</code>.
        </p>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
