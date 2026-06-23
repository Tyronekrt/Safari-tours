<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 60" class="safari-logo">
  <!-- Background Circle with Gradient -->
  <defs>
    <linearGradient id="circleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#3d7a37;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#2d5a27;stop-opacity:1" />
    </linearGradient>
  </defs>
  
  <circle cx="30" cy="30" r="25" fill="url(#circleGradient)"/>
  
  <!-- Elephant Silhouette -->
  <g transform="translate(8, 8) scale(0.8)">
    <!-- Body -->
    <ellipse cx="25" cy="35" rx="20" ry="15" fill="#4a3728"/>
    
    <!-- Head -->
    <circle cx="45" cy="25" r="12" fill="#4a3728"/>
    
    <!-- Trunk -->
    <path d="M55 25 Q65 30 60 45 Q55 50 50 45" stroke="#4a3728" stroke-width="6" fill="none" stroke-linecap="round"/>
    
    <!-- Ear -->
    <ellipse cx="40" cy="20" rx="8" ry="10" fill="#4a3728" transform="rotate(-30 40 20)"/>
    
    <!-- Eye -->
    <circle cx="48" cy="23" r="2" fill="#2a1a10"/>
    
    <!-- Tusks -->
    <path d="M55 28 Q60 32 58 38" stroke="#f5f5dc" stroke-width="3" fill="none" stroke-linecap="round"/>
    <path d="M56 30 Q62 34 60 40" stroke="#f5f5dc" stroke-width="2" fill="none" stroke-linecap="round"/>
    
    <!-- Legs -->
    <rect x="15" y="45" width="5" height="12" fill="#4a3728" rx="2"/>
    <rect x="25" y="47" width="5" height="10" fill="#4a3728" rx="2"/>
    <rect x="35" y="46" width="5" height="11" fill="#4a3728" rx="2"/>
  </g>
  
  <!-- Acacia Tree in background -->
  <g transform="translate(0, -5) scale(0.4)" opacity="0.6">
    <rect x="5" y="35" width="4" height="20" fill="#8B4513"/>
    <ellipse cx="7" cy="25" rx="15" ry="10" fill="#5d8a4a"/>
    <path d="M7 25 L0 18 M7 25 L14 18 M7 25 L3 12 M7 25 L11 12" stroke="#4a7a3a" stroke-width="2" fill="none"/>
  </g>
  
  <!-- Safari Text -->
  <text x="65" y="25" font-family="Georgia, serif" font-size="22" font-weight="bold" fill="#2d5a27" letter-spacing="2">SAFARI</text>
  <text x="65" y="45" font-family="Arial, sans-serif" font-size="12" font-weight="normal" fill="#666" letter-spacing="4">TOURS</text>
  
  <!-- Decorative grass elements -->
  <g transform="translate(70, 50)">
    <path d="M0 5 Q2 0 4 5 Q6 0 8 5" stroke="#3d7a37" stroke-width="2" fill="none"/>
    <path d="M15 5 Q17 0 19 5 Q21 0 23 5" stroke="#3d7a37" stroke-width="2" fill="none"/>
  </g>
  
  <!-- Small sun accent -->
  <circle cx="190" cy="12" r="6" fill="#FFA500"/>
  <g stroke="#FFA500" stroke-width="1.5" opacity="0.8">
    <line x1="190" y1="2" x2="190" y2="5"/>
    <line x1="190" y1="19" x2="190" y2="22"/>
    <line x1="180" y1="12" x2="183" y2="12"/>
    <line x1="197" y1="12" x2="200" y2="12"/>
  </g>
</svg>

<style>
.safari-logo {
  height: 50px;
  width: auto;
}

.safari-logo:hover {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}
</style>