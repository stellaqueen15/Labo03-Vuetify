// Plugins
import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import Fonts from "unplugin-fonts/vite";
import Layouts from "vite-plugin-vue-layouts";
import Vue from "@vitejs/plugin-vue";
import VueRouter from "unplugin-vue-router/vite";
import Vuetify, { transformAssetUrls } from "vite-plugin-vuetify";

// Utilities
import { defineConfig } from "vite";
import { fileURLToPath, URL } from "node:url";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    VueRouter(),
    Layouts(),
    Vue({
      template: { transformAssetUrls },
    }),
    // https://github.com/vuetifyjs/vuetify-loader/tree/master/packages/vite-plugin#readme
    Vuetify({
      autoImport: true,
      styles: {
        configFile: "src/styles/settings.scss",
      },
    }),
    Components(),
    Fonts({
      google: {
        families: [
          {
            name: "Roboto",
            styles: "wght@100;300;400;500;700;900",
          },
        ],
      },
    }),
    AutoImport({
      imports: ["vue", "vue-router"],
      eslintrc: {
        enabled: true,
      },
      vueTemplate: true,
    }),
  ],
  define: { "process.env": {} },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
    extensions: [".js", ".json", ".jsx", ".mjs", ".ts", ".tsx", ".vue"],
  },
  server: {
    port: 3000,
    proxy: {
      "/Labo03/api": {
        target: "http://localhost:4208", // L'URL de ton serveur API
        changeOrigin: true, // Permet de modifier l'origin de la requête
        secure: false, // Désactive la vérification du certificat SSL si tu utilises HTTP
        pathRewrite: {
          "^/Labo03/api": "", // Retirer '/Labo03/api' de l'URL avant de la transmettre à l'API
        },
      },
      "/Labo03/checkout.php": {
        target: "http://localhost:4208", // L'URL de ton serveur pour checkout.php
        changeOrigin: true, // Permet de modifier l'origin de la requête
        secure: false, // Désactive la vérification du certificat SSL si tu utilises HTTP
        pathRewrite: {
          "^/Labo03/checkout.php": "", // Retirer '/checkout.php' avant d'envoyer la requête
        },
      },
    },
  },
  css: {
    preprocessorOptions: {
      sass: {
        api: "modern-compiler",
      },
    },
  },
});
