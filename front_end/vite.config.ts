import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import VueDevTools from 'vite-plugin-vue-devtools'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    VueDevTools()
  ],
  server: {
    proxy: {
      '/api': process.env.VITE_API_BASE_URL || 'http://localhost:8000', // Dynamic API base URL
    },
  },
  build: {
    outDir: '../public/app',
    emptyOutDir: true,
    manifest: true,
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
