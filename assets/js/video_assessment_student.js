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
            $('#view_video_popup .edu_popup_inner').append($p);
        }
        return $p;
    }

    function renderPanel() {
        var qs = state.questions;
        var total = 0, timed = 0;
        $.each(qs, function (i, q) { total += q.marks; if (q.show_at !== null) { timed++; } });
        var done = Object.keys(state.answers).length;
        var dots = $.map(qs, function (q) {
            var r = state.results[q.id];
            return '<span class="vas-dot ' + (r === undefined ? '' : (r ? 'ok' : 'bad')) + '"></span>';
        }).join('');

        var last = state.last
            ? '<div class="vas-last">&#11088; Last score: <b>' + num(state.last.score) + ' / ' + num(state.last.total_marks) + '</b></div>'
            : '';

        panel().html(
            '<div class="vas-panel-icon">&#129504;</div>' +
            '<div class="vas-panel-body">' +
                '<h4>Quiz time!</h4>' +
                '<p>' + qs.length + ' question' + (qs.length === 1 ? '' : 's') + ' &middot; ' + num(total) + ' marks' +
                (timed ? ' &middot; ' + timed + ' will pop up while you watch' : '') + '</p>' +
                '<div class="vas-dots">' + dots + '</div>' + last +
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

    function showQuestion(q) {
        state.current = q;
        state.pausedForQuestion = true;
        var p = player();
        if (p) { p.pause(); }
        exitFullscreen();

        var index = state.questions.indexOf(q) + 1;
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
        } else {
            body = '<form class="vas-fill" data-vas-form>' +
                   '<input type="text" class="vas-input" autocomplete="off" autocapitalize="off" spellcheck="false" placeholder="Type your answer here">' +
                   '<button type="submit" class="vas-btn vas-btn-main">Check &#10003;</button></form>';
        }

        overlay().find('.vas-card').html(
            '<div class="vas-card-top"><span class="vas-step">Question ' + index + ' of ' + state.questions.length + '</span>' +
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
        if (q.type === 'mcq') {
            $card.find('.vas-option').each(function () {
                var i = parseInt($(this).data('index'), 10);
                if (i === res.correct_option) { $(this).addClass('is-correct'); }
                else if (String(i) === String(answer)) { $(this).addClass('is-wrong'); }
            });
        } else {
            $card.find('.vas-input').addClass(res.correct ? 'is-correct' : 'is-wrong');
        }
        $card.find('audio, video').each(function () { this.pause(); });

        var right = ['Great job!', 'Super!', 'Well done!', 'Awesome!', 'You got it!'];
        var msg = res.correct
            ? '<div class="vas-msg vas-msg-ok"><span class="vas-emoji">&#127881;</span> ' + right[Math.floor(Math.random() * right.length)] + '</div>'
            : '<div class="vas-msg vas-msg-bad"><span class="vas-emoji">&#128161;</span> Good try! The answer is <b>' +
              (q.type === 'mcq' ? String.fromCharCode(65 + res.correct_option) : esc(res.correct_answer)) + '</b></div>';
        var label = 'Continue video &#9654;';
        if (state.mode === 'quiz' || state.ended) {
            label = nextQuestion() ? 'Next question &rarr;' : 'See my score &rarr;';
        }

        $card.find('.vas-feedback').html(msg + '<button type="button" class="vas-btn vas-btn-main" data-vas="continue">' + label + '</button>');
        $card.find('[data-vas="continue"]').prop('disabled', false).trigger('focus');
        renderPanel();
    }

    function nextQuestion() {
        for (var i = 0; i < state.questions.length; i++) {
            if (state.answers[state.questions[i].id] === undefined) { return state.questions[i]; }
        }
        return null;
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

        $.post(api + 'finish', { video_id: state.videoId, answers: JSON.stringify(state.answers) }, null, 'json')
            .done(function (res) {
                if (!res || res.status != 1) { return $card.html('<div class="vas-score"><h3>Could not save your score.</h3><button type="button" class="vas-btn" data-vas="close">Close</button></div>'); }
                state.last = res;
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
                            '<button type="button" class="vas-btn vas-btn-main" data-vas="close">Done</button>' +
                        '</div>' +
                    '</div>'
                );
                renderPanel();
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
    $(document).on('click', '[data-vas="retry"]', function () {
        state.answers = {}; state.results = {}; state.mode = 'quiz';
        renderPanel();
        showQuestion(state.questions[0]);
    });
    $(document).on('click', '[data-vas="close"]', function () {
        closeOverlay();
        state.mode = 'watch';
    });

    /* ---------- public API ---------- */
    window.VAS = {
        start: function (videoId) {
            this.stop();
            state = { videoId: videoId, questions: [], answers: {}, results: {}, mode: 'watch', ended: false, current: null, busy: false, last: null };
            var my = state;
            $.post(api + 'questions', { video_id: videoId }, null, 'json').done(function (res) {
                if (my !== state || !res || res.status != 1 || !res.questions.length) { return; }
                state.questions = $.map(res.questions, function (q) { q.marks = parseFloat(q.marks) || 0; return q; });
                state.last = res.last_attempt;
                renderPanel();

                // Hook the player once it exists (Plyr for YouTube is created on popup open).
                var tries = 0;
                (function hook() {
                    if (my !== state) { return; }
                    var p = player();
                    if (!p) { if (tries++ < 20) { setTimeout(hook, 300); } return; }
                    p.on('timeupdate', function () {
                        if (my !== state || state.current || state.mode !== 'watch') { return; }
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
                        if (my !== state) { return; }
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
