<template>
  <div class="relative h-full px-[--layout-gap] pb-[--layout-gap] lg:px-[--layout-gap-lg] lg:pb-[--layout-gap-lg]">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl">我的房間列表</h1>
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

        <Link :href="`/home`" class="block p-4 bg-blue-950/50 hover:bg-blue-900/50 rounded-lg transition-colors lg:p-6">
          影音大廳看看
        </Link>
      </div>

      <Pagination :collection="rooms" class="mt-4" />
    </div>

    <!-- Footer -->
    <!-- <Footer class="mt-10" /> -->
    <div class="pb-[88px] sm:pb-[72px]" />
    <Footer class="absolute inset-x-[--layout-gap] bottom-[--layout-gap] lg:inset-x-[--layout-gap-lg] lg:bottom-[--layout-gap-lg]" />

    <RoomFormModal v-if="can.create" v-model="showRoomModal" />
  </div>
</template>

<script setup lang="ts">
import type { Room } from '@/types'

import roomBg from '@/images/room_bg.png';

import defaultMan from '@/images/man.svg';
import defaultWomen from '@/images/women.svg';

defineOptions({ inheritAttrs: false })

defineProps<{
  rooms: Paginator<Room>
  can: {
    create: boolean
  }
}>()

useFullPage(true, {
  baseClass: 'min-full-page',
  scroll: true,
})

const showRoomModal = ref(false)
</script>
