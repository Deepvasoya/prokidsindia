/*
 * Student video assessment ("quiz while you watch").
 *
 *   VAS.start(videoId)  - call after the video popup opens
 *   VAS.stop()          - call when the popup closes
 *
 * Questions with a "show at" time pause the video at that moment; the rest
 * appear when the video ends, or whenever the student taps "Start quiz".
 * Answers are checked on the server (student_assessment/check) and the final
 * score is saved by student_assessment/finish.
 */
(function ($) {
    'use strict';

    var api = base_url + 'student_assessment/';
    var state = null;

    function esc(text) {
        return $('<div>').text(text == null ? '' : String(text)).html();
    }
    function num(n) {
        n = parseFloat(n) || 0;
        return Math.round(n * 100) / 100;
    }
    function media(kind, src, cls) {
        if (!src) { return ''; }
        cls = cls ? ' class="' + cls + '"' : '';
        if (kind === 'image') { return '<img' + cls + ' src="' + esc(src) + '" alt="">'; }
        if (kind === 'audio') { return '<audio' + cls + ' src="' + esc(src) + '" controls preload="none"></audio>'; }
        if (kind === 'video') { return '<video' + cls + ' src="' + esc(src) + '" controls playsinline preload="metadata"></video>'; }
        return '';
    }

    function cardInner(kind, item) {
        if (kind === 'text') { return '<span class="vas-card-text">' + esc(item.text) + '</span>'; }
        return media(kind, item.media, 'vas-card-media') + (item.text ? '<span class="vas-card-label">' + esc(item.text) + '</span>' : '');
    }
    function dragCard(kind, item, attrs) {
        var handle = (kind === 'audio' || kind === 'video') ? '<button type="button" class="vas-move" data-vas="move">&#9995; Move</button>' : '';
        return '<div class="vas-dcard vas-kind-' + kind + '" draggable="true" tabindex="0" ' + attrs + '>' + cardInner(kind, item) + handle + '</div>';
    }

    /* ---------- player adapter: native <video> or Plyr (YouTube) ---------- */
    function player() {
        if (window.playerx && typeof window.playerx.on === 'function') {
            var p = window.playerx;
            return {
                time: function () { return p.currentTime || 0; },
                pause: function () { try { p.pause(); } catch (e) {} },
                play: function () { try { p.play(); } catch (e) {} },
                on: function (ev, fn) { p.on(ev, fn); }
            };
        }
        var v = document.querySelector('#view_video_popup .videoIframeShow video');
        if (!v) { return null; }
        return {
            time: function () { return v.currentTime || 0; },
            pause: function () { v.pause(); },
            play: function () { var r = v.play(); if (r && r.catch) { r.catch(function () {}); } },
            on: function (ev, fn) { v.addEventListener(ev, fn); }
        };
    }

    /* ---------- panel under the video ---------- */
    function panel() {
        var $p = $('#vasPanel');
        if (!$p.length) {
            $p = $('<div id="vasPanel" class="vas-panel"></div>');
            // Sit at the bottom of the side card (video title + part numbers) when it exists.
            var $side = $('#view_video_popup .number-section');
            if ($side.length) { $p.addClass('vas-panel-side').appendTo($side); }
            else { $('#view_video_popup .edu_popup_inner').append($p); }
        }
        return $p;
    }

    function renderPanel() {
        var qs = state.questions;
        var total = 0, timed = 0;
        $.each(qs, function (i, q) { total += q.marks; if (q.show_at !== null) { timed++; } });
        var done = Object.keys(state.answers).length;
        var dot = function (q) {
            var r = state.results[q.id];
            return '<span class="vas-dot ' + (r === undefined ? '' : (r ? 'ok' : 'bad')) + '"></span>';
        };
        var dots;
        if (state.sets.length) {
            // one row per set: name + its dots
            var order = [], rows = {};
            $.each(qs, function (i, q) {
                var k = setKey(q);
                if (!rows[k]) { rows[k] = { name: q.set_name || 'More questions', html: '' }; order.push(k); }
                rows[k].html += dot(q);
            });
            dots = $.map(order, function (k) {
                return '<div class="vas-set-row"><span class="vas-set-name">' + esc(rows[k].name) + '</span><span class="vas-set-dots">' + rows[k].html + '</span></div>';
            }).join('');
        } else {
            dots = $.map(qs, dot).join('');
        }

        var last = state.last
            ? '<div class="vas-last">&#11088; Last score: <b>' + num(state.last.score) + ' / ' + num(state.last.total_marks) + '</b></div>'
            : '';

        if (state.sets.length) {
            // Level-wise: each set has its own button; a set unlocks after the previous one is done.
            var prevName = '';
            var rowsHtml = $.map(state.sets, function (st, i) {
                var btn;
                if (!st.unlocked) {
                    btn = '<button type="button" class="vas-btn vas-level-btn is-locked" disabled title="Finish ' + esc(prevName) + ' first">&#128274; Locked</button>';
                } else if (st.done) {
                    btn = '<button type="button" class="vas-btn vas-btn-ghost vas-level-btn" data-vas="set-begin" data-set="' + st.id + '">&#8635; Play again</button>';
                } else {
                    btn = '<button type="button" class="vas-btn vas-btn-main vas-level-btn" data-vas="set-begin" data-set="' + st.id + '">Start &#9654;</button>';
                }
                var status = st.done
                    ? '<span class="vas-level-score">&#9989; ' + num(st.best || 0) + ' / ' + num(st.marks) + '</span>'
                    : (st.unlocked ? '<span class="vas-level-meta">' + st.count + ' question' + (st.count == 1 ? '' : 's') + '</span>'
                                   : '<span class="vas-level-meta">Finish ' + esc(prevName) + ' first</span>');
                prevName = st.name;
                return '<div class="vas-level' + (st.done ? ' is-done' : '') + (st.unlocked ? '' : ' is-locked') + '">' +
                           '<div class="vas-level-info"><span class="vas-level-no">' + (i + 1) + '</span><div><b>' + esc(st.name) + '</b>' + status + '</div></div>' +
                           btn +
                       '</div>';
            }).join('');
            panel().html(
                '<div class="vas-panel-body">' +
                    '<h4>Quiz time!</h4>' +
                    '<p>' + state.sets.length + ' levels &middot; finish each level to unlock the next</p>' +
                '</div>' +
                '<div class="vas-levels">' + rowsHtml + '</div>'
            ).show();
            return;
        }

        panel().html(
            '' +
            '<div class="vas-panel-body">' +
                '<h4>Quiz time!</h4>' +
                '<p>' + qs.length + ' question' + (qs.length === 1 ? '' : 's') + ' &middot; ' + num(total) + ' marks' +
                (timed ? ' &middot; ' + timed + ' will pop up while you watch' : '') + '</p>' +
                '<div class="vas-dots' + (state.sets.length ? ' vas-dots-sets' : '') + '">' + dots + '</div>' + last +
            '</div>' +
            '<button type="button" class="vas-btn vas-btn-main" data-vas="begin">' +
                (done ? (done >= qs.length ? 'See my score' : 'Continue quiz') : 'Start quiz') + ' &rarr;</button>'
        ).show();
    }

    /* ---------- question overlay ---------- */
    function overlay() {
        var $o = $('#vasOverlay');
        if (!$o.length) {
            $o = $('<div id="vasOverlay" class="vas-overlay" role="dialog" aria-modal="true"><div class="vas-card"></div></div>');
        }
        // Live inside Magnific Popup's wrapper: it pulls focus back to itself whenever
        // something outside the popup gets focus, which made the answer box untypeable.
        var $host = $('.mfp-wrap').first();
        if (!$host.length) { $host = $('body'); }
        if (!$o.parent().is($host)) { $o.appendTo($host); }
        return $o;
    }

    function exitFullscreen() {
        var d = document;
        if (d.fullscreenElement && d.exitFullscreen) { d.exitFullscreen().catch(function () {}); }
        else if (d.webkitFullscreenElement && d.webkitExitFullscreen) { d.webkitExitFullscreen(); }
    }

    function showIntro(next) {
        var it = state.intro;
        state.introShown = true;
        state.current = { intro: true };
        state.pausedForQuestion = true;
        var p = player();
        if (p) { p.pause(); }
        exitFullscreen();
        overlay().find('.vas-card').html(
            '<div class="vas-intro">' +
                '<span class="vas-step">&#128203; Before you start</span>' +
                '<h3 class="vas-q">' + esc(it.title || 'Quiz time!') + '</h3>' +
                (it.media ? '<div class="vas-q-media vas-q-media-' + it.media_type + '">' + media(it.media_type, it.media) + '</div>' : '') +
                (it.text ? '<div class="vas-intro-text">' + esc(it.text).replace(/\n/g, '<br>') + '</div>' : '') +
                '<div class="vas-intro-meta">' + (state.sets.length ? state.sets.length + ' levels &middot; ' : '') + state.questions.length + ' questions &middot; ' + num(totalMarks()) + ' marks</div>' +
            '</div>' +
            '<div class="vas-actions"><button type="button" class="vas-btn vas-btn-main" data-vas="intro-start">Let\'s start &rarr;</button></div>'
        );
        state.introNext = next;
        overlay().addClass('open');
        $('body').addClass('vas-open');
    }
    function totalMarks() {
        var t = 0;
        $.each(state.questions, function (i, q) { t += q.marks; });
        return t;
    }

    function setKey(q) { return q.set_id || 0; }

    function showSetIntro(q) {
        var key = setKey(q);
        var inSet = $.grep(state.questions, function (x) { return setKey(x) === key; });
        var marks = 0; $.each(inSet, function (i, x) { marks += x.marks; });
        var keys = $.map(state.sets, function (st) { return st.id; });
        state.current = { intro: true };
        overlay().find('.vas-card').html(
            '<div class="vas-intro vas-set-intro">' +
                '<span class="vas-step">Level ' + (keys.indexOf(key) + 1) + ' of ' + keys.length + '</span>' +
                '<div class="vas-set-emoji">&#127919;</div>' +
                '<h3 class="vas-q">' + esc(q.set_name || 'More questions') + '</h3>' +
                '<div class="vas-intro-meta">' + inSet.length + ' question' + (inSet.length === 1 ? '' : 's') + ' &middot; ' + num(marks) + ' mark' + (marks == 1 ? '' : 's') + '</div>' +
            '</div>' +
            '<div class="vas-actions"><button type="button" class="vas-btn vas-btn-main" data-vas="set-start">Let\'s go &rarr;</button></div>'
        );
        state.setNext = q;
        overlay().addClass('open');
        $('body').addClass('vas-open');
    }

    function showQuestion(q) {
        if (state.intro && !state.introShown) { return showIntro(q); }
        // Quiz mode with sets: announce each new set before its first question.
        if (state.sets.length && state.mode === 'quiz' && state.currentSet !== setKey(q)) {
            state.currentSet = setKey(q);
            var p0 = player(); if (p0) { p0.pause(); }
            return showSetIntro(q);
        }
        state.current = q;
        state.pausedForQuestion = true;
        var p = player();
        if (p) { p.pause(); }
        exitFullscreen();

        var pool = activeQuestions();
        var index = pool.indexOf(q) + 1;
        var body = '';
        if (q.type === 'mcq') {
            body = '<div class="vas-options vas-options-' + q.option_type + ' vas-count-' + q.options.length + '">' +
                $.map(q.options, function (opt, i) {
                    var letter = String.fromCharCode(65 + i);
                    var inner = q.option_type === 'text'
                        ? '<span class="vas-opt-text">' + esc(opt.text) + '</span>'
                        : media(q.option_type, opt.media, 'vas-opt-media') + (opt.text ? '<span class="vas-opt-label">' + esc(opt.text) + '</span>' : '');
                    // Audio/video options need their own controls, so the tile is a div with a separate "Pick" button.
                    if (q.option_type === 'audio' || q.option_type === 'video') {
                        return '<div class="vas-option" data-index="' + i + '"><span class="vas-letter">' + letter + '</span>' + inner +
                               '<button type="button" class="vas-pick" data-vas="pick" data-index="' + i + '">Pick ' + letter + '</button></div>';
                    }
                    return '<button type="button" class="vas-option" data-vas="pick" data-index="' + i + '"><span class="vas-letter">' + letter + '</span>' + inner + '</button>';
                }).join('') + '</div>';
        } else if (q.type === 'drag') {
            body = '<div class="vas-drop" data-vas-zone="drop"><span class="vas-drop-hint">&#11015; Drag the answer here (or tap a card)</span></div>' +
                   '<div class="vas-pool vas-pool-' + q.option_type + '" data-vas-zone="pool">' +
                   $.map(q.options, function (opt, i) { return dragCard(q.option_type, opt, 'data-index="' + i + '"'); }).join('') +
                   '</div>' +
                   '<div class="vas-actions"><button type="button" class="vas-btn vas-btn-main" data-vas="dragcheck" disabled>Check &#10003;</button></div>';
        } else if (q.type === 'match') {
            body = '<p class="vas-help">Drag each card to its partner &mdash; or tap a card, then tap a box.</p>' +
                   '<div class="vas-mrows">' +
                   $.map(q.left, function (item, i) {
                       return '<div class="vas-mrow">' +
                                  '<div class="vas-mleft vas-kind-' + q.left_type + '">' + cardInner(q.left_type, item) + '</div>' +
                                  '<div class="vas-mlink">&rarr;</div>' +
                                  '<div class="vas-mslot" data-vas-zone="slot" data-slot="' + i + '"><span class="vas-drop-hint">Drop here</span></div>' +
                              '</div>';
                   }).join('') + '</div>' +
                   '<div class="vas-pool vas-pool-' + q.right_type + '" data-vas-zone="pool">' +
                   $.map(q.right, function (item, p) { return dragCard(q.right_type, item, 'data-pos="' + p + '"'); }).join('') +
                   '</div>' +
                   '<div class="vas-actions"><button type="button" class="vas-btn vas-btn-main" data-vas="matchcheck" disabled>Check &#10003;</button></div>';
        } else {
            body = '<form class="vas-fill" data-vas-form>' +
                   '<input type="text" class="vas-input" autocomplete="off" autocapitalize="off" spellcheck="false" placeholder="Type your answer here">' +
                   '<button type="submit" class="vas-btn vas-btn-main">Check &#10003;</button></form>';
        }

        overlay().find('.vas-card').html(
            '<div class="vas-card-top"><span class="vas-step">Question ' + index + ' of ' + pool.length + '</span>' +
            (state.sets.length ? '<span class="vas-group">' + esc(q.set_name || 'More questions') + '</span>' : '') +
            '<span class="vas-marks">' + num(q.marks) + ' mark' + (q.marks == 1 ? '' : 's') + '</span></div>' +
            (q.text ? '<h3 class="vas-q">' + esc(q.text) + '</h3>' : '') +
            (q.media ? '<div class="vas-q-media vas-q-media-' + q.media_type + '">' + media(q.media_type, q.media) + '</div>' : '') +
            body +
            '<div class="vas-feedback" aria-live="polite"></div>'
        );
        overlay().addClass('open');
        $('body').addClass('vas-open');
        setTimeout(function () { overlay().find('.vas-input').trigger('focus'); }, 60);
    }

    function submitAnswer(answer) {
        var q = state.current;
        if (!q || state.busy) { return; }
        state.busy = true;
        var $card = overlay().find('.vas-card');
        $card.find('button, input').prop('disabled', true);

        $.post(api + 'check', { question_id: q.id, answer: answer }, null, 'json')
            .done(function (res) {
                if (!res || res.status != 1) { return fail(res && res.msg); }
                state.answers[q.id] = answer;
                state.results[q.id] = !!res.correct;
                feedback(q, answer, res);
            })
            .fail(function () { fail(); })
            .always(function () { state.busy = false; });

        function fail(msg) {
            $card.find('button, input').prop('disabled', false);
            $card.find('.vas-feedback').html('<div class="vas-msg vas-msg-bad">' + esc(msg || 'Could not check the answer. Please try again.') + '</div>');
        }
    }

    function feedback(q, answer, res) {
        var $card = overlay().find('.vas-card');
        var wrongMsg = '';
        if (q.type === 'mcq') {
            $card.find('.vas-option').each(function () {
                var i = parseInt($(this).data('index'), 10);
                if (i === res.correct_option) { $(this).addClass('is-correct'); }
                else if (String(i) === String(answer)) { $(this).addClass('is-wrong'); }
            });
            wrongMsg = 'The answer is <b>' + String.fromCharCode(65 + res.correct_option) + '</b>';
        } else if (q.type === 'drag') {
            $card.find('.vas-dcard').each(function () {
                var i = parseInt($(this).data('index'), 10);
                if (i === res.correct_option) { $(this).addClass('is-correct'); }
                else if (String(i) === String(answer)) { $(this).addClass('is-wrong'); }
            });
            wrongMsg = 'The right card is shown in green.';
        } else if (q.type === 'match') {
            var got = 0;
            $card.find('.vas-mslot').each(function () {
                var slot = parseInt($(this).data('slot'), 10);
                var ok = !!(res.pair_results || [])[slot];
                if (ok) { got++; }
                $(this).addClass(ok ? 'is-correct' : 'is-wrong');
                if (!ok && res.correct_positions && res.correct_positions[slot] !== undefined) {
                    var item = q.right[res.correct_positions[slot]];
                    $(this).append('<div class="vas-mfix">&#10003; ' + (q.right_type === 'text' ? esc(item.text)
                        : media(q.right_type === 'video' ? 'image' : q.right_type, q.right_type === 'video' ? '' : item.media, 'vas-mfix-media') + (item.text ? esc(item.text) : (q.right_type === 'video' ? 'see video ' + (res.correct_positions[slot] + 1) : ''))) + '</div>');
                }
            });
            wrongMsg = 'You matched <b>' + got + ' of ' + q.left.length + '</b> &middot; +' + num(res.marks) + ' mark' + (res.marks == 1 ? '' : 's');
        } else {
            $card.find('.vas-input').addClass(res.correct ? 'is-correct' : 'is-wrong');
        }
        $card.find('audio, video').each(function () { this.pause(); });
        // Drag/match: the tray and the Check button are no longer needed once answered.
        $card.find('.vas-actions').remove();
        $card.find('[data-vas-zone="pool"]').filter(function () { return !$(this).children().length; }).remove();
        $card.find('.vas-dcard').attr('draggable', 'false');

        var right = ['Great job!', 'Super!', 'Well done!', 'Awesome!', 'You got it!'];
        var msg = res.correct
            ? '<div class="vas-msg vas-msg-ok"><span class="vas-emoji">&#127881;</span> ' + right[Math.floor(Math.random() * right.length)] + '</div>'
            : '<div class="vas-msg vas-msg-bad"><span class="vas-emoji">&#128161;</span> Good try! ' +
              (wrongMsg || 'The answer is <b>' + esc(res.correct_answer) + '</b>') + '</div>';
        var label = 'Continue video &#9654;';
        if (state.mode === 'quiz' || state.ended) {
            label = nextQuestion() ? 'Next question &rarr;' : 'See my score &rarr;';
        }

        $card.find('.vas-feedback').html(msg + '<button type="button" class="vas-btn vas-btn-main" data-vas="continue">' + label + '</button>');
        $card.find('[data-vas="continue"]').prop('disabled', false).trigger('focus');
        renderPanel();
    }

    /** Questions of the level being played (all questions when sets are not used). */
    function activeQuestions() {
        if (state.activeSet === null || state.activeSet === undefined) { return state.questions; }
        return $.grep(state.questions, function (q) { return setKey(q) === state.activeSet; });
    }
    function nextQuestion() {
        var list = activeQuestions();
        for (var i = 0; i < list.length; i++) {
            if (state.answers[list[i].id] === undefined) { return list[i]; }
        }
        return null;
    }
    function setById(id) {
        for (var i = 0; i < state.sets.length; i++) { if (state.sets[i].id === id) { return state.sets[i]; } }
        return null;
    }
    function beginSet(id) {
        var st = setById(id);
        if (!st || !st.unlocked) { return; }
        state.mode = 'quiz';
        state.activeSet = id;
        state.currentSet = null;
        // fresh try of this level
        $.each(activeQuestions(), function (i, q) { delete state.answers[q.id]; delete state.results[q.id]; });
        var first = nextQuestion();
        if (first) { showQuestion(first); }
    }

    function closeOverlay() {
        overlay().removeClass('open').find('audio, video').each(function () { this.pause(); });
        $('body').removeClass('vas-open');
        if (state) { state.current = null; }
    }

    function onContinue() {
        closeOverlay();
        var next = nextQuestion();
        if (state.mode === 'quiz' || state.ended) {
            if (next) { showQuestion(next); } else { finish(); }
            return;
        }
        state.pausedForQuestion = false;
        var p = player();
        if (p) { p.play(); }
    }

    function finish() {
        state.mode = 'quiz';
        var $card = overlay().find('.vas-card');
        $card.html('<div class="vas-score"><div class="vas-score-emoji">&#9203;</div><h3>Checking your answers...</h3></div>');
        overlay().addClass('open');
        $('body').addClass('vas-open');

        var payload = { video_id: state.videoId, answers: JSON.stringify(state.answers) };
        if (state.sets.length && state.activeSet !== null && state.activeSet !== undefined) {
            var mine = {};
            $.each(activeQuestions(), function (i, q) { if (state.answers[q.id] !== undefined) { mine[q.id] = state.answers[q.id]; } });
            payload.answers = JSON.stringify(mine);
            payload.set_id = state.activeSet;
        }
        $.post(api + 'finish', payload, null, 'json')
            .done(function (res) {
                if (!res || res.status != 1) { return $card.html('<div class="vas-score"><h3>' + esc((res && res.msg) || 'Could not save your score.') + '</h3><button type="button" class="vas-btn" data-vas="close">Close</button></div>'); }
                state.last = res;
                state.lastLevel = state.sets.length ? (setById(state.activeSet) || {}).name || '' : '';
                var pct = res.total_marks > 0 ? res.score / res.total_marks : 0;
                var stars = pct >= 0.9 ? 3 : (pct >= 0.6 ? 2 : (pct > 0 ? 1 : 0));
                var starHtml = '';
                for (var i = 0; i < 3; i++) { starHtml += '<span class="vas-star' + (i < stars ? ' on' : '') + '">&#9733;</span>'; }
                var title = stars === 3 ? 'Amazing!' : (stars === 2 ? 'Well done!' : 'Keep practising!');
                $card.html(
                    '<div class="vas-score">' +
                        '<div class="vas-stars">' + starHtml + '</div>' +
                        '<h3>' + title + '</h3>' +
                        '<div class="vas-score-num">' + num(res.score) + '<small> / ' + num(res.total_marks) + '</small></div>' +
                        '<p>You answered ' + res.correct_count + ' of ' + res.question_count + ' questions correctly.</p>' +
                        '<div class="vas-score-actions">' +
                            '<button type="button" class="vas-btn vas-btn-ghost" data-vas="retry">&#8635; Try again</button>' +
                            '<span data-vas-next><button type="button" class="vas-btn vas-btn-main" data-vas="close">Done</button></span>' +
                        '</div>' +
                        '<button type="button" class="vas-btn vas-btn-share" data-vas="share">&#128228; Share my score</button>' +
                    '</div>'
                );
                if (state.sets.length) {
                    // refresh level progress from the server, then offer the next level if it unlocked
                    refreshSets(function () {
                        var ids = $.map(state.sets, function (st) { return st.id; });
                        var next = state.sets[ids.indexOf(state.activeSet) + 1];
                        if (next && next.unlocked) {
                            $card.find('[data-vas-next]').html('<button type="button" class="vas-btn vas-btn-main" data-vas="set-begin" data-set="' + next.id + '">Next: ' + esc(next.name) + ' &rarr;</button>');
                        }
                        renderPanel();
                    });
                } else {
                    renderPanel();
                }
            })
            .fail(function () { $card.html('<div class="vas-score"><h3>Could not save your score.</h3><button type="button" class="vas-btn" data-vas="close">Close</button></div>'); });
    }

    /* ---------- events ---------- */
    $(document).on('click', '[data-vas="begin"]', function () {
        if (!state) { return; }
        state.mode = 'quiz';
        var next = nextQuestion();
        if (next) { showQuestion(next); } else { finish(); }
    });
    $(document).on('click', '[data-vas="pick"]', function (e) {
        e.preventDefault();
        submitAnswer(String($(this).data('index')));
    });
    $(document).on('submit', '[data-vas-form]', function (e) {
        e.preventDefault();
        var val = $.trim($(this).find('.vas-input').val());
        if (val === '') { $(this).find('.vas-input').addClass('is-wrong').trigger('focus'); return; }
        submitAnswer(val);
    });
    $(document).on('input', '.vas-input', function () { $(this).removeClass('is-wrong'); });
    $(document).on('click', '[data-vas="continue"]', onContinue);
    $(document).on('click', '[data-vas="set-start"]', function () {
        if (!state || !state.setNext) { return; }
        var next = state.setNext;
        state.setNext = null;
        showQuestion(next);
    });
    $(document).on('click', '[data-vas="intro-start"]', function () {
        if (!state || !state.introNext) { return; }
        overlay().find('audio, video').each(function () { this.pause(); });
        var next = state.introNext;
        state.introNext = null;
        showQuestion(next);
    });
    $(document).on('click', '[data-vas="retry"]', function () {
        if (state.sets.length && state.activeSet !== null && state.activeSet !== undefined) {
            beginSet(state.activeSet);
            return;
        }
        state.answers = {}; state.results = {}; state.mode = 'quiz'; state.currentSet = null;
        renderPanel();
        showQuestion(state.questions[0]);
    });
    $(document).on('click', '[data-vas="set-begin"]', function () {
        if (!state) { return; }
        closeOverlay();
        beginSet(parseInt($(this).data('set'), 10) || 0);
    });
    $(document).on('click', '[data-vas="close"]', function () {
        closeOverlay();
        state.mode = 'watch';
    });

    /* ---------- share my score ---------- */
    function shareText() {
        var r = state.last, d = r.share || {};
        var who = d.name || 'I';
        var from = [d.school, d.city].filter(Boolean).join(', ');
        return '🌟 ' + who + (from ? ' from ' + from : '') + (d.class ? ' (' + d.class + ')' : '') +
            ' scored ' + num(r.score) + '/' + num(r.total_marks) +
            ' in the ' + (d.video ? '"' + d.video + '" ' : '') + 'quiz' + (d.level ? ' – ' + d.level : '') +
            ' on ProKids India! 🎉';
    }
    function siteUrl() {
        var a = document.createElement('a'); a.href = base_url; return a.protocol + '//' + a.host + '/';
    }
    function wrapLines(ctx, text, maxWidth) {
        var words = String(text).split(' '), lines = [], line = '';
        $.each(words, function (i, w) {
            var test = line ? line + ' ' + w : w;
            if (ctx.measureText(test).width > maxWidth && line) { lines.push(line); line = w; } else { line = test; }
        });
        if (line) { lines.push(line); }
        return lines;
    }
    function roundRect(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y); ctx.arcTo(x + w, y, x + w, y + h, r); ctx.arcTo(x + w, y + h, x, y + h, r);
        ctx.arcTo(x, y + h, x, y, r); ctx.arcTo(x, y, x + w, y, r); ctx.closePath();
    }
    /** Draws a 1080x1350 picture card (good for Instagram, WhatsApp status and Facebook). */
    function drawShareCard() {
        var r = state.last, d = r.share || {};
        var W = 1080, H = 1350, font = '"Fredoka", "Nunito", "Segoe UI", Arial, sans-serif';
        var c = document.createElement('canvas'); c.width = W; c.height = H;
        var ctx = c.getContext('2d');
        var bg = ctx.createLinearGradient(0, 0, W, H);
        bg.addColorStop(0, '#5b6cff'); bg.addColorStop(0.55, '#8b5cf6'); bg.addColorStop(1, '#ff5c8a');
        ctx.fillStyle = bg; ctx.fillRect(0, 0, W, H);
        // confetti dots
        var colors = ['#ffd84d', '#4ee0a8', '#ffffff', '#ff9f43', '#7dd3fc'];
        for (var i = 0; i < 60; i++) {
            ctx.globalAlpha = 0.35; ctx.fillStyle = colors[i % colors.length];
            ctx.beginPath(); ctx.arc((i * 197) % W, (i * 331) % H, 6 + (i % 5) * 3, 0, Math.PI * 2); ctx.fill();
        }
        ctx.globalAlpha = 1;
        // white card
        ctx.fillStyle = '#ffffff'; roundRect(ctx, 70, 150, W - 140, H - 300, 48); ctx.fill();
        ctx.textAlign = 'center';
        ctx.fillStyle = '#ffffff'; ctx.font = '700 54px ' + font; ctx.fillText('ProKids India', W / 2, 105);

        var pct = r.total_marks > 0 ? r.score / r.total_marks : 0;
        var stars = pct >= 0.9 ? 3 : (pct >= 0.6 ? 2 : (pct > 0 ? 1 : 0));
        ctx.font = '110px ' + font;
        for (var s = 0; s < 3; s++) { ctx.fillStyle = s < stars ? '#ffc93c' : '#e6e8f2'; ctx.fillText('★', W / 2 + (s - 1) * 130, 330); }
        ctx.fillStyle = '#1f2a4d'; ctx.font = '700 64px ' + font;
        ctx.fillText(stars === 3 ? 'Amazing!' : (stars === 2 ? 'Well done!' : 'Great try!'), W / 2, 430);
        ctx.fillStyle = '#5b6cff'; ctx.font = '800 170px ' + font;
        ctx.fillText(num(r.score) + ' / ' + num(r.total_marks), W / 2, 610);
        ctx.fillStyle = '#7a84a3'; ctx.font = '600 36px ' + font;
        ctx.fillText(r.correct_count + ' of ' + r.question_count + ' answers correct', W / 2, 670);

        var y = 780;
        ctx.fillStyle = '#1f2a4d'; ctx.font = '700 60px ' + font;
        $.each(wrapLines(ctx, d.name || 'Student', W - 240).slice(0, 2), function (i, l) { ctx.fillText(l, W / 2, y); y += 70; });
        ctx.font = '600 38px ' + font; ctx.fillStyle = '#4b5577';
        $.each([d.school, d.city, d.class ? 'Class: ' + d.class : ''], function (i, t) {
            if (!t) { return; }
            $.each(wrapLines(ctx, t, W - 240).slice(0, 2), function (j, l) { ctx.fillText(l, W / 2, y); y += 50; });
        });
        if (d.video || d.level) {
            y += 20;
            var quiz = (d.video ? d.video : 'Quiz') + (d.level ? ' • ' + d.level : '');
            ctx.font = '700 36px ' + font;
            var lines = wrapLines(ctx, '📚 ' + quiz, W - 300).slice(0, 2);
            var boxH = lines.length * 48 + 36, boxY = Math.min(y - 40, H - 170 - boxH);
            ctx.fillStyle = '#fff3e0'; roundRect(ctx, 150, boxY, W - 300, boxH, 28); ctx.fill();
            ctx.fillStyle = '#e8590c';
            $.each(lines, function (i, l) { ctx.fillText(l, W / 2, boxY + 58 + i * 48); });
        }
        ctx.fillStyle = '#ffffff'; ctx.font = '600 34px ' + font;
        ctx.fillText(new Date().toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' }) + '  •  ' + siteUrl().replace(/^https?:\/\//, '').replace(/\/$/, ''), W / 2, H - 70);
        return c;
    }
    function shareStatus(msg) { overlay().find('[data-vas-share-msg]').text(msg); }
    function downloadCard() {
        var a = document.createElement('a');
        a.href = state.shareImage; a.download = 'my-quiz-score.png';
        document.body.appendChild(a); a.click(); a.remove();
    }
    function openShare() {
        var $card = overlay().find('.vas-card');
        var go = function () {
            var canvas = drawShareCard();
            state.shareImage = canvas.toDataURL('image/png');
            canvas.toBlob(function (blob) { state.shareBlob = blob; });
            $card.find('.vas-score').hide();
            $card.find('.vas-share').remove();
            $card.append(
                '<div class="vas-share">' +
                    '<h3>Share your score &#127881;</h3>' +
                    '<img class="vas-share-img" src="' + state.shareImage + '" alt="My quiz score card">' +
                    '<div class="vas-share-grid">' +
                        '<button type="button" class="vas-share-btn is-native" data-vas-share="native">&#128228; Share</button>' +
                        '<button type="button" class="vas-share-btn is-wa" data-vas-share="whatsapp">WhatsApp</button>' +
                        '<button type="button" class="vas-share-btn is-ig" data-vas-share="instagram">Instagram</button>' +
                        '<button type="button" class="vas-share-btn is-fb" data-vas-share="facebook">Facebook</button>' +
                        '<button type="button" class="vas-share-btn" data-vas-share="download">&#11015; Save image</button>' +
                        '<button type="button" class="vas-share-btn" data-vas-share="copy">&#128203; Copy text</button>' +
                    '</div>' +
                    '<p class="vas-share-msg" data-vas-share-msg></p>' +
                    '<button type="button" class="vas-btn vas-btn-ghost" data-vas="share-back">&larr; Back</button>' +
                '</div>'
            );
        };
        if (document.fonts && document.fonts.ready) { document.fonts.ready.then(go); } else { go(); }
    }
    function nativeShare(onFail) {
        var text = shareText();
        if (navigator.share && state.shareBlob && window.File) {
            var file = new File([state.shareBlob], 'my-quiz-score.png', { type: 'image/png' });
            if (!navigator.canShare || navigator.canShare({ files: [file] })) {
                return navigator.share({ files: [file], text: text, title: 'My quiz score' }).catch(function () {});
            }
        }
        if (navigator.share) { return navigator.share({ text: text, url: siteUrl(), title: 'My quiz score' }).catch(function () {}); }
        onFail();
    }
    $(document).on('click', '[data-vas="share"]', function () { if (state && state.last) { openShare(); } });
    $(document).on('click', '[data-vas="share-back"]', function () {
        var $card = overlay().find('.vas-card');
        $card.find('.vas-share').remove();
        $card.find('.vas-score').show();
    });
    $(document).on('click', '[data-vas-share]', function () {
        if (!state || !state.last) { return; }
        var kind = $(this).data('vas-share'), text = shareText(), url = siteUrl();
        if (kind === 'native') {
            nativeShare(function () { downloadCard(); shareStatus('Image saved. Post it on any app you like!'); });
        } else if (kind === 'whatsapp') {
            window.open('https://wa.me/?text=' + encodeURIComponent(text + ' ' + url), '_blank');
        } else if (kind === 'facebook') {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url) + '&quote=' + encodeURIComponent(text), '_blank');
        } else if (kind === 'instagram') {
            // Instagram has no web share link: use the phone's share sheet, or save the image to post it.
            nativeShare(function () { downloadCard(); shareStatus('Image saved! Open Instagram and add it to your post or story.'); });
        } else if (kind === 'download') {
            downloadCard(); shareStatus('Image saved!');
        } else if (kind === 'copy') {
            var done = function () { shareStatus('Text copied! Paste it anywhere.'); };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text + ' ' + url).then(done, function () { window.prompt('Copy this text:', text + ' ' + url); });
            } else {
                window.prompt('Copy this text:', text + ' ' + url);
            }
        }
    });

    /* ---------- drag & drop / matching interactions ---------- */
    // Works with the mouse (HTML5 drag & drop) and with taps (tap a card, then tap a box).
    var dragging = null;

    function zoneOf(el) { return $(el).closest('[data-vas-zone]'); }
    function hint($zone) { return $zone.find('.vas-drop-hint'); }

    function placeCard($card, $zone) {
        var $q = $card.closest('.vas-card');
        var $pool = $q.find('[data-vas-zone="pool"]');
        if (!$zone.length || $zone.is($card.parent())) { return; }
        if ($zone.data('vasZone') !== 'pool') {
            // A box holds one card: send the old one back to the pool.
            $zone.find('.vas-dcard').not($card).appendTo($pool);
        }
        $card.removeClass('is-selected').appendTo($zone);
        $q.find('[data-vas-zone]').each(function () {
            var $z = $(this);
            if ($z.data('vasZone') !== 'pool') { hint($z).toggle(!$z.find('.vas-dcard').length); }
        });
        updateChecks($q);
    }

    function updateChecks($q) {
        var drop = $q.find('[data-vas-zone="drop"]');
        $q.find('[data-vas="dragcheck"]').prop('disabled', !drop.find('.vas-dcard').length);
        var slots = $q.find('[data-vas-zone="slot"]');
        var filled = slots.filter(function () { return $(this).find('.vas-dcard').length > 0; }).length;
        $q.find('[data-vas="matchcheck"]').prop('disabled', !slots.length || filled < slots.length);
    }

    function locked($el) { return $el.closest('.vas-card').find('.vas-feedback').children().length > 0 || (state && state.busy); }

    // Tap / click
    $(document).on('click', '.vas-dcard', function (e) {
        if ($(e.target).closest('audio, video').length) { return; }          // using the player controls
        var $card = $(this);
        if (locked($card)) { return; }
        var hasHandle = $card.find('.vas-move').length > 0;
        if (hasHandle && !$(e.target).closest('.vas-move').length && $card.parent().data('vasZone') === 'pool') { return; }
        var $q = $card.closest('.vas-card');
        var $zone = $card.parent();

        if ($zone.data('vasZone') !== 'pool') {                              // tap a placed card -> back to pool
            placeCard($card, $q.find('[data-vas-zone="pool"]'));
            return;
        }
        if ($q.find('[data-vas-zone="drop"]').length) {                       // drag & drop: one box
            placeCard($card, $q.find('[data-vas-zone="drop"]'));
            return;
        }
        var wasSelected = $card.hasClass('is-selected');                    // matching: select, then tap a box
        $q.find('.vas-dcard.is-selected').removeClass('is-selected');
        if (!wasSelected) {
            $card.addClass('is-selected');
            var $empty = $q.find('[data-vas-zone="slot"]').filter(function () { return !$(this).find('.vas-dcard').length; }).first();
            $q.find('.vas-mslot').removeClass('is-target');
            $empty.addClass('is-target');
        }
    });
    $(document).on('click', '[data-vas-zone="slot"]', function (e) {
        if ($(e.target).closest('.vas-dcard').length || locked($(this))) { return; }
        var $sel = $(this).closest('.vas-card').find('.vas-dcard.is-selected');
        $(this).closest('.vas-card').find('.vas-mslot').removeClass('is-target');
        if ($sel.length) { placeCard($sel, $(this)); }
    });
    $(document).on('keydown', '.vas-dcard', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); $(this).trigger('click'); }
    });

    // Mouse drag & drop
    $(document).on('dragstart', '.vas-dcard', function (e) {
        if (locked($(this))) { e.preventDefault(); return; }
        dragging = this;
        $(this).addClass('is-dragging');
        var dt = e.originalEvent.dataTransfer;
        if (dt) { dt.effectAllowed = 'move'; try { dt.setData('text/plain', 'vas'); } catch (err) {} }
    });
    $(document).on('dragend', '.vas-dcard', function () {
        $(this).removeClass('is-dragging');
        $('.vas-over').removeClass('vas-over');
        dragging = null;
    });
    $(document).on('dragover', '[data-vas-zone]', function (e) {
        if (!dragging) { return; }
        e.preventDefault();
        $(this).addClass('vas-over');
    });
    $(document).on('dragleave', '[data-vas-zone]', function () { $(this).removeClass('vas-over'); });
    $(document).on('drop', '[data-vas-zone]', function (e) {
        if (!dragging) { return; }
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('vas-over');
        placeCard($(dragging), $(this));
    });

    $(document).on('click', '[data-vas="dragcheck"]', function () {
        var $card = $(this).closest('.vas-card').find('[data-vas-zone="drop"] .vas-dcard');
        if ($card.length) { submitAnswer(String($card.data('index'))); }
    });
    $(document).on('click', '[data-vas="matchcheck"]', function () {
        var placed = [];
        $(this).closest('.vas-card').find('[data-vas-zone="slot"]').each(function () {
            var $c = $(this).find('.vas-dcard');
            placed[parseInt($(this).data('slot'), 10)] = $c.length ? parseInt($c.data('pos'), 10) : -1;
        });
        submitAnswer(JSON.stringify(placed));
    });

    function refreshSets(done) {
        var my = state;
        $.post(api + 'questions', { video_id: state.videoId }, null, 'json').done(function (res) {
            if (my !== state || !res || res.status != 1) { return; }
            state.sets = res.sets || [];
            if (done) { done(); }
        });
    }

    /* ---------- public API ---------- */
    window.VAS = {
        start: function (videoId) {
            this.stop();
            state = { videoId: videoId, questions: [], answers: {}, results: {}, mode: 'watch', ended: false, current: null, busy: false, last: null, sets: [], currentSet: null, activeSet: null };
            var my = state;
            $.post(api + 'questions', { video_id: videoId }, null, 'json').done(function (res) {
                if (my !== state || !res || res.status != 1 || !res.questions.length) { return; }
                state.questions = $.map(res.questions, function (q) { q.marks = parseFloat(q.marks) || 0; return q; });
                state.last = res.last_attempt;
                state.intro = res.intro || null;
                state.sets = res.sets || [];
                renderPanel();

                // Hook the player once it exists (Plyr for YouTube is created on popup open).
                var tries = 0;
                (function hook() {
                    if (my !== state) { return; }
                    var p = player();
                    if (!p) { if (tries++ < 20) { setTimeout(hook, 300); } return; }
                    p.on('timeupdate', function () {
                        if (my !== state || state.current || state.mode !== 'watch' || state.sets.length) { return; }
                        var t = p.time();
                        for (var i = 0; i < state.questions.length; i++) {
                            var q = state.questions[i];
                            if (q.show_at !== null && t >= q.show_at && state.answers[q.id] === undefined && !q._shown) {
                                q._shown = true;
                                showQuestion(q);
                                return;
                            }
                        }
                    });
                    p.on('ended', function () {
                        if (my !== state || state.sets.length) { return; }
                        state.ended = true;
                        var next = nextQuestion();
                        if (next && !state.current) { state.mode = 'quiz'; showQuestion(next); }
                    });
                })();
            });
        },
        stop: function () {
            state = null;
            closeOverlay();
            $('#vasPanel').remove();
        }
    };
})(jQuery);
