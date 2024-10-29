import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import VueDevTools from 'vite-plugin-vue-devtools'
import { viteStaticCopy } from 'vite-plugin-static-copy'
import removeConsole from 'vite-plugin-remove-console'

// https://vitejs.dev/config/
export default defineConfig(({ mode }) => {
  const isProduction = mode === 'production'
  return{
  
  plugins: [
    vue(),
    vueJsx(),
    VueDevTools(),
    isProduction && removeConsole(),
    viteStaticCopy({
      targets: [
        { src: '../public_files/**/*', dest: '../public/' } // Adjust paths as needed
      ]
    })
    
  ],
  server: {
    proxy: {
      '/api': {
        target: 'http://ppdbv11.test',
        changeOrigin: true
      }
    }
  },
  build: {
    outDir: '../public',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      plugins: [
        
      ],
      output: {
        entryFileNames: ({ name }) => {
          // Check if the entry file is 'index'
          if (name === 'index') {
            return 'index.js'   // Place 'index.js' in 'special' folder
          }
          return 'js/[name].js'          // All other JavaScript files go into 'js' folder
        },
        chunkFileNames: 'js/[name].js',
        assetFileNames:({name})=>{
          if (name === 'index.css') {
            return '[name].[ext]'      // Place 'index.css' in the root directory
          }
          if (name && name.endsWith('.css')) {
            return 'css/[name].[ext]'      // CSS files go into the 'css' folder
          }
          if (name && /\.(png|jpe?g|gif|svg)$/.test(name)) {
            return 'images/[name].[ext]'   // Image files go into the 'images' folder
          }
          return 'assets/[name].[ext]' 
        } ,
      },
    },
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
}
})
