import { URL, fileURLToPath } from 'node:url'
import fs from 'node:fs'
import path from 'node:path'
import { defineConfig, loadEnv } from 'vite'
import Laravel from 'laravel-vite-plugin'
import Vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import { HeadlessUiResolver } from 'unplugin-vue-components/resolvers'
import AutoImport from 'unplugin-auto-import/vite'
import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'
import { ViteS3 } from '@froxz/vite-plugin-s3'

export default defineConfig(({ mode }) => {
  process.env = {
    ...process.env,
    ...loadEnv(mode, process.cwd()),
  }

  return {
    plugins: [
      Laravel({
        input: [
          'resources/css/home.css',
          'resources/js/app.ts',
        ],
        buildDirectory:'static',
        refresh: true,
      }),
      Vue({
        template: {
          compilerOptions: {
            isCustomElement: tag => ['video-js'].includes(tag),
          },
          transformAssetUrls: {
            base: null,
            includeAbsolute: false,
          },
        },
      }),
      Components({
        dirs: [
          'resources/js/components',
          'resources/js/layouts',
        ],
        resolvers: [
          IconsResolver({
            prefix: false,
          }),
          HeadlessUiResolver(),
        ],
        types: [{
          from: '@inertiajs/vue3',
          names: ['Link'],
        }],
        dts: 'resources/js/shims/components.d.ts',
      }),
      AutoImport({
        dirs: [
          'resources/js/composables',
          'resources/js/utils',
        ],
        imports: [
          'vue',
          {
            '@vueuse/core': ['useClipboard', 'watchIgnorable'],
            '@inertiajs/vue3': ['router', 'useForm', 'usePage'],
          },
        ],
        dts: 'resources/js/shims/auto-imports.d.ts',
      }),
      Icons(),
      ViteS3(process.env.VITE_S3_UPLOAD_VITE_ASSETS_ENABLED === 'true', {
        basePath: '/build',
        clientConfig: {
          credentials: {
            accessKeyId: process.env.VITE_S3_ACCESS_KEY_ID!,
            secretAccessKey: process.env.VITE_S3_SECRET_ACCESS_KEY!,
          },
          endpoint: process.env.VITE_S3_ENDPOINT,
          region: process.env.VITE_S3_DEFAULT_REGION,
        },
        uploadOptions: {
          Bucket: process.env.VITE_S3_BUCKET,
        },
      }),
    ],
    server: {
      host: true,
      hmr: {
        host: 'localhost',
      },
      https: process.env.VITE_DEV_SERVER_KEY && process.env.VITE_DEV_SERVER_CERT
        ? {
            key: fs.readFileSync(process.env.VITE_DEV_SERVER_KEY),
            cert: fs.readFileSync(process.env.VITE_DEV_SERVER_CERT),
          }
        : undefined,
      watch: {
        ignored: [
          path.join(__dirname, 'app/**'),
          path.join(__dirname, 'bootstrap/**'),
          path.join(__dirname, 'config/**'),
          path.join(__dirname, 'database/**'),
          path.join(__dirname, 'lang/**'),
          path.join(__dirname, 'public/**'),
          path.join(__dirname, 'routes/**'),
          path.join(__dirname, 'storage/**'),
          path.join(__dirname, 'tests/**'),
          path.join(__dirname, 'vendor/**'),
        ],
      },
    },
    resolve: {
      alias: {
        '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
      },
    },
    optimizeDeps: {
      include: [
        '@headlessui/vue',
        '@inertiajs/vue3',
        '@vueuse/core',
        'axios',
        'body-scroll-lock',
        'inertia-title/vue3',
        'laravel-echo',
        'lodash-es',
        'pusher-js',
        'vue',
        'vue-final-modal',
        'vue-toastification',
      ],
    },
    //静态资源服务的文件夹
    // publicDir: "public",
    // base: './',
    build: {
      // outDir: "public/static",
      //生成静态资源的存放路径
      assetsDir: "assets",
      //设置为 false 来禁用将构建后的文件写入磁盘
      // write: true,
      //默认情况下，若 outDir 在 root 目录下，则 Vite 会在构建时清空该目录。
      emptyOutDir: true,
      //启用/禁用 brotli 压缩大小报告
      brotliSize: true,
      //chunk 大小警告的限制
      chunkSizeWarningLimit: 500
    }
  }
})
