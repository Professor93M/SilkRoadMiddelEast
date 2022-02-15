<template>
    <div class="container-fluid px-0 bg-gray-700">
        <pageTitle title="Check Order" />
        <nav-bar :logged="auth.user" />
        <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder my-5">
            Check Order
        </h1>
        <div class="text-center mb-4">
            <div class="text-gray-400 text-xl font-bold bg-gray-800 rounded-lg md:w-3/12 w-6/12 mx-auto p-2 mb-1">
                <p>Welcome, <span class="text-yellow-500">{{orders.first_name}}</span></p>
            </div>
            <div dir="rtl" class="text-center text-gray-400 text-lg">
                <p>Order Date: <span class="tracking-widest">{{ moment(orders.created_at).format('YYYY/MM/DD') }}</span></p>
            </div>
            <div class="w-11/12 flex justify-center items-center mx-auto mt-5 mb-3">
                <div class="bg-gray-800 rounded-lg py-3 px-4 y-3 mx-4 border-gray-400 border-opacity-70 border-2">
                    <span>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100" height="100"
                            viewBox="0 0 512.008 512.008" style="enable-background:new 0 0 512.008 512.008;" xml:space="preserve">
                            <path style="fill:#FFD54F;" d="M175.992,128.008h160c8.832,0,16,7.168,16,16v176h-192v-176C159.992,135.176,167.16,128.008,175.992,128.008z"/>
                            <path style="fill:#FFC107;" d="M175.992,256.008h224c8.832,0,16,7.168,16,16v176h-256v-176C159.992,263.176,167.16,256.008,175.992,256.008z"/>
                            <path style="fill:#455A64;" d="M431.992,448.008H189.048c-4.832-13.568-15.488-24.224-29.056-29.056V80.008c0-4.256-1.696-8.32-4.672-11.328l-64-64c-6.24-6.24-16.384-6.24-22.624,0s-6.24,16.384,0,22.624l59.296,59.36v332.32c-18.592,6.624-32,24.224-32,45.056c0,26.432,21.536,47.968,48,47.968c20.832,0,38.432-13.408,45.056-32h242.944c8.832,0,16-7.168,16-16S440.824,448.008,431.992,448.008z"/>
                            <circle style="fill:#FAFAFA;" cx="143.992" cy="464.008" r="16"/>
                        </svg>
                    </span>
                    <div v-if="orders.state == 0">
                        <p Class="my-3 text-gray-400 cursor-default select-none">Preparing</p>
                        <div class="spinner-border text-yellow-500"></div> <!-- الانتظار -->
                    </div>
                    <div v-else>
                        <p Class="my-3 text-gray-400 cursor-default select-none">Preparing Done</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-yellow-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="80" height="80" class="filter brightness-75 animat">
                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="223.803" x2="223.803" y1="420.496" y2="240.496">
                        <stop offset="0" style="stop-color: rgb(245, 158, 11);"/>
                        <stop offset="1" stop-color="#fff1ff"/>
                    </linearGradient>
                    <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="256.001" x2="256.001" y1="336.497" y2="91.503" spreadMethod="pad" gradientTransform="matrix(0.999986, -0.005376, 0.007219, 1.342893, -0.656837, -29.999661)">
                        <stop offset="0" style="stop-color: rgb(245, 158, 11);"/>
                        <stop offset="1" style="stop-color: rgb(129, 255, 234); stop-opacity: 0.88;"/>
                    </linearGradient>
                    <g transform="matrix(-1, 0, 0, 1, 511.999634, 0)">
                        <g>
                        <g>
                            <path d="m235.623 304.891-60-60c-5.859-5.859-15.352-5.859-21.211 0l-150 150c-9.438 9.438-2.728 25.605 10.605 25.605h120c3.984 0 7.793-1.582 10.605-4.395l79.605-79.605zm151.983-60c-5.859-5.859-15.352-5.859-21.211 0l-150 150c-9.438 9.438-2.728 25.605 10.605 25.605h120c3.984 0 7.793-1.582 10.605-4.395l79.605-79.605 10.395-31.605z" fill="url(#SVGID_1_)"/>
                        </g>
                        </g>
                        <g>
                        <g>
                            <path d="m145.517 96.002c-2.699-3-6.599-4.499-10.499-4.499h-120c-13.187 0-20.183 16.461-10.499 25.499l220.499 219.494 70.499-70.501c6-5.7 6-15.3 0-21.001zm361.983 148.993-150-148.993c-2.699-3-6.599-4.499-10.499-4.499h-120.001c-13.187 0-20.183 16.461-10.499 25.499l220.499 219.495 70.499-70.501c6.001-5.701 6.001-15.301.001-21.001z" style="fill-rule: nonzero;" fill="url(#SVGID_2_)"/>
                        </g>
                        </g>
                    </g>
                </svg>
                <div :class="[orders.state == 1 ? '':'filter grayscale']" class="bg-gray-800 rounded-lg py-3 px-4 my-3 mx-4 border-gray-400 border-opacity-70 border-2">
                    <div v-if="orders.state == 0">
                        <span >
                            <svg width="100" height="100" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g id="Filled_stroke_cut_Ex" data-name="Filled stroke cut Ex"><g><path d="m400 312 54.426 54.426a60 60 0 0 1 17.574 42.427v49.147a30 30 0 0 1 -30 30h-26v-56h-16z" fill="#fa5d3f"/><path d="m120 464v-160l88-56h96l88 56v160z" fill="#fa5d3f"/><path d="m304 248-48 48-48-48 8-32h80z" fill="#ffd4cf"/><path d="m299.035 228.142-3.035-12.142h-80l-3.086 12.345 26.93 13.465a36 36 0 0 0 32.363-.082z" fill="#fbb8b0"/><path d="m332 120h-12v-32h-128v32h-12a20 20 0 0 0 -20 20v8a20 20 0 0 0 20 20h12v13.459a30 30 0 0 0 16.583 26.833l38.417 19.208a20 20 0 0 0 17.979-.045l38.575-19.534a30 30 0 0 0 16.446-26.765v-13.156h12a20 20 0 0 0 20-20v-8a20 20 0 0 0 -20-20z" fill="#ffd4cf"/><g><path d="m216 128h16v16h-16z"/><path d="m280 128h16v16h-16z"/></g><path d="m256 200c-13.458 0-24-8.785-24-20h16c0 1.41 3.037 4 8 4s8-2.59 8-4h16c0 11.215-10.542 20-24 20z"/><path d="m234 24h44a50 50 0 0 1 50 50v14a0 0 0 0 1 0 0h-144a0 0 0 0 1 0 0v-14a50 50 0 0 1 50-50z" fill="#fa5d3f"/><path d="m296.906 115.271-18.718-12.479a40 40 0 0 0 -44.376 0l-18.718 12.479a20 20 0 0 1 -31.094-16.641v-10.63l33.149-18.416a80 80 0 0 1 77.7 0l33.151 18.416v10.63a20 20 0 0 1 -31.094 16.641z" fill="#fac850"/><path d="m112 280h288v208h-288z" fill="#fac850"/><path d="m128 432h-32v56h88a56 56 0 0 0 -56-56z" fill="#ffd4cf"/><path d="m224 280h64v72h-64z" fill="#fa7d29"/><path d="m224 440h64v48h-64z" fill="#fa7d29"/><path d="m112 312-54.426 54.426a60 60 0 0 0 -17.574 42.427v49.147a30 30 0 0 0 30 30h26v-56h16z" fill="#fa5d3f"/><path d="m384 432h32v56h-88a56 56 0 0 1 56-56z" fill="#ffd4cf"/><path d="m136 304h16v16h-16z"/><path d="m168 304h32v16h-32z"/><path d="m136 336h64v16h-64z"/><path d="m340 312h28a0 0 0 0 1 0 0v20a20 20 0 0 1 -20 20h-28a0 0 0 0 1 0 0v-20a20 20 0 0 1 20-20z" fill="#fffffe"/><path d="m348 360h-28a8 8 0 0 1 -8-8v-20a28.032 28.032 0 0 1 28-28h28a8 8 0 0 1 8 8v20a28.032 28.032 0 0 1 -28 28zm-20-16h20a12.013 12.013 0 0 0 12-12v-12h-20a12.013 12.013 0 0 0 -12 12z"/><path d="m460.084 360.77-30.427-30.427-11.314 11.314 30.427 30.426a51.663 51.663 0 0 1 15.23 36.77v49.147a22.025 22.025 0 0 1 -22 22h-18v-40h16v-16h-32v-144a8 8 0 0 0 -8-8h-43.384l-45.629-29.037-6.622-26.487 2.8-1.419a37.818 37.818 0 0 0 20.835-33.901v-5.156h4a28.032 28.032 0 0 0 28-28v-8a28.033 28.033 0 0 0 -27.395-27.993 27.972 27.972 0 0 0 3.395-13.377v-24.63a58.066 58.066 0 0 0 -58-58h-44a58.066 58.066 0 0 0 -58 58v24.63a27.972 27.972 0 0 0 3.4 13.377 28.033 28.033 0 0 0 -27.4 27.993v8a28.032 28.032 0 0 0 28 28h4v5.459a37.792 37.792 0 0 0 21.006 33.988l2.566 1.283-6.559 26.233-45.629 29.037h-43.384a8 8 0 0 0 -8 8v28.686l-29.657 29.657 11.314 11.314 18.343-18.343v92.686h-32v16h16v40h-18a22.025 22.025 0 0 1 -22-22v-49.147a51.666 51.666 0 0 1 15.229-36.77l6.427-6.426-11.312-11.314-6.428 6.427a67.554 67.554 0 0 0 -19.916 48.083v49.147a38.043 38.043 0 0 0 38 38h372a38.043 38.043 0 0 0 38-38v-49.147a67.554 67.554 0 0 0 -19.916-48.083zm-228.084-72.77h48v56h-48zm59.314-16 13.805-13.8 21.694 13.8zm-92.976-162.79a11.827 11.827 0 0 1 -6.338-10.58v-5.923l29.033-16.13a71.581 71.581 0 0 1 69.934 0l29.033 16.13v5.923a12 12 0 0 1 -18.656 9.984l-18.718-12.478a47.871 47.871 0 0 0 -53.252 0l-18.718 12.478a11.828 11.828 0 0 1 -12.318.596zm145.662 30.79v8a12.013 12.013 0 0 1 -12 12h-4v-32h4a12.013 12.013 0 0 1 12 12zm-110-108h44a42.047 42.047 0 0 1 42 42v.4l-21.264-11.809a87.481 87.481 0 0 0 -85.472 0l-21.264 11.809v-.4a42.047 42.047 0 0 1 42-42zm-54 128a12.013 12.013 0 0 1 -12-12v-8a12.013 12.013 0 0 1 12-12h4v32zm20 21.459v-55.111a27.935 27.935 0 0 0 19.531-4.421l18.718-12.479a31.918 31.918 0 0 1 35.5 0l18.718 12.479a27.952 27.952 0 0 0 19.533 4.42v54.809a21.894 21.894 0 0 1 -12.062 19.627l-38.573 19.533a12.051 12.051 0 0 1 -10.788.028l-38.415-19.207a21.881 21.881 0 0 1 -12.162-19.678zm43.421 53.2a28.12 28.12 0 0 0 25.172-.064l21.133-10.7 5.415 21.657-26.455 26.448h-25.372l-26.455-26.454 5.372-21.486zm-36.54 23.54 13.805 13.801h-35.5zm-86.881 29.801h96v64a8 8 0 0 0 8 8h64a8 8 0 0 0 8-8v-64h96v136h-8a64.1 64.1 0 0 0 -63.5 56h-24.5v-40a8 8 0 0 0 -8-8h-64a8 8 0 0 0 -8 8v40h-24.5a64.1 64.1 0 0 0 -63.5-56h-8zm-16 192v-40h24a48.078 48.078 0 0 1 47.333 40zm128 0v-32h48v32zm176 0h-71.333a48.078 48.078 0 0 1 47.333-40h24z"/></g></g></svg>
                        </span>
                        <p class="mt-3 mb-2 text-gray-400 cursor-default select-none">Waiting</p>
                        <div class="spinner-grow text-yellow-500"></div>
                    </div>
                    <div v-else>
                        <span >
                            <svg width="100" height="100" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g id="Filled_stroke_cut_Ex" data-name="Filled stroke cut Ex"><g><path d="m400 312 54.426 54.426a60 60 0 0 1 17.574 42.427v49.147a30 30 0 0 1 -30 30h-26v-56h-16z" fill="#fa5d3f"/><path d="m120 464v-160l88-56h96l88 56v160z" fill="#fa5d3f"/><path d="m304 248-48 48-48-48 8-32h80z" fill="#ffd4cf"/><path d="m299.035 228.142-3.035-12.142h-80l-3.086 12.345 26.93 13.465a36 36 0 0 0 32.363-.082z" fill="#fbb8b0"/><path d="m332 120h-12v-32h-128v32h-12a20 20 0 0 0 -20 20v8a20 20 0 0 0 20 20h12v13.459a30 30 0 0 0 16.583 26.833l38.417 19.208a20 20 0 0 0 17.979-.045l38.575-19.534a30 30 0 0 0 16.446-26.765v-13.156h12a20 20 0 0 0 20-20v-8a20 20 0 0 0 -20-20z" fill="#ffd4cf"/><g><path d="m216 128h16v16h-16z"/><path d="m280 128h16v16h-16z"/></g><path d="m256 200c-13.458 0-24-8.785-24-20h16c0 1.41 3.037 4 8 4s8-2.59 8-4h16c0 11.215-10.542 20-24 20z"/><path d="m234 24h44a50 50 0 0 1 50 50v14a0 0 0 0 1 0 0h-144a0 0 0 0 1 0 0v-14a50 50 0 0 1 50-50z" fill="#fa5d3f"/><path d="m296.906 115.271-18.718-12.479a40 40 0 0 0 -44.376 0l-18.718 12.479a20 20 0 0 1 -31.094-16.641v-10.63l33.149-18.416a80 80 0 0 1 77.7 0l33.151 18.416v10.63a20 20 0 0 1 -31.094 16.641z" fill="#fac850"/><path d="m112 280h288v208h-288z" fill="#fac850"/><path d="m128 432h-32v56h88a56 56 0 0 0 -56-56z" fill="#ffd4cf"/><path d="m224 280h64v72h-64z" fill="#fa7d29"/><path d="m224 440h64v48h-64z" fill="#fa7d29"/><path d="m112 312-54.426 54.426a60 60 0 0 0 -17.574 42.427v49.147a30 30 0 0 0 30 30h26v-56h16z" fill="#fa5d3f"/><path d="m384 432h32v56h-88a56 56 0 0 1 56-56z" fill="#ffd4cf"/><path d="m136 304h16v16h-16z"/><path d="m168 304h32v16h-32z"/><path d="m136 336h64v16h-64z"/><path d="m340 312h28a0 0 0 0 1 0 0v20a20 20 0 0 1 -20 20h-28a0 0 0 0 1 0 0v-20a20 20 0 0 1 20-20z" fill="#fffffe"/><path d="m348 360h-28a8 8 0 0 1 -8-8v-20a28.032 28.032 0 0 1 28-28h28a8 8 0 0 1 8 8v20a28.032 28.032 0 0 1 -28 28zm-20-16h20a12.013 12.013 0 0 0 12-12v-12h-20a12.013 12.013 0 0 0 -12 12z"/><path d="m460.084 360.77-30.427-30.427-11.314 11.314 30.427 30.426a51.663 51.663 0 0 1 15.23 36.77v49.147a22.025 22.025 0 0 1 -22 22h-18v-40h16v-16h-32v-144a8 8 0 0 0 -8-8h-43.384l-45.629-29.037-6.622-26.487 2.8-1.419a37.818 37.818 0 0 0 20.835-33.901v-5.156h4a28.032 28.032 0 0 0 28-28v-8a28.033 28.033 0 0 0 -27.395-27.993 27.972 27.972 0 0 0 3.395-13.377v-24.63a58.066 58.066 0 0 0 -58-58h-44a58.066 58.066 0 0 0 -58 58v24.63a27.972 27.972 0 0 0 3.4 13.377 28.033 28.033 0 0 0 -27.4 27.993v8a28.032 28.032 0 0 0 28 28h4v5.459a37.792 37.792 0 0 0 21.006 33.988l2.566 1.283-6.559 26.233-45.629 29.037h-43.384a8 8 0 0 0 -8 8v28.686l-29.657 29.657 11.314 11.314 18.343-18.343v92.686h-32v16h16v40h-18a22.025 22.025 0 0 1 -22-22v-49.147a51.666 51.666 0 0 1 15.229-36.77l6.427-6.426-11.312-11.314-6.428 6.427a67.554 67.554 0 0 0 -19.916 48.083v49.147a38.043 38.043 0 0 0 38 38h372a38.043 38.043 0 0 0 38-38v-49.147a67.554 67.554 0 0 0 -19.916-48.083zm-228.084-72.77h48v56h-48zm59.314-16 13.805-13.8 21.694 13.8zm-92.976-162.79a11.827 11.827 0 0 1 -6.338-10.58v-5.923l29.033-16.13a71.581 71.581 0 0 1 69.934 0l29.033 16.13v5.923a12 12 0 0 1 -18.656 9.984l-18.718-12.478a47.871 47.871 0 0 0 -53.252 0l-18.718 12.478a11.828 11.828 0 0 1 -12.318.596zm145.662 30.79v8a12.013 12.013 0 0 1 -12 12h-4v-32h4a12.013 12.013 0 0 1 12 12zm-110-108h44a42.047 42.047 0 0 1 42 42v.4l-21.264-11.809a87.481 87.481 0 0 0 -85.472 0l-21.264 11.809v-.4a42.047 42.047 0 0 1 42-42zm-54 128a12.013 12.013 0 0 1 -12-12v-8a12.013 12.013 0 0 1 12-12h4v32zm20 21.459v-55.111a27.935 27.935 0 0 0 19.531-4.421l18.718-12.479a31.918 31.918 0 0 1 35.5 0l18.718 12.479a27.952 27.952 0 0 0 19.533 4.42v54.809a21.894 21.894 0 0 1 -12.062 19.627l-38.573 19.533a12.051 12.051 0 0 1 -10.788.028l-38.415-19.207a21.881 21.881 0 0 1 -12.162-19.678zm43.421 53.2a28.12 28.12 0 0 0 25.172-.064l21.133-10.7 5.415 21.657-26.455 26.448h-25.372l-26.455-26.454 5.372-21.486zm-36.54 23.54 13.805 13.801h-35.5zm-86.881 29.801h96v64a8 8 0 0 0 8 8h64a8 8 0 0 0 8-8v-64h96v136h-8a64.1 64.1 0 0 0 -63.5 56h-24.5v-40a8 8 0 0 0 -8-8h-64a8 8 0 0 0 -8 8v40h-24.5a64.1 64.1 0 0 0 -63.5-56h-8zm-16 192v-40h24a48.078 48.078 0 0 1 47.333 40zm128 0v-32h48v32zm176 0h-71.333a48.078 48.078 0 0 1 47.333-40h24z"/></g></g></svg>
                        </span>
                        <p Class="mt-3 mb-2 text-gray-400 cursor-default select-none">Prepared</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-yellow-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mx-auto lg:w-5/12 md:w-8/12 w-11/12 text-center text-lg font-medium text-gray-400 bg-gray-800 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 animate-bounce mx-auto text-yellow-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block float-right text-yellow-300 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <p class="text-base text-gray-400 text-right">7 days to receive your order</p>
                <br />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block float-right text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <p class="text-base text-gray-400">You can contact with out services if there is any late in your order</p>
                <br />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block float-right text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <p class="text-base text-gray-400">After preparing the order we will contact with you</p>
            </div>
        </div>
        <Footer />
  </div>
</template>

<script>
    import card from '@/Layouts/Template/Card'
    import navBar from '@/Layouts/Template/nav'
    import moment from 'moment'
    import 'moment/min/locales'
    import Footer from '@/Layouts/Template/footer'
    import pageTitle from "../Layouts/Template/pageTitle";

    export default {
        components:{
            card,
            navBar,
            moment,
            Footer,
            pageTitle,
        },
        props:{
            errors: Object,
            orders: Object,
            auth: Object,
        },
        data() {
            return {
                moment,
            }
        },
    }
</script>

<style>
    .headers::before, .headers::after{
        content: "";
        flex: 1 1;
        border-bottom: 2px solid #a7a7a7;
        margin: 20px;
        opacity: .3;
    }
    .swal2-container.swal2-center>.swal2-popup{
        display:block !important;
    }
    .animat{
    	animation: animat 1s infinite;
    }

@keyframes animat {
  0%, 100% {
    transform: translateX(10%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
  }
  50% {
    transform: translateX(-10%);
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
  }
}
</style>
