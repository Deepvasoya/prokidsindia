<?php
    $pk_name     = $this->session->userdata('name');
    $pk_first    = $pk_name ? ucwords(strtolower(strtok(trim($pk_name), ' '))) : 'there';
    $pk_logo     = base_url('uploads/site_data/' . $site_Details['0']['site_logo']);
    $pk_current  = $this->session->userdata('batch_id');
    $pk_palettes = array('mc-pink', 'mc-orange', 'mc-teal', 'mc-violet', 'mc-green', 'mc-blue');
?>
<style>
.mc-wrap { padding: 30px 15px 40px; }
.mc-hero {
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;
    padding: 28px 32px; margin-bottom: 30px; border-radius: 24px; color: #fff;
    background: linear-gradient(120deg, #5b6cff 0%, #8f7bff 55%, #ff8fb1 100%);
    box-shadow: 0 14px 34px rgba(91, 108, 255, .28);
}
.mc-hero:before, .mc-hero:after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.14); }
.mc-hero:before { width: 220px; height: 220px; right: -60px; top: -90px; }
.mc-hero:after { width: 130px; height: 130px; right: 200px; bottom: -70px; background: rgba(255,255,255,.10); }
.mc-hero h2 { color: #fff; font-size: 30px; font-weight: 600; margin: 0 0 6px; position: relative; z-index: 1; }
.mc-hero p { margin: 0; font-size: 16px; opacity: .92; position: relative; z-index: 1; }
.mc-hero-count {
    position: relative; z-index: 1; padding: 12px 22px; border-radius: 18px;
    background: rgba(255,255,255,.95); color: #1f2a4d; text-align: center; box-shadow: 0 6px 16px rgba(31,42,77,.12);
}
.mc-hero-count strong { display: block; font-family: var(--pk-font-head, inherit); font-size: 30px; line-height: 1; color: #5b6cff; }
.mc-hero-count span { font-size: 13px; font-weight: 700; color: #7a84a3; }
.mc-wave { display: inline-block; animation: mc-wave 2.4s ease-in-out infinite; transform-origin: 70% 70%; }
@keyframes mc-wave { 0%,60%,100% { transform: rotate(0); } 10%,30% { transform: rotate(16deg); } 20%,40% { transform: rotate(-8deg); } }

.mc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 24px; }
.mc-card {
    --c: #5b6cff; --soft: #eef0ff;
    position: relative; display: flex; flex-direction: column; overflow: hidden;
    border-radius: 24px; background: #fff; color: #1f2a4d !important; text-decoration: none !important;
    box-shadow: 0 8px 22px rgba(31,42,77,.07); border: 2px solid transparent;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
.mc-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(31,42,77,.14); border-color: var(--c); }
.mc-card.mc-pink   { --c: #ff5c8a; --soft: #ffe6ee; }
.mc-card.mc-orange { --c: #ff9f1a; --soft: #fff3dc; }
.mc-card.mc-teal   { --c: #22b8cf; --soft: #e2f7fb; }
.mc-card.mc-violet { --c: #7c5cff; --soft: #efeaff; }
.mc-card.mc-green  { --c: #22c58b; --soft: #dff7ee; }
.mc-card.mc-blue   { --c: #5b6cff; --soft: #eef0ff; }
.mc-cover {
    position: relative; height: 150px; display: flex; align-items: center; justify-content: center;
    background:
        radial-gradient(circle at 15% 20%, rgba(255,255,255,.7) 0 26px, transparent 27px),
        radial-gradient(circle at 88% 78%, rgba(255,255,255,.55) 0 38px, transparent 39px),
        var(--soft);
}
.mc-cover img {
    max-width: 70%; max-height: 110px; object-fit: contain; border-radius: 16px;
    filter: drop-shadow(0 8px 14px rgba(31,42,77,.12)); transition: transform .25s ease;
}
.mc-card:hover .mc-cover img { transform: scale(1.06) rotate(-2deg); }
.mc-badge {
    position: absolute; top: 14px; left: 14px; padding: 5px 12px; border-radius: 999px;
    background: #22c58b; color: #fff; font-size: 12px; font-weight: 800; box-shadow: 0 4px 10px rgba(34,197,139,.35);
}
.mc-body { padding: 18px 20px 20px; display: flex; flex-direction: column; gap: 14px; flex: 1; }
.mc-title { font-family: var(--pk-font-head, inherit); font-size: 21px; font-weight: 600; line-height: 1.25; margin: 0; color: #1f2a4d; }
.mc-cta {
    margin-top: auto; display: flex; align-items: center; justify-content: space-between;
    padding: 11px 16px; border-radius: 14px; background: var(--soft); color: var(--c); font-weight: 800; font-size: 15px;
    transition: background .2s ease, color .2s ease;
}
.mc-cta .mc-arrow {
    width: 30px; height: 30px; border-radius: 50%; background: #fff; display: inline-flex; align-items: center; justify-content: center;
    transition: transform .2s ease;
}
.mc-card:hover .mc-cta { background: var(--c); color: #fff; }
.mc-card:hover .mc-cta .mc-arrow { color: var(--c); transform: translateX(4px); }
.mc-card.is-current { border-color: #22c58b; }

.mc-empty { text-align: center; background: #fff; border-radius: 24px; padding: 50px 20px; border: 2px dashed #e3e6f3; }
.mc-empty .mc-empty-icon { font-size: 50px; }
.mc-empty p { color: #7a84a3; font-size: 16px; margin: 10px 0 0; }

@media (max-width: 767px) {
    .mc-wrap { padding: 16px 0 30px; }
    .mc-hero { padding: 22px 20px; }
    .mc-hero h2 { font-size: 23px; }
    .mc-grid { grid-template-columns: 1fr; gap: 16px; }
}
@media (prefers-reduced-motion: reduce) { .mc-wave { animation: none; } }
</style>

<section class="edu_admin_content">
    <div class="mc-wrap">
        <div class="mc-hero">
            <div>
                <h2>Hi <?php echo html_escape($pk_first); ?>! <span class="mc-wave">&#128075;</span></h2>
                <p>Pick a course and let's start learning something fun today.</p>
            </div>
            <?php if (!empty($batches)) { ?>
            <div class="mc-hero-count">
                <strong><?php echo count($batches); ?></strong>
                <span><?php echo count($batches) == 1 ? 'Course' : 'Courses'; ?></span>
            </div>
            <?php } ?>
        </div>

        <?php if (!empty($batches)) { ?>
            <div class="mc-grid">
                <?php foreach ($batches as $i => $value) {
                    $is_current = ($value['batch_id'] == $pk_current);
                    $image = !empty($value['batch_image']) ? base_url('uploads/batch_image/' . $value['batch_image']) : $pk_logo;
                ?>
                <a class="mc-card <?php echo $pk_palettes[$i % count($pk_palettes)]; ?> <?php echo $is_current ? 'is-current course_active' : ''; ?>"
                   href="<?php echo base_url('student/select-course/' . $value['batch_id']); ?>">
                    <div class="mc-cover">
                        <?php if ($is_current) { ?><span class="mc-badge">&#9733; Current course</span><?php } ?>
                        <img src="<?php echo $image; ?>" alt="<?php echo html_escape($value['batch_name']); ?>" loading="lazy">
                    </div>
                    <div class="mc-body">
                        <h3 class="mc-title"><?php echo html_escape($value['batch_name']); ?></h3>
                        <div class="mc-cta">
                            <span><?php echo $is_current ? 'Continue learning' : 'Start learning'; ?></span>
                            <span class="mc-arrow">&rarr;</span>
                        </div>
                    </div>
                </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="mc-empty">
                <div class="mc-empty-icon">&#127890;</div>
                <p><?php echo html_escape($this->common->languageTranslator('ltr_Course_purchase')); ?></p>
            </div>
        <?php } ?>
    </div>
</section>
