<template>
  <div>
    <div class="flex items-center p-4 border-b border-slate-900/10 lg:hidden dark:border-slate-50/[0.06]">
      <button type="button" class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300" @click="openLeftNav">
        <span class="sr-only">Navigation</span>
        <svg width="24" height="24">
          <path d="M5 6h14M5 12h14M5 18h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
        </svg>
      </button>
    </div>
    <div class="w-full flex px-[--layout-gap] pb-[--layout-gap] lg:px-[--layout-gap-lg] lg:pb-[--layout-gap-lg]">
      <div class="hidden lg:block inset-0 left-[max(0px,calc(50%-45rem))] right-auto w-[12rem] pb-10 pl-8 pr-6 overflow-y-auto">
        <nav id="nav" class="lg:text-sm lg:leading-6 relative">
          <ul>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 text-slate-700 dark:text-sky-400" href="/user">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>個人信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 text-sky-500 dark:text-sky-400" href="/user/vip">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>會員信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 font-medium text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300" href="/orders">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-indigo-200 dark:group-hover:bg-indigo-500 dark:bg-slate-800 dark:highlight-white/5"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                  <path d="m6 9 6-3 6 3v6l-6 3-6-3V9Z" class="fill-indigo-100 group-hover:fill-indigo-200 dark:fill-slate-400"></path>
                  <path d="m6 9 6 3v7l-6-3V9Z" class="fill-indigo-300 group-hover:fill-indigo-400 dark:group-hover:fill-indigo-300 dark:fill-slate-500"></path>
                  <path d="m18 9-6 3v7l6-3V9Z" class="fill-indigo-400 group-hover:fill-indigo-500 dark:group-hover:fill-indigo-400 dark:fill-slate-600"></path>
                </svg></div>個人訂單
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="lg:pl-[2.5rem] w-full">
        <div class="px-4 py-4">
          <figure class="rounded-xl p-8">
            <Avatar class="w-24 h-24 rounded-full mx-auto" :src="user.avatar" :gender="user.gender" />
            <div class="pt-6 mx-auto">
              <figcaption class="font-medium text-center">
                <div class="text-center">
                  {{user.name}}
                </div>
                <div class="inline-flex">
                  <template v-if="user.vip_type !== 'no'">
                    <template v-if="user.vip_type == 'vip'">
                      <img :src="vip" class="w-[5rem]">
                    </template>
                    <template v-if="user.vip_type == 'svip'">
                      <img :src="svip"  class="w-[5rem]">
                    </template>
                    有效期 {{ dayjs(user.vip_end_time).format('YYYY-MM-DD') }}
                  </template>
                  <template v-else>
                    非会员
                  </template>
                </div>
              </figcaption>
            </div>
          </figure>
          <section class="px-4 py-4">
            <div class="container mx-auto text-center">
              <h2 class="block antialiased tracking-normal font-sans text-4xl leading-[1.3] text-blue-gray-900 mb-4">會員開通</h2>
              <!--            <p class="block antialiased font-sans text-base leading-relaxed text-inherit mb-8 font-normal !text-gray-500">Check out our affordable pricing options for delicious meals.</p>-->
            </div>
            <div class="mt-12">
              <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md border border-blue-gray-100">
                  <div class="relative bg-clip-border mt-4 mx-4 rounded-xl overflow-hidden bg-transparent text-gray-700 shadow-none !m-0 p-6">
                    <h5 class="block antialiased tracking-normal font-sans text-xl leading-snug text-blue-gray-900 capitalize">普通會員</h5>
                    <p class="block antialiased font-sans text-sm leading-normal text-inherit font-normal !text-gray-500">會員有效期30天</p>
                    <h3 class="antialiased tracking-normal font-sans text-3xl leading-snug text-blue-gray-900 flex gap-1 mt-4">¥{{ vip_1 }}<span class="block antialiased tracking-normal font-sans text-base leading-relaxed text-blue-gray-900 -translate-y-0.5 self-end opacity-70"></span></h3>
                  </div>
                  <div class="p-6 border-t border-blue-gray-50">
                    <ul class="flex flex-col gap-3">
                      <li class="flex items-center gap-3 text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">最多加入5个开放的房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">可创建5个房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">會員有效期30天。</p>
                      </li>
                    </ul>
                    <a href="/user/vip/purch?type=1" class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-gray-400 hover:opacity-75 focus:ring focus:ring-green-200 active:opacity-[0.85] block w-full mt-6">立即加入</a>
                  </div>
                </div>
                <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md border border-blue-gray-100">
                  <div class="relative bg-clip-border mt-4 mx-4 rounded-xl overflow-hidden bg-transparent text-gray-700 shadow-none !m-0 p-6">
                    <h5 class="block antialiased tracking-normal font-sans text-xl leading-snug text-blue-gray-900 capitalize">普通會員</h5>
                    <p class="block antialiased font-sans text-sm leading-normal text-inherit font-normal !text-gray-500">會員有效期90天</p>
                    <h3 class="antialiased tracking-normal font-sans text-3xl leading-snug text-blue-gray-900 flex gap-1 mt-4">¥{{ vip_2 }}<span class="block antialiased tracking-normal font-sans text-base leading-relaxed text-blue-gray-900 -translate-y-0.5 self-end opacity-70"></span></h3>
                  </div>
                  <div class="p-6 border-t border-blue-gray-50">
                    <ul class="flex flex-col gap-3">
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">最多加入5个开放的房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">可创建5个房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">會員有效期90天。</p>
                      </li>
                    </ul>
                    <a href="/user/vip/purch?type=2" class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-gray-400 hover:opacity-75 focus:ring focus:ring-green-200 active:opacity-[0.85] block w-full mt-6">立即加入</a>
                  </div>
                </div>
                <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md border border-blue-gray-100">
                  <div class="relative bg-clip-border mt-4 mx-4 rounded-xl overflow-hidden bg-transparent text-gray-700 shadow-none !m-0 p-6">
                    <h5 class="block antialiased tracking-normal font-sans text-xl leading-snug text-blue-gray-900 capitalize">尊享會員</h5>
                    <p class="block antialiased font-sans text-sm leading-normal text-inherit font-normal !text-gray-500">尊享會員，會員有效期30天</p>
                    <h3 class="antialiased tracking-normal font-sans text-3xl leading-snug text-blue-gray-900 flex gap-1 mt-4">¥{{ vip_3 }}<span class="block antialiased tracking-normal font-sans text-base leading-relaxed text-blue-gray-900 -translate-y-0.5 self-end opacity-70"></span></h3>
                  </div>
                  <div class="p-6 border-t border-blue-gray-50">
                    <ul class="flex flex-col gap-3">
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">可任意加入开放的房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">可创建10个房间。</p>
                      </li>
                      <li class="flex items-center gap-3 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                      </svg>
                        <p class="block antialiased font-sans text-sm leading-normal font-normal text-inherit">尊享會員，會員有效期30天。</p>
                      </li>
                    </ul>
                    <a href="/user/vip/purch?type=3" class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-gray-400 hover:opacity-75 focus:ring focus:ring-green-200 active:opacity-[0.85] block w-full mt-6">立即加入</a>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <TransitionRoot appear :show="isLeftNavOpen" as="template">
      <Dialog as="div" @close="closeLeftNav" class="fixed z-50 inset-0 overflow-y-auto lg:hidden">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/20 backdrop-blur-sm dark:bg-slate-900/80" />
        </TransitionChild>

        <div class="relative bg-blue-950/50 w-80 max-w-[calc(100%-3rem)] h-full p-6 dark:bg-slate-800">
          <button @click="closeLeftNav" type="button" class="absolute z-10 top-5 right-5 w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300">
            <span class="sr-only">Close navigation</span>
            <BeakerIcon class="size-6 text-blue-500" />
            <svg viewBox="0 0 10 10" class="w-2.5 h-2.5 overflow-visible"><path d="M0 0L10 10M10 0L0 10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>
          </button>
          <nav id="nav" class="lg:text-sm lg:leading-6 relative ">
            <ul>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 text-sky-500" href="/user">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                    </svg>
                  </div>個人信息
                </a>
              </li>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/user/vip">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                    </svg>
                  </div>會員信息
                </a>
              </li>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/orders">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-indigo-200 dark:group-hover:bg-indigo-500 dark:bg-slate-800 dark:highlight-white/5"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="m6 9 6-3 6 3v6l-6 3-6-3V9Z" class="fill-indigo-100 group-hover:fill-indigo-200 dark:fill-slate-400"></path>
                    <path d="m6 9 6 3v7l-6-3V9Z" class="fill-indigo-300 group-hover:fill-indigo-400 dark:group-hover:fill-indigo-300 dark:fill-slate-500"></path>
                    <path d="m18 9-6 3v7l6-3V9Z" class="fill-indigo-400 group-hover:fill-indigo-500 dark:group-hover:fill-indigo-400 dark:fill-slate-600"></path>
                  </svg></div>個人訂單
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup lang="ts">
import dayjs from 'dayjs'

const { user } = useAuth();

import vip from '@/images/vip.png';
import svip from '@/images/svip.png';
const props = defineProps<{
  vip_1: number,
  vip_2: number,
  vip_3: number,
}>()

const isLeftNavOpen = ref(false)

function closeLeftNav() {
  isLeftNavOpen.value = false
}
function openLeftNav() {
  isLeftNavOpen.value = true
}
</script>
