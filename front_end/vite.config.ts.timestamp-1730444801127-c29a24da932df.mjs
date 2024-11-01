// vite.config.ts
import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/vite/dist/node/index.js";
import vue from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import vueJsx from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/@vitejs/plugin-vue-jsx/dist/index.mjs";
import VueDevTools from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/vite-plugin-vue-devtools/dist/vite.mjs";
import { viteStaticCopy } from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/vite-plugin-static-copy/dist/index.js";
import removeConsole from "file:///C:/laragon/www/ppdbv11/front_end/node_modules/vite-plugin-remove-console/dist/index.mjs";
var __vite_injected_original_import_meta_url = "file:///C:/laragon/www/ppdbv11/front_end/vite.config.ts";
var vite_config_default = defineConfig(({ mode }) => {
  const isProduction = mode === "production";
  return {
    plugins: [
      vue(),
      vueJsx(),
      VueDevTools(),
      isProduction && removeConsole(),
      viteStaticCopy({
        targets: [
          { src: "../public_files/**/*", dest: "../public/" }
          // Adjust paths as needed
        ]
      })
    ],
    server: {
      proxy: {
        "/api": {
          target: "http://ppdbv11.test",
          changeOrigin: true
        }
      }
    },
    build: {
      outDir: "../public",
      emptyOutDir: true,
      cssCodeSplit: true,
      manifest: true,
      rollupOptions: {
        plugins: [],
        output: {
          entryFileNames: ({ name }) => {
            if (name === "index") {
              return "index.js";
            }
            return "js/[name].[hash].js";
          },
          chunkFileNames: "js/[name].[hash].js",
          assetFileNames: ({ name }) => {
            if (name === "index.css") {
              return "[name].[ext]";
            }
            if (name && name.endsWith(".css")) {
              return "css/[name].[hash].[ext]";
            }
            if (name && /\.(png|jpe?g|gif|svg)$/.test(name)) {
              return "images/[name].[hash].[ext]";
            }
            return "assets/[name].[hash].[ext]";
          }
        }
      }
    },
    resolve: {
      alias: {
        "@": fileURLToPath(new URL("./src", __vite_injected_original_import_meta_url))
      }
    }
  };
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcudHMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxwcGRidjExXFxcXGZyb250X2VuZFwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxcbGFyYWdvblxcXFx3d3dcXFxccHBkYnYxMVxcXFxmcm9udF9lbmRcXFxcdml0ZS5jb25maWcudHNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L2xhcmFnb24vd3d3L3BwZGJ2MTEvZnJvbnRfZW5kL3ZpdGUuY29uZmlnLnRzXCI7aW1wb3J0IHsgZmlsZVVSTFRvUGF0aCwgVVJMIH0gZnJvbSAnbm9kZTp1cmwnXG5cbmltcG9ydCB7IGRlZmluZUNvbmZpZyB9IGZyb20gJ3ZpdGUnXG5pbXBvcnQgdnVlIGZyb20gJ0B2aXRlanMvcGx1Z2luLXZ1ZSdcbmltcG9ydCB2dWVKc3ggZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlLWpzeCdcbmltcG9ydCBWdWVEZXZUb29scyBmcm9tICd2aXRlLXBsdWdpbi12dWUtZGV2dG9vbHMnXG5pbXBvcnQgeyB2aXRlU3RhdGljQ29weSB9IGZyb20gJ3ZpdGUtcGx1Z2luLXN0YXRpYy1jb3B5J1xuaW1wb3J0IHJlbW92ZUNvbnNvbGUgZnJvbSAndml0ZS1wbHVnaW4tcmVtb3ZlLWNvbnNvbGUnXG5cbi8vIGh0dHBzOi8vdml0ZWpzLmRldi9jb25maWcvXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoKHsgbW9kZSB9KSA9PiB7XG4gIGNvbnN0IGlzUHJvZHVjdGlvbiA9IG1vZGUgPT09ICdwcm9kdWN0aW9uJ1xuICByZXR1cm57XG4gIFxuICBwbHVnaW5zOiBbXG4gICAgdnVlKCksXG4gICAgdnVlSnN4KCksXG4gICAgVnVlRGV2VG9vbHMoKSxcbiAgICBpc1Byb2R1Y3Rpb24gJiYgcmVtb3ZlQ29uc29sZSgpLFxuICAgIHZpdGVTdGF0aWNDb3B5KHtcbiAgICAgIHRhcmdldHM6IFtcbiAgICAgICAgeyBzcmM6ICcuLi9wdWJsaWNfZmlsZXMvKiovKicsIGRlc3Q6ICcuLi9wdWJsaWMvJyB9IC8vIEFkanVzdCBwYXRocyBhcyBuZWVkZWRcbiAgICAgIF1cbiAgICB9KVxuICAgIFxuICBdLFxuICBzZXJ2ZXI6IHtcbiAgICBwcm94eToge1xuICAgICAgJy9hcGknOiB7XG4gICAgICAgIHRhcmdldDogJ2h0dHA6Ly9wcGRidjExLnRlc3QnLFxuICAgICAgICBjaGFuZ2VPcmlnaW46IHRydWVcbiAgICAgIH0sXG4gICAgfVxuICB9LFxuICBidWlsZDoge1xuICAgIG91dERpcjogJy4uL3B1YmxpYycsXG4gICAgZW1wdHlPdXREaXI6IHRydWUsXG4gICAgY3NzQ29kZVNwbGl0OiB0cnVlLFxuICAgIG1hbmlmZXN0OiB0cnVlLFxuICAgIHJvbGx1cE9wdGlvbnM6IHtcbiAgICAgIHBsdWdpbnM6IFtcbiAgICAgICAgXG4gICAgICBdLFxuICAgICAgb3V0cHV0OiB7XG4gICAgICAgIGVudHJ5RmlsZU5hbWVzOiAoeyBuYW1lIH0pID0+IHtcbiAgICAgICAgICAvLyBDaGVjayBpZiB0aGUgZW50cnkgZmlsZSBpcyAnaW5kZXgnXG4gICAgICAgICAgaWYgKG5hbWUgPT09ICdpbmRleCcpIHtcbiAgICAgICAgICAgIHJldHVybiAnaW5kZXguanMnICAgLy8gUGxhY2UgJ2luZGV4LmpzJyBpbiAnc3BlY2lhbCcgZm9sZGVyXG4gICAgICAgICAgfVxuICAgICAgICAgIHJldHVybiAnanMvW25hbWVdLltoYXNoXS5qcycgICAgICAgICAgLy8gQWxsIG90aGVyIEphdmFTY3JpcHQgZmlsZXMgZ28gaW50byAnanMnIGZvbGRlclxuICAgICAgICB9LFxuICAgICAgICBjaHVua0ZpbGVOYW1lczogJ2pzL1tuYW1lXS5baGFzaF0uanMnLFxuICAgICAgICBhc3NldEZpbGVOYW1lczooe25hbWV9KT0+e1xuICAgICAgICAgIGlmIChuYW1lID09PSAnaW5kZXguY3NzJykge1xuICAgICAgICAgICAgcmV0dXJuICdbbmFtZV0uW2V4dF0nICAgICAgLy8gUGxhY2UgJ2luZGV4LmNzcycgaW4gdGhlIHJvb3QgZGlyZWN0b3J5XG4gICAgICAgICAgfVxuICAgICAgICAgIGlmIChuYW1lICYmIG5hbWUuZW5kc1dpdGgoJy5jc3MnKSkge1xuICAgICAgICAgICAgcmV0dXJuICdjc3MvW25hbWVdLltoYXNoXS5bZXh0XScgICAgICAvLyBDU1MgZmlsZXMgZ28gaW50byB0aGUgJ2NzcycgZm9sZGVyXG4gICAgICAgICAgfVxuICAgICAgICAgIGlmIChuYW1lICYmIC9cXC4ocG5nfGpwZT9nfGdpZnxzdmcpJC8udGVzdChuYW1lKSkge1xuICAgICAgICAgICAgcmV0dXJuICdpbWFnZXMvW25hbWVdLltoYXNoXS5bZXh0XScgICAvLyBJbWFnZSBmaWxlcyBnbyBpbnRvIHRoZSAnaW1hZ2VzJyBmb2xkZXJcbiAgICAgICAgICB9XG4gICAgICAgICAgcmV0dXJuICdhc3NldHMvW25hbWVdLltoYXNoXS5bZXh0XScgXG4gICAgICAgIH0gLFxuICAgICAgfSxcbiAgICB9LFxuICB9LFxuICByZXNvbHZlOiB7XG4gICAgYWxpYXM6IHtcbiAgICAgICdAJzogZmlsZVVSTFRvUGF0aChuZXcgVVJMKCcuL3NyYycsIGltcG9ydC5tZXRhLnVybCkpXG4gICAgfVxuICB9XG59XG59KVxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE0UixTQUFTLGVBQWUsV0FBVztBQUUvVCxTQUFTLG9CQUFvQjtBQUM3QixPQUFPLFNBQVM7QUFDaEIsT0FBTyxZQUFZO0FBQ25CLE9BQU8saUJBQWlCO0FBQ3hCLFNBQVMsc0JBQXNCO0FBQy9CLE9BQU8sbUJBQW1CO0FBUHVKLElBQU0sMkNBQTJDO0FBVWxPLElBQU8sc0JBQVEsYUFBYSxDQUFDLEVBQUUsS0FBSyxNQUFNO0FBQ3hDLFFBQU0sZUFBZSxTQUFTO0FBQzlCLFNBQU07QUFBQSxJQUVOLFNBQVM7QUFBQSxNQUNQLElBQUk7QUFBQSxNQUNKLE9BQU87QUFBQSxNQUNQLFlBQVk7QUFBQSxNQUNaLGdCQUFnQixjQUFjO0FBQUEsTUFDOUIsZUFBZTtBQUFBLFFBQ2IsU0FBUztBQUFBLFVBQ1AsRUFBRSxLQUFLLHdCQUF3QixNQUFNLGFBQWE7QUFBQTtBQUFBLFFBQ3BEO0FBQUEsTUFDRixDQUFDO0FBQUEsSUFFSDtBQUFBLElBQ0EsUUFBUTtBQUFBLE1BQ04sT0FBTztBQUFBLFFBQ0wsUUFBUTtBQUFBLFVBQ04sUUFBUTtBQUFBLFVBQ1IsY0FBYztBQUFBLFFBQ2hCO0FBQUEsTUFDRjtBQUFBLElBQ0Y7QUFBQSxJQUNBLE9BQU87QUFBQSxNQUNMLFFBQVE7QUFBQSxNQUNSLGFBQWE7QUFBQSxNQUNiLGNBQWM7QUFBQSxNQUNkLFVBQVU7QUFBQSxNQUNWLGVBQWU7QUFBQSxRQUNiLFNBQVMsQ0FFVDtBQUFBLFFBQ0EsUUFBUTtBQUFBLFVBQ04sZ0JBQWdCLENBQUMsRUFBRSxLQUFLLE1BQU07QUFFNUIsZ0JBQUksU0FBUyxTQUFTO0FBQ3BCLHFCQUFPO0FBQUEsWUFDVDtBQUNBLG1CQUFPO0FBQUEsVUFDVDtBQUFBLFVBQ0EsZ0JBQWdCO0FBQUEsVUFDaEIsZ0JBQWUsQ0FBQyxFQUFDLEtBQUksTUFBSTtBQUN2QixnQkFBSSxTQUFTLGFBQWE7QUFDeEIscUJBQU87QUFBQSxZQUNUO0FBQ0EsZ0JBQUksUUFBUSxLQUFLLFNBQVMsTUFBTSxHQUFHO0FBQ2pDLHFCQUFPO0FBQUEsWUFDVDtBQUNBLGdCQUFJLFFBQVEseUJBQXlCLEtBQUssSUFBSSxHQUFHO0FBQy9DLHFCQUFPO0FBQUEsWUFDVDtBQUNBLG1CQUFPO0FBQUEsVUFDVDtBQUFBLFFBQ0Y7QUFBQSxNQUNGO0FBQUEsSUFDRjtBQUFBLElBQ0EsU0FBUztBQUFBLE1BQ1AsT0FBTztBQUFBLFFBQ0wsS0FBSyxjQUFjLElBQUksSUFBSSxTQUFTLHdDQUFlLENBQUM7QUFBQSxNQUN0RDtBQUFBLElBQ0Y7QUFBQSxFQUNGO0FBQ0EsQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
