<div class="loader-container" id="preloaderz">
    <div class="loader">
        <div class="cell d-0"></div>
        <div class="cell d-1"></div>
        <div class="cell d-2"></div>
        <div class="cell d-1"></div>
        <div class="cell d-2"></div>
        <div class="cell d-2"></div>
        <div class="cell d-3"></div>
        <div class="cell d-3"></div>
        <div class="cell d-4"></div>
    </div>
    <div class="loading-text" id="loadingMessage">
        <span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span>
    </div>
</div>
<style>
    body, html {
        height: 100%;
        margin: 0;
        overflow: hidden; 
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999; 
        text-align: center;
    }
    .loader {
        --cell-size: 52px;
        --cell-spacing: 1px;
        --cells: 3;
        --total-size: calc(var(--cells) * (var(--cell-size) + 2 * var(--cell-spacing)));
        display: flex;
        flex-wrap: wrap;
        width: var(--total-size);
        height: var(--total-size);
        margin: 0 auto;
    }
    .cell {
        flex: 0 0 var(--cell-size);
        margin: var(--cell-spacing);
        background-color: transparent;
        box-sizing: border-box;
        border-radius: 4px;
        animation: 1.5s ripple ease infinite;
    }
    .cell.d-1 { animation-delay: 100ms; }
    .cell.d-2 { animation-delay: 200ms; }
    .cell.d-3 { animation-delay: 300ms; }
    .cell.d-4 { animation-delay: 400ms; }
    .cell:nth-child(1) { --cell-color: #00FF87; }
    .cell:nth-child(2) { --cell-color: #0CFD95; }
    .cell:nth-child(3) { --cell-color: #17FBA2; }
    .cell:nth-child(4) { --cell-color: #23F9B2; }
    .cell:nth-child(5) { --cell-color: #30F7C3; }
    .cell:nth-child(6) { --cell-color: #3DF5D4; }
    .cell:nth-child(7) { --cell-color: #45F4DE; }
    .cell:nth-child(8) { --cell-color: #53F1F0; }
    .cell:nth-child(9) { --cell-color: #60EFFF; }

    @keyframes ripple {
        0%, 100% { background-color: transparent; }
        30% { background-color: var(--cell-color); }
        60% { background-color: transparent; }
    }

    .loading-text {
        margin-top: 20px;
        color: white;
    }
    .loading-text span {
        font-size: 2rem;
        font-weight: bold;
        margin: 0 5px;
        animation: bounce 1.5s ease infinite;
    }
    .loading-text span:nth-child(1) { animation-delay: 100ms; }
    .loading-text span:nth-child(2) { animation-delay: 200ms; }
    .loading-text span:nth-child(3) { animation-delay: 300ms; }
    .loading-text span:nth-child(4) { animation-delay: 400ms; }
    .loading-text span:nth-child(5) { animation-delay: 500ms; }
    .loading-text span:nth-child(6) { animation-delay: 600ms; }
    .loading-text span:nth-child(7) { animation-delay: 700ms; }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
<script>
    window.addEventListener('load', function() {
        document.body.style.overflow = ''; 
        document.getElementById('preloaderz').style.display = 'none';
    });
</script>
