[1mdiff --git a/package.json b/package.json[m
[1mindex 13ec885..075878c 100644[m
[1m--- a/package.json[m
[1m+++ b/package.json[m
[36m@@ -7,11 +7,11 @@[m
         "dev": "vite"[m
     },[m
     "devDependencies": {[m
[31m-        "@tailwindcss/vite": "^4.0.0",[m
[32m+[m[32m        "@tailwindcss/vite": "^4.3.5",[m
         "concurrently": "^10.0.3",[m
[31m-        "laravel-vite-plugin": "^3.1",[m
[32m+[m[32m        "laravel-vite-plugin": "^2.1.0",[m
         "tailwindcss": "^4.0.0",[m
[31m-        "vite": "^8.0.0"[m
[32m+[m[32m        "vite": "^7.3.8"[m
     },[m
     "optionalDependencies": {[m
         "@laravel/multiplex": "^0.4.1"[m
[1mdiff --git a/resources/views/welcome.blade.php b/resources/views/welcome.blade.php[m
[1mindex 26e294a..28ae6a0 100644[m
[1m--- a/resources/views/welcome.blade.php[m
[1m+++ b/resources/views/welcome.blade.php[m
[36m@@ -6,8 +6,6 @@[m
 [m
         <title>{{ config('app.name', 'Laravel') }}</title>[m
 [m
[31m-        @fonts[m
[31m-[m
         <!-- Styles / Scripts -->[m
         @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))[m
             @vite(['resources/css/app.css', 'resources/js/app.js'])[m
[1mdiff --git a/vite.config.js b/vite.config.js[m
[1mindex 1fd66d5..f9455fd 100644[m
[1m--- a/vite.config.js[m
[1m+++ b/vite.config.js[m
[36m@@ -1,6 +1,6 @@[m
[32m+[m
 import { defineConfig } from 'vite';[m
 import laravel from 'laravel-vite-plugin';[m
[31m-import { bunny } from 'laravel-vite-plugin/fonts';[m
 import tailwindcss from '@tailwindcss/vite';[m
 [m
 export default defineConfig({[m
[36m@@ -8,11 +8,6 @@[m [mexport default defineConfig({[m
         laravel({[m
             input: ['resources/css/app.css', 'resources/js/app.js'],[m
             refresh: true,[m
[31m-            fonts: [[m
[31m-                bunny('Instrument Sans', {[m
[31m-                    weights: [400, 500, 600],[m
[31m-                }),[m
[31m-            ],[m
         }),[m
         tailwindcss(),[m
     ],[m
