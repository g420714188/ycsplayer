<template>
  <div class="relative h-full px-[--layout-gap] pb-[--layout-gap] lg:px-[--layout-gap-lg] lg:pb-[--layout-gap-lg]">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl">點播大廳</h1>
      <div>
        <button
          v-if="can.create"
          type="button"
          class="btn btn-primary"
          @click="showRoomModal = true"
        >
          <HeroiconsPlus class="w-4 h-4 mr-1" />
          創建房間
        </button>
      </div>
    </div>
<!--    <div class="flex flex-col gap-[&#45;&#45;layout-gap] md:grid md:grid-cols-12 lg:gap-[&#45;&#45;layout-gap-lg] h-full">-->
      <div class="min-h-0 shrink-0 md:col-span-8 lg:col-span-9">
        <div class="mt-4">
          <div v-if="rooms.data.length" class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            <div v-for="room in rooms.data" :key="room.id">
              <Link :href="`/rooms/${room.id}`" class="block p-4 bg-blue-950/50 hover:bg-blue-900/50 rounded-lg transition-colors lg:p-5">
                <img :src="room.room_cover" class="w-40 max-w-[100%] lg:w-full shrink-0 rounded-lg aspect-video object-cover">
                <span class="text-l">{{ room.name }}</span>
                <div  class="flex -space-x-2 overflow-hidden mt-1">
                  <img :src="defaultMan" class="inline-block h-8 w-8 rounded-full">
                  <img :src="defaultWomen" class="inline-block h-8 w-8 rounded-full">
                </div>
              </Link>
            </div>
          </div>

          <div v-else class="py-32 flex justify-center items-center bg-blue-950/50 text-center text-lg rounded-lg">
            現在還沒有加入房間喔！<br>趕快加入跟朋友一起看影片、聽音樂吧~
          </div>

          <Pagination :collection="rooms" class="mt-4" />
        </div>
      </div>
<!--      <div class="grow min-h-0 flex flex-col gap-y-[&#45;&#45;layout-gap] md:col-span-4 lg:col-span-3">-->
<!--      </div>-->
<!--    </div>-->

    <!-- Footer -->
    <!-- <Footer class="mt-10" /> -->
    <div class="pb-[88px] sm:pb-[72px]" />
    <Footer class="absolute inset-x-[--layout-gap] bottom-[--layout-gap] lg:inset-x-[--layout-gap-lg] lg:bottom-[--layout-gap-lg]" />
    <RoomFormModal v-if="can.create" v-model="showRoomModal" />
  </div>
</template>

<script setup lang="ts">
import type { Room } from '@/types'

import defaultMan from '@/images/man.svg';
import defaultWomen from '@/images/women.svg';

defineOptions({ inheritAttrs: false })

defineProps<{
  rooms: Paginator<Room>
  can: {
    create: boolean
  }
}>()

const { user: authUser } = useAuth()

useFullPage(true, {
  baseClass: 'min-full-page',
  scroll: true,
})

const showRoomModal = ref(false)
</script>
