<div id="global-loader">
    <div class="loader-content">
        <img src="{{ asset('image/Logo.png') }}" alt="Loading" class="loader-logo">
        <div class="loader-spinner"></div>
    </div>
</div>

<style>
#global-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    display: none;               /* ← pindah ke sini, hapus dari tag HTML */
    justify-content: center;
    align-items: center;
    z-index: 99999;              /* ← digedein biar di atas navbar */
}

.loader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.loader-logo {
    width: 80px;
    height: 80px;
    object-fit: contain;
    display: block;
}

.loader-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #ddd;
    border-top: 4px solid #000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}
</style>

<script>
function showLoader() {
    document.getElementById('global-loader').style.display = 'flex';
}

function hideLoader() {
    document.getElementById('global-loader').style.display = 'none';
}

window.addEventListener('beforeunload', function () {
    showLoader();
});
</script>