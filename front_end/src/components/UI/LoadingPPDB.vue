<template>
    <div class="loading-container">
        <!-- viewBox diperlebar ke 240 100 untuk menampung 4 huruf -->
        <svg class="loader-svg" viewBox="0 0 240 100">
            <!-- HURUF 1: P (Utama/Loader) -->
            <!-- Posisi x:30 (stem), x:45 (center circle) -->
            <g class="p1-group">
                <circle class="stroke-item p1-circle" cx="45" cy="35" r="15" />
                <path class="stroke-item p1-stem" d="M 30 35 L 30 75" /> 
            </g>

            <!-- GROUP SISA (P D B) -->
            <g class="other-letters">
                
                <!-- HURUF 2: P -->
                <!-- Offset X +50 dari P1. Stem: 80 -->
                <g>
                    <path class="stroke-item stem-anim" d="M 80 25 L 80 75" />
                    <!-- Kurva P -->
                    <circle class="stroke-item curve-anim" cx="95" cy="35" r="15" stroke-dasharray="95" />
                </g>

                <!-- HURUF 3: D -->
                <!-- Offset X +50. Stem: 130 -->
                <g>
                    <path class="stroke-item stem-anim" d="M 130 25 L 130 75" />
                    <!-- Kurva D: Besar dari atas ke bawah -->
                    <path class="stroke-item curve-anim" d="M 130 25 C 165 25, 165 75, 130 75" />
                </g>

                <!-- HURUF 4: B -->
                <!-- Offset X +50. Stem: 180 -->
                <g>
                    <path class="stroke-item stem-anim" d="M 180 25 L 180 75" />
                    <!-- Kurva B: Dua lekukan -->
                    <path class="stroke-item curve-anim" d="M 180 25 C 205 25, 205 50, 180 50 C 205 50, 205 75, 180 75" />
                </g>

            </g>
        </svg>
    </div>
</template>

<style scoped>
.loading-container {
    background-color: #0f172a; /* Keeping the background color as requested */
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed; /* Fixed to cover the screen */
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999; /* High z-index to overlay everything */
    overflow: hidden;
}

.loader-svg {
    /* Lebar disesuaikan agar muat teks PPDB */
    width: 300px; 
    height: 120px;
    filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.5));
}

/* --- STYLES UMUM GARIS --- */
.stroke-item {
    fill: none;
    stroke: #6366f1; /* Indigo 500 */
    stroke-width: 8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

/* --- ANIMASI HURUF P PERTAMA (LOADER UTAMA) --- */

/* Grup P1: Bergerak dari tengah ke kiri */
.p1-group {
    animation: slide-left 5s ease-in-out infinite;
}

/* Kepala P1: Berputar seperti loader di awal */
.p1-circle {
    transform-origin: 45px 35px; /* Pusat lingkaran P1 */
    stroke-dasharray: 20, 100;
    animation: spin-intro 5s ease-in-out infinite;
}

/* Batang P1: Muncul setelah putaran selesai */
.p1-stem {
    stroke-dasharray: 60;
    stroke-dashoffset: 60;
    animation: draw-line 5s ease-in-out infinite;
}

/* --- ANIMASI HURUF LAINNYA (P, D, B) --- */

/* Grup P2, D, B: Awalnya hidden */
.other-letters {
    opacity: 0;
    animation: fade-in-letters 5s linear infinite;
}

/* Garis Batang untuk P2, D, B */
.stem-anim {
    stroke-dasharray: 60;
    stroke-dashoffset: 60;
    animation: draw-line-delayed 5s ease-in-out infinite;
}

/* Garis Lengkung untuk P2, D, B */
.curve-anim {
    stroke-dasharray: 120; /* Estimasi panjang kurva */
    stroke-dashoffset: 120;
    animation: draw-curve-delayed 5s ease-in-out infinite;
}


/* --- KEYFRAMES --- */

/* 1. Menggeser P pertama dari tengah layar ke posisi awal teks */
@keyframes slide-left {
    0%, 30% { transform: translateX(75px); } /* Posisi Tengah (approx) */
    40%, 100% { transform: translateX(0px); } /* Posisi Kiri (Teks PPDB) */
}

/* 2. Memutar lingkaran P1 (Loading effect) */
@keyframes spin-intro {
    0% { 
        transform: rotate(0deg); 
        stroke-dasharray: 20, 100; 
    }
    25% { 
        transform: rotate(360deg); 
        stroke-dasharray: 95, 95; /* Lingkaran penuh 2*PI*15 ~= 94.2 */
        stroke-dashoffset: 0;
    }
    30%, 100% {
        transform: rotate(360deg);
        stroke-dasharray: 95, 95;
        stroke-dashoffset: 0;
    }
}

/* 3. Menggambar garis vertikal (Batang) */
@keyframes draw-line {
    0%, 25% { stroke-dashoffset: 60; opacity: 0; }
    30% { opacity: 1; }
    35%, 100% { stroke-dashoffset: 0; opacity: 1; }
}

/* 4. Memunculkan grup huruf sisa */
@keyframes fade-in-letters {
    0%, 35% { opacity: 0; }
    40%, 100% { opacity: 1; }
}

/* 5. Menggambar garis batang huruf sisa (delay dikit dari P1) */
@keyframes draw-line-delayed {
    0%, 35% { stroke-dashoffset: 60; }
    45%, 100% { stroke-dashoffset: 0; }
}

/* 6. Menggambar kurva huruf sisa (P, D, B) */
@keyframes draw-curve-delayed {
    0%, 40% { stroke-dashoffset: 120; }
    55%, 100% { stroke-dashoffset: 0; }
}
</style>
