<?php
    $media_url = function ($path) { return $path ? base_url($path) : ''; };
    $media_tag = function ($kind, $item) use ($media_url) {
        $html = '';
        if ($kind === 'image') { $html .= '<img src="' . $media_url($item['media']) . '" alt="" loading="lazy">'; }
        elseif ($kind === 'audio') { $html .= '<audio src="' . $media_url($item['media']) . '" controls preload="none"></audio>'; }
        elseif ($kind === 'video') { $html .= '<video src="' . $media_url($item['media']) . '" controls preload="none"></video>'; }
        if ($item['text'] !== '') { $html .= '<div>' . html_escape($item['text']) . '</div>'; }
        return $html;
    };
    $type_labels = array('text' => 'Text', 'image' => 'Picture', 'audio' => 'Audio', 'video' => 'Video', 'none' => 'Text');
    $total_marks = 0;
    foreach ($questions as $q) { if ($q['status']) { $total_marks += $q['marks']; } }
    $back_url = $this->session->userdata('role') == 3 ? base_url('teacher/video-manage') : base_url('admin/video-manage');
?>
<style>
.va-wrap { padding: 30px 15px; }
.va-back { display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: var(--pk-primary, #5b6cff); margin-bottom: 16px; }
.va-back:hover { text-decoration: none; transform: translateX(-3px); }
.va-hero { display: flex; gap: 24px; flex-wrap: wrap; align-items: stretch; background: #fff; border-radius: 22px; padding: 20px; box-shadow: 0 8px 22px rgba(31,42,77,.07); margin-bottom: 26px; }
.va-hero-video { flex: 0 0 360px; max-width: 100%; }
.va-hero-video video { width: 100%; aspect-ratio: 16/9; border-radius: 16px; background: #0f172a; display: block; }
.va-time-btn { margin-top: 10px; font-size: 13px; font-weight: 700; border: 0; background: var(--pk-primary-50, #eef0ff); color: var(--pk-primary, #5b6cff); padding: 7px 14px; border-radius: 999px; cursor: pointer; }
.va-hero-info { flex: 1 1 320px; display: flex; flex-direction: column; justify-content: center; }
.va-hero-info h2 { font-size: 26px; margin: 0 0 10px; }
.va-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
.va-chip { padding: 5px 12px; border-radius: 999px; font-size: 13px; font-weight: 700; background: #f1f3fb; color: #3f4a6b; }
.va-stats { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; }
.va-stat { padding: 12px 18px; border-radius: 16px; min-width: 120px; }
.va-stat strong { display: block; font-family: var(--pk-font-head, inherit); font-size: 26px; line-height: 1.1; }
.va-stat span { font-size: 13px; font-weight: 700; color: #7a84a3; }
.va-stat.va-blue { background: #eef0ff; } .va-stat.va-blue strong { color: #5b6cff; }
.va-stat.va-orange { background: #fff3dc; } .va-stat.va-orange strong { color: #f08a00; }
.va-stat.va-green { background: #dff7ee; } .va-stat.va-green strong { color: #16a374; }
.va-add-btn { align-self: flex-start; }
.va-hero-actions { display: flex; flex-wrap: wrap; gap: 10px; }
.va-intro-btn { background: #fff3dc !important; color: #b4610a !important; border: 2px solid #ffe2ad !important; box-shadow: none !important; font-weight: 700; }
.va-intro-btn:hover { background: #ffe9c2 !important; }
.va-intro-card { display: flex; gap: 16px; margin-bottom: 18px; padding: 18px 20px; border-radius: 20px; background: linear-gradient(120deg, #fff8ec, #fff); border: 2px dashed #ffe2ad; }
.va-intro-card-icon { flex: 0 0 44px; height: 44px; border-radius: 14px; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 2px 6px rgba(31,42,77,.06); }
.va-intro-card-body { flex: 1; min-width: 0; }
.va-intro-text { color: #3f4a6b; font-weight: 600; line-height: 1.5; }
.va-dialog.va-dialog-sm { max-width: min(760px, calc(100vw - 32px)); }

.va-empty { text-align: center; background: #fff; border-radius: 22px; padding: 50px 20px; border: 2px dashed #e3e6f3; }
.va-empty .va-empty-icon { font-size: 46px; }
.va-empty h4 { margin: 10px 0 6px; }
.va-empty p { color: #7a84a3; margin-bottom: 18px; }

.va-list { display: flex; flex-direction: column; gap: 16px; }
.va-card { background: #fff; border-radius: 20px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(31,42,77,.05); border: 1px solid #eef0f7; display: flex; gap: 16px; }
.va-card.is-off { opacity: .55; }
.va-card.ui-sortable-helper { box-shadow: 0 16px 40px rgba(31,42,77,.15); }
.va-handle { cursor: grab; color: #b7bdd3; font-size: 18px; padding-top: 4px; }
.va-num { flex: 0 0 38px; height: 38px; border-radius: 12px; background: linear-gradient(135deg,#5b6cff,#9b7bff); color: #fff; font-family: var(--pk-font-head, inherit); font-weight: 600; display: flex; align-items: center; justify-content: center; }
.va-body { flex: 1; min-width: 0; }
.va-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px; }
.va-tag { font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 999px; background: #f1f3fb; color: #3f4a6b; }
.va-tag.mcq { background: #eef0ff; color: #4453e6; }
.va-tag.fill { background: #fff3dc; color: #b4610a; }
.va-tag.time { background: #dff7ee; color: #16a374; }
.va-qtext { font-size: 16px; font-weight: 700; color: #1f2a4d; margin-bottom: 10px; white-space: pre-line; word-break: break-word; }
.va-media img { max-width: 260px; max-height: 170px; border-radius: 12px; display: block; }
.va-media video { width: 320px; max-width: 100%; border-radius: 12px; display: block; background: #000; }
.va-media audio { width: 320px; max-width: 100%; }
.va-media { margin-bottom: 12px; }
.va-opts { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 10px; }
.va-opt { border: 2px solid #eef0f7; border-radius: 14px; padding: 10px; display: flex; gap: 10px; align-items: flex-start; }
.va-opt.ok { border-color: #22c58b; background: #f0fbf6; }
.va-opt-letter { flex: 0 0 28px; height: 28px; border-radius: 50%; background: #f1f3fb; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 13px; }
.va-opt.ok .va-opt-letter { background: #22c58b; color: #fff; }
.va-opt-body { min-width: 0; flex: 1; font-weight: 600; word-break: break-word; }
.va-opt-body img { max-width: 100%; max-height: 110px; border-radius: 10px; display: block; }
.va-opt-body video { width: 100%; border-radius: 10px; background: #000; display: block; }
.va-opt-body audio { width: 100%; }
.va-set { margin-bottom: 22px; padding: 18px; border-radius: 24px; background: #fff; border: 2px solid #eceefa; }
.va-set-none { background: #fafbff; }
.va-set:not(.va-set-none) + .va-set-none { border-style: dashed; }
.va-set-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
.va-set-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.va-set-title h3 { margin: 0; font-size: 21px; color: #1f2a4d; text-transform: none; }
.va-set-no { padding: 5px 12px; border-radius: 999px; background: linear-gradient(135deg,#5b6cff,#9b7bff); color: #fff; font-size: 12.5px; font-weight: 800; }
.va-set-count { color: #7a84a3; font-size: 13px; font-weight: 700; }
.va-set-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.va-set-actions .va-set-add { height: 38px; padding: 0 16px; }
.va-set-actions .va-icon-btn:disabled { opacity: .35; cursor: default; transform: none; }
.va-set-empty { padding: 18px; border-radius: 16px; border: 2px dashed #e3e6f3; color: #7a84a3; font-weight: 700; text-align: center; }
.va-dialog.va-dialog-xs { max-width: min(520px, calc(100vw - 32px)); }
.va-tag.drag { background: #e2f7fb; color: #0a7f99; }
.va-tag.match { background: #efeaff; color: #5b3fc4; }
.va-pairs { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 10px; }
.va-pair { display: flex; align-items: center; gap: 10px; padding: 10px; border: 2px solid #eef0f7; border-radius: 14px; }
.va-pair-side { flex: 1; min-width: 0; font-weight: 700; text-align: center; word-break: break-word; }
.va-pair-side img { max-width: 100%; max-height: 90px; border-radius: 10px; display: block; margin: 0 auto; }
.va-pair-side video { width: 100%; border-radius: 10px; background: #000; display: block; }
.va-pair-side audio { width: 100%; }
.va-pair-link { flex: 0 0 32px; height: 32px; border-radius: 50%; background: #efeaff; color: #7c5cff; font-weight: 800; display: flex; align-items: center; justify-content: center; }
.va-matchrow { display: grid; grid-template-columns: 30px 1fr 24px 1fr; gap: 10px; align-items: start; border: 2px solid #eef0f7; border-radius: 16px; padding: 12px; margin-bottom: 10px; }
.va-matchrow .va-opt-letter { margin-top: 8px; }
.va-matchrow .va-pair-link { margin-top: 6px; width: 24px; height: 24px; flex: none; font-size: 12px; }
.va-matchside { display: flex; flex-direction: column; gap: 8px; min-width: 0; }
.va-answers { display: flex; flex-wrap: wrap; gap: 6px; }
.va-answers span { padding: 6px 12px; border-radius: 10px; background: #f0fbf6; color: #16a374; font-weight: 700; border: 1px solid #c9efdf; }
.va-actions { display: flex; flex-direction: column; gap: 8px; }
.va-icon-btn { width: 38px; height: 38px; border-radius: 12px; border: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform .15s; }
.va-icon-btn:hover { transform: translateY(-2px); }
.va-icon-btn i { margin: 0; }
.va-icon-btn.edit { background: #eef0ff; color: #5b6cff; }
.va-icon-btn.toggle { background: #dff7ee; color: #16a374; }
.va-icon-btn.toggle.off { background: #f1f3fb; color: #7a84a3; }
.va-icon-btn.del { background: #ffe6ee; color: #e11d48; }

/* Modal */
.va-modal { position: fixed; inset: 0; z-index: 1080; display: none; align-items: flex-start; justify-content: center; padding: 30px 16px; background: rgba(15,23,42,.55); overflow-y: auto; }
.va-modal.open { display: flex; }
.va-dialog { background: #fff; border-radius: 24px; width: 100%; max-width: min(1200px, calc(100vw - 32px)); padding: 30px 36px; position: relative; box-shadow: 0 30px 70px rgba(15,23,42,.3); }
.va-close { position: absolute; top: 16px; right: 16px; width: 38px; height: 38px; border-radius: 50%; border: 0; background: #f1f3fb; font-size: 22px; line-height: 1; cursor: pointer; }
.va-close:hover { background: #ff4d6d; color: #fff; }
.va-dialog h3 { margin: 0 0 20px; font-size: 22px; }
@media (min-width: 1100px) {
    /* use the extra width: options and matching pairs two per row */
    #vaMcq .va-section:has(.va-optrow) { display: grid; grid-template-columns: 1fr 1fr; column-gap: 14px; }
    #vaMcq .va-section:has(.va-optrow) > .va-label,
    #vaMcq .va-section:has(.va-optrow) > .va-hint { grid-column: 1 / -1; }
    .va-dialog h3 { font-size: 24px; }
}
.va-label { display: block; font-weight: 800; font-size: 14px; margin-bottom: 8px; color: #3f4a6b; }
.va-section { margin-bottom: 20px; }
.va-seg { display: flex; flex-wrap: wrap; gap: 8px; }
.va-seg label { margin: 0; cursor: pointer; }
.va-seg input { position: absolute; opacity: 0; pointer-events: none; }
.va-seg span { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 12px; border: 2px solid #eceefa; font-weight: 700; color: #3f4a6b; background: #fff; transition: all .15s; }
.va-seg input:checked + span { border-color: #5b6cff; background: #eef0ff; color: #4453e6; }
.va-seg input:focus-visible + span { box-shadow: 0 0 0 4px rgba(91,108,255,.18); }
.va-typecards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
@media (max-width: 991px) { .va-typecards { grid-template-columns: 1fr 1fr; } }
.va-typecards span { flex-direction: column; align-items: flex-start; padding: 14px 16px; width: 100%; }
.va-typecards small { font-weight: 600; color: #7a84a3; }
.va-hint { font-size: 12.5px; color: #7a84a3; margin-top: 6px; }
.va-file-preview { margin-top: 10px; }
.va-file-preview img { max-height: 120px; border-radius: 10px; }
.va-file-preview video { max-width: 280px; border-radius: 10px; }
.va-file-preview audio { max-width: 100%; }
.va-optrow { display: flex; gap: 12px; align-items: flex-start; border: 2px solid #eef0f7; border-radius: 16px; padding: 12px; margin-bottom: 10px; transition: border-color .15s, background .15s; }
.va-optrow.is-correct { border-color: #22c58b; background: #f6fdf9; }
.va-optrow .va-opt-letter { margin-top: 8px; }
.va-optrow .va-opt-fields { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 8px; }
.va-correct { display: flex; align-items: center; gap: 6px; font-weight: 700; font-size: 13px; white-space: nowrap; margin: 8px 0 0; cursor: pointer; color: #16a374; }
.va-correct input { width: 18px; height: 18px; accent-color: #22c58b; }
.va-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.va-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; }
.va-footer .btn { min-width: 130px; height: 46px; }
.va-btn-ghost { background: #fff !important; color: #3f4a6b !important; border: 2px solid #eceefa !important; box-shadow: none !important; }
body.va-modal-open { overflow: hidden; }
@media (max-width: 767px) {
    .va-wrap { padding: 16px 0; }
    .va-hero-video { flex-basis: 100%; }
    .va-card { flex-wrap: wrap; padding: 14px; }
    .va-actions { flex-direction: row; width: 100%; justify-content: flex-end; }
    .va-dialog { padding: 22px 16px; }
    .va-grid2 { grid-template-columns: 1fr; }
    .va-matchrow { grid-template-columns: 26px 1fr; }
    .va-matchrow .va-pair-link { display: none; }
}
</style>

<section class="edu_admin_content">
<div class="va-wrap">
    <a class="va-back" href="<?php echo $back_url; ?>">&larr; Back to Content Manager</a>

    <div class="va-hero">
        <div class="va-hero-video">
            <?php if ($video['video_type'] === 'video' && $video['url']) { ?>
                <video id="vaPreview" src="<?php echo base_url($video['url']); ?>" controls preload="metadata" controlsList="nodownload"></video>
                <button type="button" class="va-time-btn" id="vaUseTime" title="Pause the video where the question should appear, then click">&#9201; Use current video time for a new question</button>
            <?php } else { ?>
                <div class="va-chip">Preview not available for this video source</div>
            <?php } ?>
        </div>
        <div class="va-hero-info">
            <h2><?php echo html_escape($video['title']); ?></h2>
            <div class="va-chips">
                <?php if ($batch_name !== '') { ?><span class="va-chip">&#127891; <?php echo html_escape($batch_name); ?></span><?php } ?>
                <?php if ($video['subject'] !== '') { ?><span class="va-chip">&#128218; <?php echo html_escape($video['subject']); ?></span><?php } ?>
                <?php if ($video['topic'] !== '') { ?><span class="va-chip">&#128278; <?php echo html_escape($video['topic']); ?></span><?php } ?>
            </div>
            <div class="va-stats">
                <div class="va-stat va-blue"><strong><?php echo count($questions); ?></strong><span>Questions</span></div>
                <div class="va-stat va-orange"><strong><?php echo count(array_filter($questions, function ($q) { return $q['status']; })); ?></strong><span>Active</span></div>
                <div class="va-stat va-green"><strong><?php echo rtrim(rtrim(number_format($total_marks, 2), '0'), '.'); ?></strong><span>Total Marks</span></div>
            </div>
            <div class="va-hero-actions">
                <?php if ($sets_ready) { ?><button type="button" class="btn btn-primary va-add-btn" data-va-set-new>+ New Set</button><?php } ?>
                <button type="button" class="btn btn-primary va-add-btn" data-va-add>+ Add Question</button>
                <button type="button" class="btn va-intro-btn" data-va-intro>&#128203; Quiz introduction<?php echo !empty($intro) ? ' &#10003;' : ''; ?></button>
            </div>
        </div>
    </div>

    <?php if (!empty($intro)) { ?>
        <div class="va-intro-card">
            <div class="va-intro-card-icon">&#128203;</div>
            <div class="va-intro-card-body">
                <div class="va-tags"><span class="va-tag fill">Introduction &middot; shown before the quiz</span></div>
                <?php if ($intro['title'] !== '') { ?><div class="va-qtext" style="margin-bottom:4px"><?php echo html_escape($intro['title']); ?></div><?php } ?>
                <?php if ($intro['instructions'] !== '') { ?><div class="va-intro-text"><?php echo nl2br(html_escape($intro['instructions'])); ?></div><?php } ?>
                <?php if ($intro['media']) { ?>
                    <div class="va-media" style="margin:10px 0 0">
                        <?php if ($intro['media_type'] === 'image') { ?><img src="<?php echo $media_url($intro['media']); ?>" alt="" loading="lazy">
                        <?php } elseif ($intro['media_type'] === 'audio') { ?><audio src="<?php echo $media_url($intro['media']); ?>" controls preload="none"></audio>
                        <?php } else { ?><video src="<?php echo $media_url($intro['media']); ?>" controls preload="none"></video><?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="va-actions"><button type="button" class="va-icon-btn edit" title="Edit introduction" data-va-intro><i class="fa fa-edit"></i></button></div>
        </div>
    <?php } ?>

    <?php
        // Card for one question (used inside each set section).
        $render_card = function ($q, $n) use ($media_url, $media_tag, $type_labels) { ?>
            <div class="va-card <?php echo $q['status'] ? '' : 'is-off'; ?>" data-id="<?php echo (int) $q['id']; ?>">
                <div class="va-handle" title="Drag to reorder">&#8942;&#8942;</div>
                <div class="va-num"><?php echo (int) $n; ?></div>
                <div class="va-body">
                    <div class="va-tags">
                        <?php if ($q['question_type'] === 'mcq') { ?>
                            <span class="va-tag mcq">MCQ &middot; <?php echo $type_labels[$q['option_type']]; ?> options</span>
                        <?php } elseif ($q['question_type'] === 'drag') { ?>
                            <span class="va-tag drag">Drag &amp; drop &middot; <?php echo $type_labels[$q['option_type']]; ?> cards</span>
                        <?php } elseif ($q['question_type'] === 'match') { ?>
                            <span class="va-tag match">Matching &middot; <?php echo $type_labels[$q['options']['left_type']]; ?> &rarr; <?php echo $type_labels[$q['options']['right_type']]; ?></span>
                        <?php } else { ?>
                            <span class="va-tag fill">Fill up / Type answer</span>
                        <?php } ?>
                        <?php if ($q['question_media_type'] !== 'none') { ?><span class="va-tag"><?php echo $type_labels[$q['question_media_type']]; ?> question</span><?php } ?>
                        <span class="va-tag"><?php echo rtrim(rtrim($q['marks'], '0'), '.'); ?> mark<?php echo $q['marks'] == 1 ? '' : 's'; ?></span>
                        <?php if ($q['show_at'] !== '') { ?><span class="va-tag time">&#9201; at <?php echo $q['show_at']; ?></span><?php } ?>
                        <?php if (!$q['status']) { ?><span class="va-tag">Hidden</span><?php } ?>
                    </div>
                    <?php if ($q['question_text'] !== '') { ?><div class="va-qtext"><?php echo html_escape($q['question_text']); ?></div><?php } ?>
                    <?php if ($q['question_media']) { ?>
                        <div class="va-media">
                            <?php if ($q['question_media_type'] === 'image') { ?><img src="<?php echo $media_url($q['question_media']); ?>" alt="Question image" loading="lazy">
                            <?php } elseif ($q['question_media_type'] === 'audio') { ?><audio src="<?php echo $media_url($q['question_media']); ?>" controls preload="none"></audio>
                            <?php } else { ?><video src="<?php echo $media_url($q['question_media']); ?>" controls preload="none"></video><?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($q['question_type'] === 'match') { ?>
                        <div class="va-pairs">
                            <?php foreach ($q['options']['pairs'] as $pi => $pair) { ?>
                            <div class="va-pair">
                                <div class="va-pair-side"><?php echo $media_tag($q['options']['left_type'], $pair['left']); ?></div>
                                <div class="va-pair-link">&harr;</div>
                                <div class="va-pair-side"><?php echo $media_tag($q['options']['right_type'], $pair['right']); ?></div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } elseif ($q['question_type'] === 'mcq' || $q['question_type'] === 'drag') { ?>
                        <div class="va-opts">
                            <?php foreach ($q['options'] as $oi => $opt) { $ok = ((int) $q['correct_option'] === $oi); ?>
                            <div class="va-opt <?php echo $ok ? 'ok' : ''; ?>">
                                <div class="va-opt-letter"><?php echo chr(65 + $oi); ?></div>
                                <div class="va-opt-body">
                                    <?php if ($q['option_type'] === 'image') { ?><img src="<?php echo $media_url($opt['media']); ?>" alt="Option <?php echo chr(65 + $oi); ?>" loading="lazy">
                                    <?php } elseif ($q['option_type'] === 'audio') { ?><audio src="<?php echo $media_url($opt['media']); ?>" controls preload="none"></audio>
                                    <?php } elseif ($q['option_type'] === 'video') { ?><video src="<?php echo $media_url($opt['media']); ?>" controls preload="none"></video><?php } ?>
                                    <?php if ($opt['text'] !== '') { ?><div><?php echo html_escape($opt['text']); ?></div><?php } ?>
                                    <?php if ($ok) { ?><small style="color:#16a374;font-weight:800">&#10003; Correct</small><?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="va-label" style="margin-bottom:6px">Accepted answers</div>
                        <div class="va-answers">
                            <?php foreach ($q['answers'] as $ans) { ?><span><?php echo html_escape($ans); ?></span><?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="va-actions">
                    <button type="button" class="va-icon-btn edit" title="Edit" data-va-edit="<?php echo (int) $q['id']; ?>"><i class="fa fa-edit"></i></button>
                    <button type="button" class="va-icon-btn toggle <?php echo $q['status'] ? '' : 'off'; ?>" title="<?php echo $q['status'] ? 'Active - click to hide from students' : 'Hidden - click to show to students'; ?>" data-va-toggle="<?php echo (int) $q['id']; ?>"><i class="fa <?php echo $q['status'] ? 'fa-eye' : 'fa-eye-slash'; ?>"></i></button>
                    <button type="button" class="va-icon-btn del" title="Delete" data-va-delete="<?php echo (int) $q['id']; ?>"><i class="fa fa-trash"></i></button>
                </div>
            </div>
    <?php };

        // Group questions by set (sets in their order, then questions without a set).
        $set_ids = array_map('intval', array_column($sets, 'id'));
        $by_set = array(); $no_set = array();
        foreach ($questions as $q) {
            $sid = isset($q['set_id']) ? (int) $q['set_id'] : 0;
            if ($sid && in_array($sid, $set_ids, TRUE)) { $by_set[$sid][] = $q; } else { $no_set[] = $q; }
        }
    ?>

    <?php if (empty($questions) && empty($sets)) { ?>
        <div class="va-empty">
            <div class="va-empty-icon">&#128221;</div>
            <h4>No questions yet</h4>
            <p><?php echo $sets_ready ? 'Create a set (e.g. Level 1, Basic) and add questions inside it, or add questions directly.' : 'Add MCQs or fill-up questions that students answer while watching this video.'; ?></p>
            <div class="va-hero-actions" style="justify-content:center">
                <?php if ($sets_ready) { ?><button type="button" class="btn btn-primary" data-va-set-new>+ New Set</button><?php } ?>
                <button type="button" class="btn btn-primary" data-va-add>+ Add Question</button>
            </div>
        </div>
    <?php } else { ?>
        <?php foreach ($sets as $si => $set) { $items = isset($by_set[(int) $set['id']]) ? $by_set[(int) $set['id']] : array(); ?>
        <div class="va-set" data-set-id="<?php echo (int) $set['id']; ?>">
            <div class="va-set-head">
                <div class="va-set-title">
                    <span class="va-set-no">Set <?php echo $si + 1; ?></span>
                    <h3><?php echo html_escape($set['name']); ?></h3>
                    <span class="va-set-count"><?php echo count($items); ?> question<?php echo count($items) == 1 ? '' : 's'; ?></span>
                </div>
                <div class="va-set-actions">
                    <button type="button" class="btn btn-primary va-set-add" data-va-add data-set="<?php echo (int) $set['id']; ?>">+ Add question</button>
                    <button type="button" class="va-icon-btn edit" title="Rename set" data-va-set-rename="<?php echo (int) $set['id']; ?>" data-name="<?php echo html_escape($set['name']); ?>"><i class="fa fa-edit"></i></button>
                    <button type="button" class="va-icon-btn" title="Move set up" data-va-set-move="up" data-id="<?php echo (int) $set['id']; ?>" <?php echo $si === 0 ? 'disabled' : ''; ?>>&#9650;</button>
                    <button type="button" class="va-icon-btn" title="Move set down" data-va-set-move="down" data-id="<?php echo (int) $set['id']; ?>" <?php echo $si === count($sets) - 1 ? 'disabled' : ''; ?>>&#9660;</button>
                    <button type="button" class="va-icon-btn del" title="Delete set" data-va-set-delete="<?php echo (int) $set['id']; ?>"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="va-list" data-sortable>
                <?php foreach ($items as $n => $q) { $render_card($q, $n + 1); } ?>
            </div>
            <?php if (empty($items)) { ?><div class="va-set-empty">No questions in this set yet &mdash; click <b>+ Add question</b>.</div><?php } ?>
        </div>
        <?php } ?>

        <?php if (!empty($no_set)) { ?>
        <div class="va-set va-set-none">
            <?php if (!empty($sets)) { ?>
            <div class="va-set-head">
                <div class="va-set-title"><h3>No set</h3><span class="va-set-count"><?php echo count($no_set); ?> question<?php echo count($no_set) == 1 ? '' : 's'; ?> &middot; edit a question to move it into a set</span></div>
            </div>
            <?php } ?>
            <div class="va-list" data-sortable>
                <?php foreach ($no_set as $n => $q) { $render_card($q, $n + 1); } ?>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
</div>
</section>

<!-- New / rename set -->
<div class="va-modal" id="vaSetModal" aria-hidden="true">
    <div class="va-dialog va-dialog-xs" role="dialog" aria-modal="true" aria-labelledby="vaSetTitle">
        <button type="button" class="va-close" data-va-close aria-label="Close">&times;</button>
        <h3 id="vaSetTitle">New set</h3>
        <form id="vaSetForm" novalidate>
            <input type="hidden" name="video_id" value="<?php echo (int) $video['id']; ?>">
            <input type="hidden" name="id" value="">
            <div class="va-section">
                <label class="va-label" for="vaSetName">Set name</label>
                <input type="text" class="form-control" id="vaSetName" name="name" maxlength="80" autocomplete="off" placeholder="e.g. Level 1, Basic, Advanced">
            </div>
            <div class="va-footer">
                <button type="button" class="btn va-btn-ghost" data-va-close>Cancel</button>
                <button type="submit" class="btn btn-primary" id="vaSetSave">Save Set</button>
            </div>
        </form>
    </div>
</div>

<!-- Quiz introduction -->
<div class="va-modal" id="vaIntroModal" aria-hidden="true">
    <div class="va-dialog va-dialog-sm" role="dialog" aria-modal="true" aria-labelledby="vaIntroTitle">
        <button type="button" class="va-close" data-va-close aria-label="Close">&times;</button>
        <h3 id="vaIntroTitle">Quiz introduction</h3>
        <p class="va-hint" style="margin:-12px 0 18px">Students see this before the first question. Leave everything empty to remove it.</p>
        <form id="vaIntroForm" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="video_id" value="<?php echo (int) $video['id']; ?>">
            <div class="va-section">
                <label class="va-label" for="vaIntroTitleInput">Title</label>
                <input type="text" class="form-control" id="vaIntroTitleInput" name="intro_title" maxlength="255" autocomplete="off" placeholder="e.g. Let's play the Apple quiz!" value="<?php echo !empty($intro) ? html_escape($intro['title']) : ''; ?>">
            </div>
            <div class="va-section">
                <label class="va-label" for="vaIntroText">Instructions</label>
                <textarea class="form-control" id="vaIntroText" name="intro_instructions" rows="5" placeholder="e.g. Watch the video carefully. Tap the right picture. You can try again at the end!"><?php echo !empty($intro) ? html_escape($intro['instructions']) : ''; ?></textarea>
            </div>
            <div class="va-section">
                <span class="va-label">Media (optional)</span>
                <div class="va-seg">
                    <?php $im = !empty($intro) ? $intro['media_type'] : 'none'; ?>
                    <label><input type="radio" name="intro_media_type" value="none" <?php echo $im === 'none' ? 'checked' : ''; ?>><span>None</span></label>
                    <label><input type="radio" name="intro_media_type" value="image" <?php echo $im === 'image' ? 'checked' : ''; ?>><span>&#128444;&#65039; Picture</span></label>
                    <label><input type="radio" name="intro_media_type" value="audio" <?php echo $im === 'audio' ? 'checked' : ''; ?>><span>&#127925; Audio</span></label>
                    <label><input type="radio" name="intro_media_type" value="video" <?php echo $im === 'video' ? 'checked' : ''; ?>><span>&#127916; Video</span></label>
                </div>
                <div id="vaIntroMediaWrap" style="display:none;margin-top:10px">
                    <input type="file" class="form-control" name="intro_media_file" id="vaIntroMediaFile">
                    <div class="va-file-preview" id="vaIntroPreview"><?php
                        if (!empty($intro['media'])) {
                            if ($intro['media_type'] === 'image') { echo '<img src="' . $media_url($intro['media']) . '" alt="">'; }
                            elseif ($intro['media_type'] === 'audio') { echo '<audio src="' . $media_url($intro['media']) . '" controls></audio>'; }
                            else { echo '<video src="' . $media_url($intro['media']) . '" controls></video>'; }
                        } ?></div>
                </div>
            </div>
            <div class="va-footer">
                <button type="button" class="btn va-btn-ghost" data-va-close>Cancel</button>
                <button type="submit" class="btn btn-primary" id="vaIntroSave">Save Introduction</button>
            </div>
        </form>
    </div>
</div>

<!-- Add / edit question -->
<div class="va-modal" id="vaModal" aria-hidden="true">
    <div class="va-dialog" role="dialog" aria-modal="true" aria-labelledby="vaModalTitle">
        <button type="button" class="va-close" data-va-close aria-label="Close">&times;</button>
        <h3 id="vaModalTitle">Add Question</h3>

        <form id="vaForm" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="id" value="">
            <input type="hidden" name="video_id" value="<?php echo (int) $video['id']; ?>">

            <div class="va-section">
                <span class="va-label">Question type</span>
                <div class="va-seg va-typecards">
                    <label><input type="radio" name="question_type" value="mcq" checked><span>&#9989; Multiple Choice (MCQ)</span></label>
                    <label><input type="radio" name="question_type" value="fill"><span>&#9997;&#65039; Fill up / Type answer</span></label>
                    <label><input type="radio" name="question_type" value="drag"><span>&#9995; Drag &amp; Drop</span></label>
                    <label><input type="radio" name="question_type" value="match"><span>&#128279; Matching</span></label>
                </div>
            </div>

            <?php if ($sets_ready) { ?>
            <div class="va-section">
                <label class="va-label" for="vaSet">Set</label>
                <select class="form-control" id="vaSet" name="set_id">
                    <option value="">&mdash; No set &mdash;</option>
                    <?php foreach ($sets as $set) { ?><option value="<?php echo (int) $set['id']; ?>"><?php echo html_escape($set['name']); ?></option><?php } ?>
                </select>
                <?php if (empty($sets)) { ?><div class="va-hint">Tip: create sets like "Level 1" or "Basic" with <b>+ New Set</b> to group questions.</div><?php } ?>
            </div>
            <?php } ?>

            <div class="va-section">
                <label class="va-label" for="vaQText">Question</label>
                <input type="text" class="form-control" id="vaQText" name="question_text" maxlength="1000" autocomplete="off" placeholder="e.g. Which animal says 'moo'?">
                <div class="va-hint">Optional when you add an image, audio or video below.</div>
            </div>

            <div class="va-section">
                <span class="va-label">Question media</span>
                <div class="va-seg" data-va-seg="question_media_type">
                    <label><input type="radio" name="question_media_type" value="none" checked><span>None</span></label>
                    <label><input type="radio" name="question_media_type" value="image"><span>&#128444;&#65039; Picture</span></label>
                    <label><input type="radio" name="question_media_type" value="audio"><span>&#127925; Audio</span></label>
                    <label><input type="radio" name="question_media_type" value="video"><span>&#127916; Video</span></label>
                </div>
                <div id="vaQMediaWrap" style="display:none;margin-top:10px">
                    <input type="file" class="form-control" name="question_media_file" id="vaQMediaFile">
                    <div class="va-hint" data-va-accept-hint></div>
                    <div class="va-file-preview" id="vaQMediaPreview"></div>
                </div>
            </div>

            <!-- MCQ -->
            <div id="vaMcq">
                <div class="va-grid2 va-section">
                    <div>
                        <span class="va-label">Number of options</span>
                        <div class="va-seg">
                            <label><input type="radio" name="option_count" value="3"><span>3 options</span></label>
                            <label><input type="radio" name="option_count" value="4" checked><span>4 options</span></label>
                        </div>
                    </div>
                    <div>
                        <span class="va-label">Options are</span>
                        <div class="va-seg">
                            <label><input type="radio" name="option_type" value="text" checked><span>Text</span></label>
                            <label><input type="radio" name="option_type" value="image"><span>Picture</span></label>
                            <label><input type="radio" name="option_type" value="audio"><span>Audio</span></label>
                            <label><input type="radio" name="option_type" value="video"><span>Video</span></label>
                        </div>
                    </div>
                </div>
                <div class="va-section">
                    <span class="va-label" data-va-opts-title>Options &mdash; tick the correct answer</span>
                    <?php for ($o = 0; $o < 4; $o++) { ?>
                    <div class="va-optrow" data-opt="<?php echo $o; ?>">
                        <div class="va-opt-letter"><?php echo chr(65 + $o); ?></div>
                        <div class="va-opt-fields">
                            <input type="text" class="form-control" name="option_text[<?php echo $o; ?>]" placeholder="Option <?php echo chr(65 + $o); ?> text" data-va-opt-text>
                            <div data-va-opt-media style="display:none">
                                <input type="file" class="form-control" name="option_media_file_<?php echo $o; ?>">
                                <div class="va-file-preview" data-va-opt-preview></div>
                            </div>
                        </div>
                        <label class="va-correct"><input type="radio" name="correct_option" value="<?php echo $o; ?>"> Correct</label>
                    </div>
                    <?php } ?>
                    <div class="va-hint" data-va-opt-hint></div>
                </div>
            </div>

            <!-- Matching -->
            <div id="vaMatch" style="display:none">
                <div class="va-section">
                    <span class="va-label">Number of pairs</span>
                    <div class="va-seg">
                        <label><input type="radio" name="pair_count" value="2"><span>2 pairs</span></label>
                        <label><input type="radio" name="pair_count" value="3"><span>3 pairs</span></label>
                        <label><input type="radio" name="pair_count" value="4" checked><span>4 pairs</span></label>
                    </div>
                </div>
                <div class="va-grid2 va-section">
                    <div>
                        <span class="va-label">Left side (stays in place)</span>
                        <div class="va-seg">
                            <label><input type="radio" name="pair_left_type" value="text" checked><span>Word</span></label>
                            <label><input type="radio" name="pair_left_type" value="image"><span>Picture</span></label>
                            <label><input type="radio" name="pair_left_type" value="audio"><span>Audio</span></label>
                            <label><input type="radio" name="pair_left_type" value="video"><span>Video</span></label>
                        </div>
                    </div>
                    <div>
                        <span class="va-label">Right side (student drags these)</span>
                        <div class="va-seg">
                            <label><input type="radio" name="pair_right_type" value="text"><span>Word</span></label>
                            <label><input type="radio" name="pair_right_type" value="image" checked><span>Picture</span></label>
                            <label><input type="radio" name="pair_right_type" value="audio"><span>Audio</span></label>
                            <label><input type="radio" name="pair_right_type" value="video"><span>Video</span></label>
                        </div>
                    </div>
                </div>
                <div class="va-section">
                    <span class="va-label">Pairs &mdash; put matching items on the same row (students see the right side shuffled)</span>
                    <?php for ($o = 0; $o < 4; $o++) { ?>
                    <div class="va-matchrow" data-pair="<?php echo $o; ?>">
                        <div class="va-opt-letter"><?php echo $o + 1; ?></div>
                        <?php foreach (array('left', 'right') as $side) { ?>
                        <div class="va-matchside" data-side="<?php echo $side; ?>">
                            <input type="text" class="form-control" name="pair_<?php echo $side; ?>_text[<?php echo $o; ?>]" data-va-pair-text>
                            <div data-va-pair-media style="display:none">
                                <input type="file" class="form-control" name="pair_<?php echo $side; ?>_file_<?php echo $o; ?>" data-va-pair-file="<?php echo $side; ?>">
                                <div class="va-file-preview" data-va-pair-preview></div>
                            </div>
                        </div>
                        <?php if ($side === 'left') { ?><div class="va-pair-link">&harr;</div><?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="va-hint">Example: Word &rarr; Picture: "Cat" on the left and a cat picture on the right.</div>
                </div>
            </div>

            <!-- Fill up -->
            <div id="vaFill" class="va-section" style="display:none">
                <label class="va-label" for="vaAnswers">Correct answers</label>
                <textarea class="form-control" id="vaAnswers" name="answers" rows="3" placeholder="One answer per line, e.g.&#10;cow&#10;a cow"></textarea>
                <div class="va-hint">Add every spelling you want to accept, one per line. Checking ignores capital letters and extra spaces.</div>
            </div>

            <div class="va-grid2 va-section">
                <div>
                    <label class="va-label" for="vaMarks">Marks</label>
                    <input type="number" class="form-control" id="vaMarks" name="marks" min="0.5" step="0.5" value="1">
                </div>
                <div>
                    <label class="va-label" for="vaShowAt">Show at video time <small style="font-weight:600">(optional)</small></label>
                    <input type="text" class="form-control" id="vaShowAt" name="show_at" placeholder="e.g. 1:30 - leave empty to show after the video">
                </div>
            </div>

            <div class="va-footer">
                <button type="button" class="btn va-btn-ghost" data-va-close>Cancel</button>
                <button type="submit" class="btn btn-primary" id="vaSave">Save Question</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var $ = window.jQuery;
    var api = base_url + 'video_assessment/';
    var $modal = $('#vaModal'), $form = $('#vaForm');
    var accept = {
        image: { attr: 'image/*', hint: 'JPG, PNG, GIF or WEBP - max 5 MB' },
        audio: { attr: 'audio/*', hint: 'MP3, WAV, OGG, M4A or AAC - max 20 MB' },
        video: { attr: 'video/*', hint: 'MP4, WEBM or MOV - max 200 MB' }
    };
    var mediaUrl = function (p) { return p ? base_url + p : ''; };

    function notify(ok, msg) {
        if (window.toastr) { toastr[ok ? 'success' : 'error'](msg); } else { alert(msg); }
    }
    function mediaTag(kind, src) {
        if (!src) return '';
        if (kind === 'image') return '<img src="' + src + '" alt="">';
        if (kind === 'audio') return '<audio src="' + src + '" controls></audio>';
        return '<video src="' + src + '" controls></video>';
    }
    function val(name) { return $form.find('[name="' + name + '"]:checked').val(); }

    function refresh() {
        var qt = val('question_type');
        var isMcq = (qt === 'mcq' || qt === 'drag');
        $('#vaMcq').toggle(isMcq);
        $('#vaMatch').toggle(qt === 'match');
        $('#vaFill').toggle(qt === 'fill');
        $form.find('[data-va-opts-title]').html(qt === 'drag'
            ? 'Cards students can drag &mdash; tick the one that belongs in the box'
            : 'Options &mdash; tick the correct answer');

        var pc = parseInt(val('pair_count'), 10) || 4;
        $form.find('.va-matchrow').each(function () {
            $(this).toggle(parseInt($(this).data('pair'), 10) < pc);
            $(this).find('.va-matchside').each(function () {
                var side = $(this).data('side');
                var kind = val('pair_' + side + '_type');
                $(this).find('[data-va-pair-media]').toggle(kind !== 'text');
                $(this).find('[data-va-pair-media] input').attr('accept', accept[kind] ? accept[kind].attr : '');
                $(this).find('[data-va-pair-text]').attr('placeholder', kind === 'text'
                    ? (side === 'left' ? 'Left word' : 'Right word')
                    : 'Label (optional)');
            });
        });

        var qm = val('question_media_type');
        $('#vaQMediaWrap').toggle(qm !== 'none');
        if (accept[qm]) {
            $('#vaQMediaFile').attr('accept', accept[qm].attr);
            $('#vaQMediaWrap [data-va-accept-hint]').text(accept[qm].hint);
        }

        var count = parseInt(val('option_count'), 10) || 4;
        var ot = val('option_type');
        $form.find('.va-optrow').each(function () {
            var i = parseInt($(this).data('opt'), 10);
            $(this).toggle(i < count);
            $(this).find('[data-va-opt-media]').toggle(ot !== 'text');
            $(this).find('[data-va-opt-media] input').attr('accept', accept[ot] ? accept[ot].attr : '');
            $(this).find('[data-va-opt-text]').attr('placeholder', ot === 'text' ? 'Option ' + String.fromCharCode(65 + i) + ' text' : 'Label (optional)');
        });
        if (parseInt(val('correct_option'), 10) >= count) {
            $form.find('[name="correct_option"]').prop('checked', false);
        }
        $form.find('[data-va-opt-hint]').text(ot !== 'text' && accept[ot] ? 'Upload a ' + (ot === 'image' ? 'picture' : ot) + ' for each option (' + accept[ot].hint + ').' : '');
        $form.find('.va-optrow').removeClass('is-correct');
        $form.find('[name="correct_option"]:checked').closest('.va-optrow').addClass('is-correct');
    }

    function openModal(title) {
        $('#vaModalTitle').text(title);
        $modal.addClass('open').attr('aria-hidden', 'false');
        $('body').addClass('va-modal-open');
        setTimeout(function () { $('#vaQText').trigger('focus'); }, 50);
    }
    function closeModal() {
        $modal.removeClass('open').attr('aria-hidden', 'true');
        $('body').removeClass('va-modal-open');
        $modal.find('video, audio').each(function () { this.pause(); });
    }
    function resetForm() {
        $form[0].reset();
        $form.find('[name="id"]').val('');
        $('#vaQMediaPreview').empty();
        $form.find('[data-va-opt-preview], [data-va-pair-preview]').empty();
        refresh();
    }

    // Live preview of a newly chosen file
    $form.on('change', 'input[type="file"]', function () {
        var file = this.files && this.files[0];
        var $preview = $(this).siblings('.va-file-preview');
        if (!file) return;
        var side = $(this).data('va-pair-file');
        var kind = this.id === 'vaQMediaFile' ? val('question_media_type') : (side ? val('pair_' + side + '_type') : val('option_type'));
        $preview.html(mediaTag(kind, URL.createObjectURL(file)));
    });
    $form.on('change', 'input[type="radio"]', refresh);

    $(document).on('click', '[data-va-add]', function () {
        resetForm();
        $('#vaSet').val($(this).data('set') || '');
        openModal('Add Question');
    });
    $(document).on('click', '[data-va-close]', closeModal);
    $modal.on('mousedown', function (e) { if (e.target === this) closeModal(); });
    $(document).on('keydown', function (e) { if (e.key === 'Escape' && $modal.hasClass('open')) closeModal(); });

    $('#vaUseTime').on('click', function () {
        var v = document.getElementById('vaPreview');
        var t = Math.floor(v ? v.currentTime : 0);
        resetForm();
        $('#vaShowAt').val(Math.floor(t / 60) + ':' + ('0' + (t % 60)).slice(-2));
        openModal('Add Question');
    });

    $(document).on('click', '[data-va-edit]', function () {
        var id = $(this).data('va-edit');
        $.post(api + 'get', { id: id }, function (res) {
            if (!res.status) return notify(false, res.msg);
            var q = res.question;
            resetForm();
            $form.find('[name="id"]').val(q.id);
            $form.find('[name="question_type"][value="' + q.question_type + '"]').prop('checked', true);
            $('#vaQText').val(q.question_text || '');
            $form.find('[name="question_media_type"][value="' + q.question_media_type + '"]').prop('checked', true);
            $('#vaQMediaPreview').html(mediaTag(q.question_media_type, mediaUrl(q.question_media)));
            $('#vaMarks').val(parseFloat(q.marks));
            $('#vaShowAt').val(q.show_at);
            $('#vaSet').val(q.set_id || '');
            if (q.question_type === 'match') {
                var m = q.options || {};
                $form.find('[name="pair_count"][value="' + (m.pairs ? m.pairs.length : 4) + '"]').prop('checked', true);
                $form.find('[name="pair_left_type"][value="' + m.left_type + '"]').prop('checked', true);
                $form.find('[name="pair_right_type"][value="' + m.right_type + '"]').prop('checked', true);
                $.each(m.pairs || [], function (i, pair) {
                    $.each(['left', 'right'], function (_, side) {
                        var $side = $form.find('.va-matchrow[data-pair="' + i + '"] .va-matchside[data-side="' + side + '"]');
                        $side.find('[data-va-pair-text]').val(pair[side].text || '');
                        $side.find('[data-va-pair-preview]').html(mediaTag(m[side + '_type'], mediaUrl(pair[side].media)));
                    });
                });
            } else if (q.question_type === 'mcq' || q.question_type === 'drag') {
                $form.find('[name="option_count"][value="' + (q.options.length === 3 ? 3 : 4) + '"]').prop('checked', true);
                $form.find('[name="option_type"][value="' + q.option_type + '"]').prop('checked', true);
                $.each(q.options, function (i, opt) {
                    var $row = $form.find('.va-optrow[data-opt="' + i + '"]');
                    $row.find('[data-va-opt-text]').val(opt.text || '');
                    $row.find('[data-va-opt-preview]').html(mediaTag(q.option_type, mediaUrl(opt.media)));
                });
                $form.find('[name="correct_option"][value="' + q.correct_option + '"]').prop('checked', true);
            } else {
                $('#vaAnswers').val((q.answers || []).join('\n'));
            }
            refresh();
            openModal('Edit Question');
        }, 'json').fail(function () { notify(false, 'Could not load the question.'); });
    });

    $form.on('submit', function (e) {
        e.preventDefault();
        var $btn = $('#vaSave');
        var fd = new FormData(this);
        $btn.prop('disabled', true).text('Saving...');
        $.ajax({ url: api + 'save', type: 'POST', data: fd, processData: false, contentType: false, dataType: 'json' })
            .done(function (res) {
                notify(res.status == 1, res.msg);
                if (res.status == 1) { closeModal(); setTimeout(function () { location.reload(); }, 500); }
            })
            .fail(function (xhr) {
                notify(false, xhr.status === 413 ? 'File is too large for the server.' : 'Could not save. Please try again.');
            })
            .always(function () { $btn.prop('disabled', false).text('Save Question'); });
    });

    $(document).on('click', '[data-va-toggle]', function () {
        $.post(api + 'status', { id: $(this).data('va-toggle') }, function (res) {
            notify(res.status == 1, res.msg);
            if (res.status == 1) setTimeout(function () { location.reload(); }, 400);
        }, 'json');
    });

    $(document).on('click', '[data-va-delete]', function () {
        var id = $(this).data('va-delete');
        var doDelete = function () {
            $.post(api + 'delete', { id: id }, function (res) {
                notify(res.status == 1, res.msg);
                if (res.status == 1) setTimeout(function () { location.reload(); }, 400);
            }, 'json');
        };
        if (window.swal) {
            swal({ title: 'Delete this question?', text: 'Its uploaded files will be removed too.', icon: 'warning', buttons: ['Cancel', 'Delete'], dangerMode: true })
                .then(function (ok) { if (ok) doDelete(); });
        } else if (confirm('Delete this question?')) {
            doDelete();
        }
    });

    if ($.fn.sortable && $('[data-sortable]').length) {
        // Drag to reorder inside a set; the order of all cards on the page is saved.
        $('[data-sortable]').sortable({
            handle: '.va-handle',
            update: function () {
                $(this).find('.va-num').each(function (i) { $(this).text(i + 1); });
                var ids = $('[data-sortable] .va-card').map(function () { return $(this).data('id'); }).get();
                $.post(api + 'reorder', { video_id: <?php echo (int) $video['id']; ?>, ids: ids }, function (res) {
                    if (res.status != 1) notify(false, res.msg);
                }, 'json');
            }
        });
    }

    /* ---- question sets ---- */
    var $setModal = $('#vaSetModal'), $setForm = $('#vaSetForm');
    function openSetModal(id, name) {
        $setForm.find('[name="id"]').val(id || '');
        $('#vaSetName').val(name || '');
        $('#vaSetTitle').text(id ? 'Rename set' : 'New set');
        $setModal.addClass('open').attr('aria-hidden', 'false');
        $('body').addClass('va-modal-open');
        setTimeout(function () { $('#vaSetName').trigger('focus'); }, 50);
    }
    $(document).on('click', '[data-va-set-new]', function () { openSetModal('', ''); });
    $(document).on('click', '[data-va-set-rename]', function () { openSetModal($(this).data('va-set-rename'), $(this).data('name')); });
    $setModal.on('click', '[data-va-close]', function () {
        $setModal.removeClass('open').attr('aria-hidden', 'true');
        $('body').removeClass('va-modal-open');
    });
    $setForm.on('submit', function (e) {
        e.preventDefault();
        $.post(api + 'set_save', $setForm.serialize(), function (res) {
            notify(res.status == 1, res.msg);
            if (res.status == 1) { setTimeout(function () { location.reload(); }, 400); }
        }, 'json').fail(function () { notify(false, 'Could not save the set.'); });
    });
    $(document).on('click', '[data-va-set-move]', function () {
        $.post(api + 'set_move', { id: $(this).data('id'), dir: $(this).data('va-set-move') }, function (res) {
            if (res.status == 1) { location.reload(); } else { notify(false, res.msg); }
        }, 'json');
    });
    $(document).on('click', '[data-va-set-delete]', function () {
        var id = $(this).data('va-set-delete');
        var go = function () {
            $.post(api + 'set_delete', { id: id }, function (res) {
                notify(res.status == 1, res.msg);
                if (res.status == 1) { setTimeout(function () { location.reload(); }, 500); }
            }, 'json');
        };
        if (window.swal) {
            swal({ title: 'Delete this set?', text: 'Its questions are kept and moved to "No set".', icon: 'warning', buttons: ['Cancel', 'Delete'], dangerMode: true })
                .then(function (ok) { if (ok) go(); });
        } else if (confirm('Delete this set? Its questions are kept and moved to "No set".')) { go(); }
    });

    /* ---- quiz introduction ---- */
    var $intro = $('#vaIntroModal'), $introForm = $('#vaIntroForm');
    function introRefresh() {
        var kind = $introForm.find('[name="intro_media_type"]:checked').val();
        $('#vaIntroMediaWrap').toggle(kind !== 'none');
        if (accept[kind]) { $('#vaIntroMediaFile').attr('accept', accept[kind].attr); }
    }
    $(document).on('click', '[data-va-intro]', function () {
        introRefresh();
        $intro.addClass('open').attr('aria-hidden', 'false');
        $('body').addClass('va-modal-open');
        setTimeout(function () { $('#vaIntroTitleInput').trigger('focus'); }, 50);
    });
    $intro.on('click', '[data-va-close]', function () {
        $intro.removeClass('open').attr('aria-hidden', 'true');
        $('body').removeClass('va-modal-open');
        $intro.find('video, audio').each(function () { this.pause(); });
    });
    $introForm.on('change', '[name="intro_media_type"]', introRefresh);
    $('#vaIntroMediaFile').on('change', function () {
        var f = this.files && this.files[0];
        if (f) { $('#vaIntroPreview').html(mediaTag($introForm.find('[name="intro_media_type"]:checked').val(), URL.createObjectURL(f))); }
    });
    $introForm.on('submit', function (e) {
        e.preventDefault();
        var $btn = $('#vaIntroSave');
        $btn.prop('disabled', true).text('Saving...');
        $.ajax({ url: api + 'intro_save', type: 'POST', data: new FormData(this), processData: false, contentType: false, dataType: 'json' })
            .done(function (res) {
                notify(res.status == 1, res.msg);
                if (res.status == 1) { setTimeout(function () { location.reload(); }, 500); }
            })
            .fail(function () { notify(false, 'Could not save. Please try again.'); })
            .always(function () { $btn.prop('disabled', false).text('Save Introduction'); });
    });

    refresh();
});
</script>
