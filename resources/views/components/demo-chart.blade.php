<div class="chart-demo w-100">
    <svg viewbox="0 0 560 260">
        <defs>
            <filter id="dropshadow">
                <feGaussianBlur in="SourceAlpha" stdDeviation="3"></feGaussianBlur>
                <feOffset dx="0" dy="0" result="offsetblur"></feOffset>
                <feComponentTransfer>
                    <feFuncA slope="0.2" type="linear"></feFuncA>
                </feComponentTransfer>
                <feMerge>
                    <feMergeNode></feMergeNode>
                    <feMergeNode in="SourceGraphic"></feMergeNode>
                </feMerge>
            </filter>
        </defs>
        <g class="datasets">
            <path class="dataset" d="M0,260 C0,260 4,252 7,252 C66,252 90,102 139,102 C188,102 205,135 252,135 C299,135 309,89 330,89 C350,89 366,122 404,122 C442,122 431,98 451,98 C470,98 499,213 560,260 L0,259 Z" id="dataset-3"></path>
            <path class="dataset" d="M0,260 C35,254 63,124 88,124 C114,124 148,163 219,163 C290,163 315,100 359,100 C402,100 520,244 560,259 C560,259 0,259 0,260 Z" id="dataset-2"></path>
            <path class="dataset" d="M0,260 C0,260 22,199 64,199 C105,199 112,144 154,144 C195,144 194,126 216,126 C237,126 263,184 314,184 C365,183 386,128 434,129 C483,130 511,240 560,260 L0,260 Z" id="dataset-1"></path>
        </g>
    </svg>
</div>