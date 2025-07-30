// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/sidebar_rekam_medis.js',
        'resources/js/pages/rekam_medis/dashboard.js',
      ],
      refresh: true,
    }),
  ],
  optimizeDeps: {
    include: ['flowbite'],
  },
  server: {
    host: 'localhost',
    port: 5173,
    origin: 'http://localhost:5173',
    // === PASTI KAN BAGIAN INI ADA DAN BENAR ===
    cors: {
      origin: ['http://127.0.0.1:8000', 'http://localhost:8000'], // Pastikan ini sesuai dengan APP_URL Anda
      methods: ['GET', 'POST', 'PUT', 'DELETE'],
      allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
      credentials: true,
    },
    // ===========================================
  },
});