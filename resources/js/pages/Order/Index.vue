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
    <div class="w-full flex px-4 sm:px-6 md:px-8 md:overflow-auto sm:overflow-auto lg:overflow-auto">
      <div class="hidden lg:block z-20 inset-0 left-[max(0px,calc(50%-45rem))] right-auto w-[12rem] pb-10 pl-8 pr-6 overflow-y-auto">
        <nav id="nav" class="lg:text-sm lg:leading-6 relative">
          <ul>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 font-semibold text-slate-700 dark:text-sky-400" href="/user">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>個人信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 font-semibold text-slate-700 dark:text-sky-400" href="/user/vip">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>會員信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 font-medium text-sky-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300" href="/orders">
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
        <div class="mx-auto xl:max-w-none xl:ml-0 xl:pr-16">
          <header id="header" class="relative z-20">
            <div>
              <p class="mb-2 text-sm leading-6 dark:text-sky-400">個人訂單列表</p>
            </div>
          </header>
          <div class="relative lg:px-4">
            <div id="class-table" class="flex-none w-full lg:px-4 md:overflow-auto sm:overflow-auto lg:overflow-auto scrollbar:!w-1.5 scrollbar:!h-1.5 scrollbar:bg-transparent scrollbar-track:!bg-slate-100 scrollbar-thumb:!rounded scrollbar-thumb:!bg-slate-300 scrollbar-track:!rounded dark:scrollbar-track:!bg-slate-500/[0.16] dark:scrollbar-thumb:!bg-slate-500/50 lg:supports-scrollbars:pr-2">
              <table class="text-left w-full">
                <thead>
                <tr>
                  <th class="w-1/4 top-0 text-sm leading-6 p-0 dark:bg-slate-900 dark:text-sky-400">
                    <div class="py-2 pl-2 border-b border-slate-200 dark:border-slate-400/20">交易時間</div>
                  </th>
                  <th class="w-1/4 top-0 text-xs leading-6 p-0 dark:bg-slate-900 dark:text-sky-400">
                    <div class="py-2 pl-2 border-b border-slate-200 dark:border-slate-400/20">內容</div>
                  </th>
                  <th class="w-1/4 top-0 text-xs leading-6 p-0 dark:bg-slate-900 dark:text-sky-400">
                    <div class="py-2 pl-2 border-b border-slate-200 dark:border-slate-400/20">金额</div>
                  </th>
                  <th class="w-1/4 top-0 text-xs leading-6 p-0 dark:bg-slate-900 dark:text-sky-400">
                    <div class="py-2 pl-2 border-b border-slate-200 dark:border-slate-400/20">状态</div>
                  </th>
                </tr>
                </thead>
                <tbody class="align-baseline">
                <tr v-for="row in record.data" :key="row.id" class="border-b">
                  <td class="py-2 pl-2 font-mono text-xs leading-6 whitespace-pre dark:text-indigo-300">
                    {{ dayjs(row.created_at).format('YYYY-MM-DD HH:mm:ss') }}
                  </td>
                  <td class="py-2 pl-2 font-mono text-xs leading-6 whitespace-pre dark:text-indigo-300">
                    {{row.name}}
                  </td>
                  <td class="py-2 pl-2 font-mono text-xs leading-6 whitespace-pre dark:text-indigo-300">
                    ¥{{row.money}}
                  </td>
                  <td class="py-2 pl-2 font-mono text-xs leading-6 whitespace-pre dark:text-indigo-300">
                    {{ tradeStateText(row.trade_status)}}
                  </td>
                </tr>
                </tbody>
              </table>
              <!--                  <div class="sticky bottom-0 h-px -mt-px bg-slate-200 dark:bg-slate-400/20"></div>-->
            </div>
            <Pagination :collection="record" class="mt-4" />
          </div>
          <footer class="text-sm leading-6 mt-12">
          </footer>
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
const { user } = useAuth()

const props = defineProps<{
  record: any | null
}>()

const tradeStateText=computed(()=>(val:number)=>{
  if(val ==0 ){ return '未支付';}
  if(val ==1 ){ return '支付完成';}
  if(val ==2 ){ return '支付失败';}
});

const isLeftNavOpen = ref(false)

function closeLeftNav() {
  isLeftNavOpen.value = false
}
function openLeftNav() {
  isLeftNavOpen.value = true
}
</script>
