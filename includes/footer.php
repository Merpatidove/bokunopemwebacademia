<footer>
    <div class="container">
        <p>&copy; 2025 Bokuno Responsi - Projek Responsi Pemweb </p>
    </div>
</footer>
<script>
    // Add loaded class to body for entrance animation
    document.addEventListener('DOMContentLoaded', function(){
        requestAnimationFrame(function(){ document.body.classList.add('is-loaded'); });
    });
</script>
<script>
    // Global background music persistence manager
    (function(){
        function qs(id){return document.getElementById(id);}
        const audio = qs('bgm');
        const btn = qs('musicBtn');
        if (!audio || !btn) return;

        const LS_PLAY = 'bgm_playing';
        const LS_TIME = 'bgm_time';

        function setBtnPlaying(isPlaying){
            btn.innerText = isPlaying ? '⏸ Pause Music' : '▶ Play Music';
        }

        async function tryPlay(){
            try {
                await audio.play();
                setBtnPlaying(true);
                localStorage.setItem(LS_PLAY, '1');
            } catch(e) {
                setBtnPlaying(false);
            }
        }

        function pause(){
            audio.pause();
            setBtnPlaying(false);
            localStorage.setItem(LS_PLAY, '0');
        }

        // restore time if present (wait for metadata if needed)
        const savedTime = localStorage.getItem(LS_TIME);
        if (savedTime !== null) {
            const applyTime = function(){ try{ audio.currentTime = parseFloat(savedTime) || 0; }catch(e){} };
            if (audio.readyState >= 1) applyTime(); else audio.addEventListener('loadedmetadata', applyTime, {once:true});
        }

        // restore play state (best-effort; may be blocked by autoplay policies)
        if (localStorage.getItem(LS_PLAY) === '1') {
            tryPlay();
        } else {
            setBtnPlaying(false);
        }

        // toggle handler
        btn.addEventListener('click', function(){
            if (audio.paused) tryPlay(); else pause();
        });

        // periodically save current time when playing
        let saver = setInterval(function(){
            try{ localStorage.setItem(LS_TIME, String(audio.currentTime)); }catch(e){}
        }, 1000);

        // save immediately on unload
        window.addEventListener('beforeunload', function(){
            try{ localStorage.setItem(LS_TIME, String(audio.currentTime)); localStorage.setItem(LS_PLAY, audio.paused ? '0' : '1'); }catch(e){}
        });

        // sync between tabs
        window.addEventListener('storage', function(e){
            if (e.key === LS_PLAY) {
                if (e.newValue === '1') tryPlay(); else pause();
            }
            if (e.key === LS_TIME && e.newValue !== null) {
                try{ audio.currentTime = parseFloat(e.newValue); }catch(e){}
            }
        });
    })();
</script>
</body>

</html>